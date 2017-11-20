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
 * @package    Customfields
 * @version    0.9.2
 * @author     Antares Team
 * @license    BSD License (3-clause)
 * @copyright  (c) 2017, Antares
 * @link       http://antaresproject.io
 */

namespace Antares\Modules\SampleModule\Filter;

use Yajra\Datatables\Contracts\DataTableScopeContract;
use Antares\Datatables\Filter\SelectFilter;

class SecondOptionFilter extends SelectFilter implements DataTableScopeContract
{

    /**
     * name of filter
     *
     * @var String 
     */
    protected $name = 'Option 2';

    /**
     * column to search
     *
     * @var String
     */
    protected $column = 'option2';

    /**
     * filter pattern
     *
     * @var String
     */
    protected $pattern = 'Option 2: %value';

    /**
     * filter instance dataprovider
     * 
     * @return array
     */
    protected function options()
    {
        return ['1' => 'Checked', '0' => 'Unchecked'];
    }

    /**
     * filters data by parameters from memory
     * 
     * @param mixed $builder
     */
    public function apply($builder)
    {
//        $values = $this->getValues();
//        if (empty($values)) {
//            return $builder;
//        }
//        $builder->whereIn('type_id', $values);
    }

}
