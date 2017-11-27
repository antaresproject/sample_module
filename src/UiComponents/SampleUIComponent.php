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
        'min_height'     => 14,
        'max_width'      => 14,
        'max_height'     => 20,
        'default_width'  => 6,
        'default_height' => 14,
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
