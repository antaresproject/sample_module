<?php

namespace Antares\SampleModule\Http\Handler;

use Antares\Contracts\Auth\Guard;
use Antares\Foundation\Support\MenuHandler;

class ModulePaneMenu extends MenuHandler
{

    protected static $hasHandled = false;

    /**
     * Menu configuration.
     *
     * @var array
     */
    protected $menu = [
        'id'       => 'sample-module-configuration',
        'link'     => 'antares::sample_module/configuration',
        'position' => '>:general-settings',
        'icon'     => 'zmdi-settings-square',
    ];

    /**
     * Returns the title.
     *
     * @return string
     */
    public function getTitleAttribute()
    {
        return trans('antares/sample_module::messages.title');
    }

    /**
     * Returns the element position.
     *
     * @return string
     */
    public function getPositionAttribute()
    {
        return false;
    }

    /**
     * Check whether the menu should be displayed.
     *
     * @param Guard $auth
     * @return bool
     */
    public function authorize(Guard $auth)
    {
        return app('antares.acl')->make('antares/sample_module')->can('add-action');
    }

}
