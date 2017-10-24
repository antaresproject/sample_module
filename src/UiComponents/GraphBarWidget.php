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

class GraphBarWidget extends Chart
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
        'min_height'     => 6,
        'max_width'      => 28,
        'max_height'     => 40,
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
     * Renders ui component content
     * 
     * @return String | mixed
     */
    public function render()
    {
        return view('antares/sample_module::ui_components.graph_4', ['data' => $this->data])->render();
    }

}
