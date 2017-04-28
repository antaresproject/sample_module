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
use Antares\SampleModule\Console\UpProcessesCommand;
use Antares\SampleModule\Console\ModuleCommand;
use Antares\SampleModule\Console\ResetCommand;

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
        $this->commands([ModuleCommand::class, ResetCommand::class, UpProcessesCommand::class]);
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
        listen('datatables:admin/users/index:after.id', function($datatables) {
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
                $entity = Model\ModuleRow::query()->where('user_id', $model->id)->first();
                return defaults($entity, 'name');
            });
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
