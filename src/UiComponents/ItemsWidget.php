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

namespace Antares\Logger\Widgets;

use Antares\Modules\SampleModule\Http\Datatables\ModuleDatatable;
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
        'min_width'      => 1,
        'min_height'     => 1,
        'max_width'      => 52,
        'max_height'     => 52,
        'default_width'  => 10,
        'default_height' => 18,
        'enlargeable'    => true,
        'titlable'       => true,
        'card_class'     => 'card--logs'
    ];
    protected $view       = 'antares/sample_module::ui_components.items';

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
     * Renders widget content
     * 
     * @return String | mixed
     */
    public function render()
    {
        $uid   = from_route('user');
        $table = app(ModuleDatatable::class)
                ->setUser($uid)
                ->html(handles('antares::sample_module/index/' . $uid));

        return view($this->view, ['dataTable' => $table]);
    }

}
