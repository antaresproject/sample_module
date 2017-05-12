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

namespace Antares\Logger\Widgets;

use Antares\SampleModule\Http\Datatables\ModuleDatatable;
use Antares\UI\UIComponents\Templates\Datatables;
use Illuminate\Support\Facades\Route;

class ItemsWidget extends Datatables
{

    /**
     * @var String
     */
    public $name = 'Items Widget';

    /**
     * Where widget should be available 
     *
     * @var array
     */
    protected $views = [
        'antares/foundation::admin.users.show'
    ];

    /**
     * widget attributes
     * 
     * @var array
     */
    protected $attributes = [
        'titlable'       => false,
        'editable'       => false,
        'nestable'       => false,
        'min_width'      => 2,
        'min_height'     => 7,
        'max_width'      => 12,
        'max_height'     => 52,
        'default_width'  => 10,
        'default_height' => 25,
        'enlargeable'    => true,
        'titlable'       => true,
        'card_class'     => 'card--logs'
    ];

    /**
     * widget routes definition
     * 
     * @return \Symfony\Component\Routing\Router
     */
    public static function routes()
    {
        Route::post('items', ['middleware' => 'web', function() {
                //return app(AdministratorsDatatables::class)->ajax(['width' => $width, 'height' => $height]);
            }]);
    }

    /**
     * render widget content
     * 
     * @return String | mixed
     */
    public function render()
    {
        $table = app(ModuleDatatable::class)->setUser(from_route('user'))->html();
        return view('antares/sample_module::widgets.items', ['dataTable' => $table]);
    }

}
