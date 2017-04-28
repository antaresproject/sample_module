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

namespace Antares\SampleModule\Widgets;

use Antares\Widgets\Templates\ChartTemplate;

class GraphBarWidget extends ChartTemplate
{

    /**
     * name of widget
     * 
     * @var String 
     */
    public $name = 'Graph 2';

    /**
     * Title of widget
     * 
     * @var String 
     */
    public $title = 'Graph 2';

    /**
     * Widget data
     *
     * @var array
     */
    protected $data = [
        'data_1' => [135, 198],
        'data_2' => [15, 52],
        'data_3' => [33, 51],
        'data_4' => [31, 71],
        'data_5' => [66, 81],
        'data_6' => [66, 81],
        'data_7' => [135, 198],
        'data_8' => [641, 998],
    ];

    /**
     * widget attributes
     *
     * @var array
     */
    protected $attributes = [
        'min_width'      => 6,
        'min_height'     => 10,
        'max_width'      => 14,
        'max_height'     => 20,
        'default_width'  => 6,
        'default_height' => 10,
        'enlargeable'    => true,
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
     * render widget content
     * 
     * @return String | mixed
     */
    public function render()
    {
        app('antares.asset')->container('antares/foundation::application')->add('webpack_view_charts', '/webpack/view_charts.js', ['webpack_gridstack']);
        return view('antares/sample_module::widgets.graph_4', ['data' => $this->data])->render();
    }

}
