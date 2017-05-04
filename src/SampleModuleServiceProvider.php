<?php

/**
 * Part of the Antares Project package.
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the 3-clause BSD License.
 *
 * This source file is subject to the 3-clause BSD License that is
 * bundled with this package in the LICENSE file.
 *
 * @package    Module
 * @version    0.9.0
 * @author     Antares Team
 * @license    BSD License (3-clause)
 * @copyright  (c) 2017, Antares Project
 * @link       http://antaresproject.io
 */

namespace Antares\SampleModule;

use Antares\Foundation\Support\Providers\ModuleServiceProvider;
use Antares\SampleModule\Http\Handler\ModuleBreadcrumbMenu;
use Antares\SampleModule\Http\Handler\ModuleMainMenu;
use Antares\SampleModule\Http\Handler\ModulePaneMenu;
use Antares\SampleModule\Console\ModuleCommand;
use Antares\Control\Http\Handlers\ControlPane;

class SampleModuleServiceProvider extends ModuleServiceProvider
{

    /**
     * Przestrzeń nazw dla kontrollerów
     *
     * @var String
     */
    protected $namespace = 'Antares\SampleModule\Http\Controllers\Admin';

    /**
     * Nazwa grupy routingu w obrębie której będzie pracował komponent
     *
     * @var string|null
     */
    protected $routeGroup = 'antares/sample_module';

    /**
     * Lista eventów na które nasłuchują klasy komponentu
     *
     * @var array
     */
    protected $listen = [
        'antares.ready: admin' => [ModuleMainMenu::class],
    ];

    /**
     * Zarejestrowanie service providera
     */
    public function register()
    {
        parent::register();
        $this->commands([ModuleCommand::class]);
    }

    /**
     * {@inheritdoc}
     */
    protected function bootExtensionComponents()
    {
        $path = __DIR__ . '/../resources';

        $this->addConfigComponent('antares/sample_module', 'antares/sample_module', "{$path}/config");
        $this->addLanguageComponent('antares/sample_module', 'antares/sample_module', "{$path}/lang");
        $this->addViewComponent('antares/sample_module', 'antares/sample_module', "{$path}/views");
        $this->attachMenu(ModuleBreadcrumbMenu::class);
        $this->bootMemory();

        listen('datatables:admin/users/index:after.status', function($datatables) {
            if ($datatables instanceof \Antares\Datatables\Html\Builder) {
                $datatables->collection->push(new \Yajra\Datatables\Html\Column([
                    'data'  => 'sample_module',
                    'name'  => 'sample_module',
                    'title' => 'Sample Module Items'
                ]));
            }
        });
        listen("datatables.value.*", function($name, array $params = []) {
            if (empty($params)) {
                return;
            }
            $datatables = $params[0];

            $datatables->editColumn('sample_module', function($model) {
                if (!$model instanceof \Antares\Model\User) {
                    return;
                }
                return Model\ModuleRow::query()->where('user_id', $model->id)->count();
            });
        });
        view()->composer('antares/sample_module::admin.configuration', ControlPane::class);
        listen('antares.ready: menu.after.general-settings', ModulePaneMenu::class);
        listen('breadcrumb.before.render.user-view', function($menu) {
            $attributes = $menu->getAttributes();
            $childs     = [
                'sample-module-user' => new \Antares\Support\Fluent([
                    "icon"   => 'zmdi-plus',
                    "link"   => handles('antares::sample_module/index/create'),
                    "title"  => 'Add Item (Sample Module)',
                    "id"     => 'sample-module-add',
                    "childs" => []])
            ];
            array_set($attributes, 'childs', array_merge($childs, $attributes['childs']));
            $menu->offsetSet('attributes', $attributes);
        });
        $this->app->make('antares.notifications')->push([
            'antaresproject/component-sample_module' => [
                'variables' => [
                    'items' => [
                        'dataProvider' => 'Antares\SampleModule\Model\ModuleRow@items'
                    ],
                ]
            ]
        ]);
        listen('after.activated.antaresproject/component-sample_module', function() {
            \Illuminate\Support\Facades\Artisan::call('automation:sync');
        });
    }

    /**
     * Boot extension routing.
     *
     * @return void
     */
    protected function loadRoutes()
    {
        $this->loadBackendRoutesFrom(__DIR__ . "/backend.php");
    }

    /**
     * booting events
     */
    protected function bootMemory()
    {
        $this->app->make('antares.acl')->make('antares/sample_module')->attach($this->app->make('antares.platform.memory'));
    }

}
