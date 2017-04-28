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

namespace Antares\SampleModule\Http\Controllers\Admin;

use Antares\Foundation\Http\Controllers\AdminController;
use Antares\SampleModule\Http\Datatables\ModuleDatatable;
use Antares\SampleModule\Processor\ModuleProcessor;

class ModuleController extends AdminController
{

    /**
     * Module processor instance
     *
     * @var ModuleProcessor
     */
    protected $processor;

    /**
     * Constructing
     * 
     * @param ModuleProcessor $processor
     */
    public function __construct(ModuleProcessor $processor)
    {
        parent::__construct();
        $this->processor = $processor;
    }

    /**
     * Ustalenie reguł dostępu do akcji kontrollera
     */
    public function setupMiddleware()
    {
        $this->middleware('antares.auth');
        $this->middleware("antares.can:antares/sample_module::index-action", ['only' => ['index']]);
    }

    public function index()
    {
        $datatable = app(ModuleDatatable::class);

        email_notification('module_email_notification', [user()], []);
        return $datatable->render('antares/sample_module::admin.module.index');
    }

    public function create()
    {
        $data = $this->processor->create();
        if (isset($data['errors'])) {
            return $this->redirectWithErrors(handles('antares::sample_module/create'), $data['errors']);
        }
        return view('antares/sample_module::admin.module.create', $data);
    }

    public function store()
    {
        if (!empty(request()->get('columns')) && request()->ajax()) {
            return $this->index();
        }
        return $this->processor->store();
    }

    public function edit($id)
    {
        return $this->processor->update($id);
    }

    public function update($id)
    {
        return $this->processor->update($id);
    }

    public function delete($id)
    {
        return $this->processor->delete($id);
    }

}
