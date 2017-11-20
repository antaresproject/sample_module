<?php

/**
 * Part of the Antares package.
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the 3-clause BSD License.
 *
 * This source file is subject to the 3-clause BSD License that is
 * bundled with this package in the LICENSE file.
 *
 * @package    Module
 * @version    0.9.2
 * @author     Antares Team
 * @license    BSD License (3-clause)
 * @copyright  (c) 2017, Antares
 * @link       http://antaresproject.io
 */

namespace Antares\Modules\SampleModule;

use Antares\Foundation\Support\Providers\ModuleServiceProvider;
use Antares\Model\User;
use Antares\Modules\SampleModule\Events\ItemCreated;
use Antares\Modules\SampleModule\Events\ItemDeleted;
use Antares\Modules\SampleModule\Events\ItemNotCreated;
use Antares\Modules\SampleModule\Events\ItemNotDeleted;
use Antares\Modules\SampleModule\Events\ItemNotUpdated;
use Antares\Modules\SampleModule\Events\ItemUpdated;
use Antares\Modules\SampleModule\Http\Handler\ModuleBreadcrumbMenu;
use Antares\Modules\SampleModule\Http\Handler\ModuleMainMenu;
use Antares\Modules\SampleModule\Http\Handler\ModulePaneMenu;
use Antares\Modules\SampleModule\Console\ModuleCommand;
use Antares\Acl\Http\Handlers\ControlPane;
use Antares\Modules\SampleModule\Model\ModuleRow;
use Antares\Notifications\Helpers\NotificationsEventHelper;
use Antares\Notifications\Services\VariablesService;

class SampleModuleServiceProvider extends ModuleServiceProvider
{

    /**
     * Przestrzeń nazw dla kontrollerów
     *
     * @var String
     */
    protected $namespace = 'Antares\Modules\SampleModule\Http\Controllers\Admin';

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

        listen('after.activated.antaresproject/module-sample_module', function() {
            \Artisan::call('automation:sync');

            \Artisan::call('notifications:import', [
                'extension' => 'antaresproject/module-sample_module'
            ]);
        });
        listen('datatables.order.sample_module', function($query, $direction) {
            return $query;
        });
    }

    /**
     * Boot after all extensions booted.
     */
    public function booted() {
        /* @var $notification VariablesService */
        $notification = app()->make(VariablesService::class);

        /**
         * Simulates model for notification tests
         *
         * @return ModuleRow
         */
        $fakedModuleRow = function() {
            $faker = \Faker\Factory::create();
            $module = new ModuleRow();

            $module->id = $faker->randomDigitNotNull;
            $module->name = $faker->text(20);

            return $module;
        };

        /**
         * Registers variable of ModuleRow model to the 'module-sample' group with defined attributes.
         */
        $notification
            ->register('module-sample')
            ->modelDefinition('moduleRow', ModuleRow::class, $fakedModuleRow)
            ->setAttributes([
                'id'    => 'ID',
                'name'  => 'Name',
            ]);

        $adminRecipient = function() {
            return User::administrators()->get();
        };

        NotificationsEventHelper::make()
            ->event(ItemCreated::class, 'Sample Module', 'When module item is created')
            ->addAdminRecipient($adminRecipient)
            ->register()
            ->event(ItemUpdated::class, 'Sample Module', 'When module item is updated')
            ->addAdminRecipient($adminRecipient)
            ->register()
            ->event(ItemDeleted::class, 'Sample Module', 'When module item is deleted')
            ->addAdminRecipient($adminRecipient)
            ->register()
            ->event(ItemNotCreated::class, 'Sample Module', 'When module item not created')
            ->addAdminRecipient($adminRecipient)
            ->register()
            ->event(ItemNotUpdated::class, 'Sample Module', 'When module item not updated')
            ->addAdminRecipient($adminRecipient)
            ->register()
            ->event(ItemNotDeleted::class, 'Sample Module') // Label will be get from class name and it will be named (in this case) Item Not Deleted.
            ->addAdminRecipient($adminRecipient)
            ->register();
    }

    /**
     * Boot extension routing.
     *
     * @return void
     */
    protected function loadRoutes()
    {
        $this->loadBackendRoutesFrom(__DIR__ . "/backend.php");
        $this->loadFrontendRoutesFrom(__DIR__ . "/frontend.php");
    }

    /**
     * booting events
     */
    protected function bootMemory()
    {
        $this->app->make('antares.acl')->make('antares/sample_module')->attach($this->app->make('antares.platform.memory'));
    }

}
