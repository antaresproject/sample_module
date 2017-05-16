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

namespace Antares\Modules\SampleModule\Http\Handler;

use Antares\Foundation\Support\MenuHandler;

class ModuleMainMenu extends MenuHandler
{

    /**
     * Konfiguracja
     *
     * @var array
     */
    protected $menu = [
        'id'       => 'module',
        'position' => '>:home',
        'link'     => 'antares::sample_module/index',
        'icon'     => 'zmdi-star-outline',
    ];

    /**
     * {@inheritdoc}
     */
    public function getTitleAttribute()
    {
        return trans('antares/sample_module::messages.title');
    }

    /**
     * Weryfikacja dostępu acl
     * 
     * @return bool
     */
    public function authorize()
    {
        return app('antares.acl')->make('antares/sample_module')->can('index-action');
    }

}
