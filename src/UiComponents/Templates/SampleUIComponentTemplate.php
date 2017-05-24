<?php

namespace Antares\Modules\SampleModule\UiComponents\Templates;

use Antares\UI\UIComponents\Templates\DefaultTemplate;

class SampleUIComponentTemplate extends DefaultTemplate
{

    /**
     * Path of template view
     *
     * @var String
     */
    protected $template = 'antares/sample_module::ui_components.templates.sample_template';

    /**
     * Ui Component Template attributes
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
     * {@inherited}
     */
    public function render()
    {
        
    }

}
