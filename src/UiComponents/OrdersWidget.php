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

namespace Antares\Modules\SampleModule\UiComponents;

use Antares\UI\UIComponents\Templates\Chart;

class OrdersWidget extends Chart
{

    /**
     * Name of widget
     * 
     * @var String 
     */
    public $name = 'Graph 1';

    /**
     * widget attributes
     *
     * @var array
     */
    protected $attributes = [
        'min_width'      => 2,
        'min_height'     => 2,
        'max_width'      => 52,
        'max_height'     => 52,
        'default_width'  => 12,
        'default_height' => 12,
        'enlargeable'    => true,
        'disabled'       => false,
    ];

    /**
     * Where widget should be disabled 
     *
     * @var array
     */
    protected $views = [
        'antares/foundation::dashboard.index'
    ];

    /**
     * Template for widget
     *
     * @var String
     */
    protected $template = 'empty';

    /**
     * Renders widget content
     * 
     * @return String | mixed
     */
    public function render()
    {
        app('antares.asset')->container('antares/foundation::application')->add('webpack_view_charts', '/webpack/view_widgets_html.js', ['webpack_gridstack']);

        return view('antares/sample_module::ui_components.orders')->render();
    }

}
