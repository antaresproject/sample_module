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
 * @version    0.9.0
 * @author     Antares Team
 * @license    BSD License (3-clause)
 * @copyright  (c) 2017, Antares
 * @link       http://antaresproject.io
 */

namespace Antares\Modules\SampleModule\Http\Breadcrumb;

use Antares\Modules\SampleModule\Model\ModuleRow as Model;
use Antares\Breadcrumb\Navigation;

class ItemsBreadcrumb extends Navigation
{

    /**
     * Name of breadcrumb primary key
     *
     * @var String 
     */
    protected static $name = 'items';

    /**
     * On item list
     */
    public function itemsList()
    {
        $this->breadcrumbs->register(self::$name, function($breadcrumbs) {
            $breadcrumbs->push('Items', handles('antares::sample_module/index'));
        });
        $this->shareOnView(self::$name);
    }

    /**
     * On item create or edit
     * 
     * @param Model $model
     */
    public function onItem(Model $model)
    {
        $this->itemsList();
        $this->breadcrumbs->register('item', function($breadcrumbs) use($model) {
            $name = $model->exists ? trans('antares/sample_module::messages.breadcrumb.item_edit', ['name' => $model->name]) : trans('antares/sample_module::messages.breadcrumb.item_add');
            $breadcrumbs->parent(self::$name);
            $breadcrumbs->push($name);
        });

        $this->shareOnView('item');
    }

    /**
     * On module configuration
     */
    public function onConfiguration()
    {
        $this->breadcrumbs->register('sample-module-configuration', function($breadcrumbs) {
            $breadcrumbs->push('Sample module configuration');
        });

        $this->shareOnView('sample-module-configuration');
    }

}
