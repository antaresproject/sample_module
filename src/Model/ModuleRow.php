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

namespace Antares\SampleModule\Model;

use Antares\Logger\Traits\LogRecorder;
use Antares\Model\Eloquent;
use Antares\Model\User;

class ModuleRow extends Eloquent
{

    use LogRecorder;

    /**
     * The database table used by the model.
     * @var string
     */
    protected $table = 'tbl_custom_module';

    /**
     * Whether table has timestamps columns
     *
     * @var type 
     */
    public $timestamps = false;

    /**
     * Definition of fillable columns
     *
     * @var array
     */
    protected $fillable = ['user_id', 'name', 'value'];

    /**
     * {@inheritdoc}
     */
    protected $casts = [
        'value' => 'array'
    ];

    /**
     * Relation to user table
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * Gets patterned url for search engines
     * 
     * @return String
     */
    public static function getPatternUrl()
    {
        return handles('antares::sample_module/index/{id}/edit');
    }

    /**
     * Get basic items data
     * 
     * @return Collection
     */
    public function items()
    {
        return $this->get(['id', 'name']);
    }

}
