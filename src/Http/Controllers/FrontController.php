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

namespace Antares\Modules\SampleModule\Http\Controllers;

use Antares\Foundation\Http\Controllers\BaseController;

class FrontController extends BaseController
{

    /**
     * Ustalenie reguł dostępu do akcji kontrollera
     */
    public function setupMiddleware()
    {
        ;
    }

    /**
     * Zwykle prezentacja listy
     */
    public function index()
    {
        
    }

    /**
     * Zwykle prezentacja danych pojedynczego rekordu
     */
    public function show($id)
    {
        
    }

    /**
     * Zapis nowego rekordu
     */
    public function store()
    {
        
    }

    /**
     * Aktualizacja istniejącego rekordu
     */
    public function update()
    {
        
    }

    /**
     * Usunięcie rekordu
     */
    public function destroy()
    {
        
    }

}
