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

namespace Antares\SampleModule\Http\Presenters;

use Antares\Foundation\Http\Presenters\Presenter;
use Illuminate\Support\Collection;

class ModulePresenter extends Presenter
{

    /**
     * Metoda index jest tożsama z akcją index w kontrolerze i odpowiada widokiem
     * 
     * @param Collection $collection
     * @return \Illuminate\View\View
     */
    public function index(Collection $collection)
    {
        return view('antares/sample_module::admin.foo.index', ['data' => $collection]);
    }

}
