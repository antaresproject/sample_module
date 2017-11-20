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

namespace Antares\Modules\SampleModule\Http\Handler;

use Antares\Foundation\Http\Composers\LeftPane;

class ModulePane extends LeftPane
{

    /**
     * Handle pane for dashboard page.
     *
     * @return void
     */
    public function compose($name = null, $options = array())
    {
        $menu = $this->widget->make('menu.brands.pane');
        $menu->add('module-item')
                ->link('#')
                ->title('Module item')
                ->icon('zmdi-settings');

        $menu->add('module-item-submenu')
                ->link('#')
                ->title('Module item with submenu')
                ->icon('zmdi-settings');

        $menu->add('foo-item-submenu-element', '^:module-item-submenu')
                ->link('#')
                ->title('Module Submenu item');

        $this->widget->make('pane.left')
                ->add('module')
                ->content(view('antares/foundation::components.placeholder_left')->with('menu', $menu));
    }

}
