<?php

namespace Antares\Modules\SampleModule\UiComponents;

use Antares\Modules\SampleModule\UiComponents\Templates\SampleUIComponentTemplate;

class SampleUIComponent extends SampleUIComponentTemplate
{

    /**
     * Name of UI Component
     * 
     * @var String 
     */
    public $name = 'Sample UI Component';

    /**
     * widget attributes
     *
     * @var array
     */
    protected $attributes = [
        'min_width'      => 6,
        'min_height'     => 6,
        'max_width'      => 52,
        'max_height'     => 52,
        'x'              => 0,
        'y'              => 12,
        'default_width'  => 6,
        'default_height' => 6,
        'tablet'         => [0, 24, 24, 6],
        'mobile'         => [0, 24, 24, 6]
    ];

    /**
     * Where ui component should be available
     *
     * @var array
     */
    protected $views = [
        'antares/foundation::dashboard.index'
    ];

    /**
     * Renders ui component template content
     * 
     * @return String | mixed
     */
    public function render()
    {
        return view('antares/sample_module::ui_components.sample_ui_component')->render();
    }

}
