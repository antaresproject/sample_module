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

namespace Antares\Modules\SampleModule\Http\Handler;

use Antares\Foundation\Support\MenuHandler;
use Antares\Contracts\Authorization\Authorization;

class ModuleBreadcrumbMenu extends MenuHandler
{

    /**
     * Menu configuration.
     *
     * @var array
     */
    protected $menu = [
        'id'    => 'module-breadcrumb',
        'title' => 'Sample Module',
        'link'  => 'antares::sample_module/index',
        'icon'  => null,
        'boot'  => [
            'group' => 'menu.top.module',
            'on'    => 'antares/sample_module::admin.module.index'
        ]
    ];

    /**
     * Check authorization to display the menu.
     * @param  \Antares\Contracts\Authorization\Authorization  $acl
     * @return bool
     */
    public function authorize(Authorization $acl)
    {
        return app('antares.acl')->make('antares/sample_module')->can('index-action');
    }

    /**
     * Metoda wyzwalna podczas renderowania widoku i dodająca budująca menu jako submenu breadcrumbs
     * 
     * @return void
     */
    public function handle()
    {
        if (!$this->passesAuthorization()) {
            return;
        }
        $this->createMenu();
        if (!app('antares.acl')->make('antares/sample_module')->can('index-action')) {
            return;
        }
        $this->handler
                ->add('module-add', '^:module-breadcrumb')
                ->title('Add Item')
                ->icon('zmdi-plus-circle')
                ->link(handles('antares::sample_module/index/create'));
    }

}
