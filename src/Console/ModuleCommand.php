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

namespace Antares\SampleModule\Console;

use Antares\View\Console\Command;

class ModuleCommand extends Command
{

    /**
     * human readable command name
     *
     * @var String
     */
    protected $title = 'Sample Automation Job';

    /**
     * when command should be executed
     *
     * @var String
     */
    protected $launched = 'daily';

    /**
     * Name of default category automation command
     *
     * @var String
     */
    protected $category = 'custom';

    /**
     * when command can be executed
     *
     * @var array
     */
    protected $availableLaunches = [
        'everyFiveMinutes',
        'everyTenMinutes',
        'everyThirtyMinutes',
        'hourly',
        'daily'
    ];

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'module:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sample module automation job';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->line('Automation job for sample module completed.');
    }

}
