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

use Symfony\Component\Process\Process;
use Illuminate\Console\Command;
use Exception;

class UpProcessesCommand extends Command
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'processes:up';

    /**
     * Runs command
     */
    public function handle()
    {
        try {
            $this->line('Upping php processes...');
            set_time_limit(0);
            ini_set('max_execution_time', 0);
            ignore_user_abort();
            $process = new Process("/opt/lampp/bin/php /var/www/html/artisan notifications:start", null, null, null, 1);
            $process->run();
        } catch (Exception $e) {
            
        }
    }

}
