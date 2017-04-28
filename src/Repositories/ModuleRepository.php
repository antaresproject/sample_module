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

namespace Antares\SampleModule\Http\Repositories;

use Antares\Foundation\Repository\AbstractRepository;
use Antares\SampleModule\Model\ModuleRow;

class ModuleRepository extends AbstractRepository
{

    public function model()
    {
        return ModuleRow::class;
    }

    public function findAll()
    {
        return $this->makeModel()->get();
    }

}
