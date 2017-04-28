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

use Illuminate\Support\Facades\Artisan;
use Symfony\Component\Process\Process;
use Illuminate\Support\Facades\File;
use Symfony\Component\Finder\Finder;
use Illuminate\Support\Facades\Log;
use Illuminate\Console\Command;
use Illuminate\Cache\FileStore;
use Exception;

class ResetCommand extends Command
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'reset:app';

    /**
     * Runs command
     */
    public function handle()
    {
        Artisan::call('down');
        $process = new Process("pkill -f notifications");
        //$process->start();
        $this->clearDirectories();
        $this->replaceDatabase();
        shell_exec('chmod -R 777 /var/www/html/storage');
        shell_exec('chown -R daemon:daemon /var/www/html/storage');
        //Artisan::call('processes:up');
        Artisan::call('up');
    }

    /**
     * Replaces database instance
     * 
     * @return boolean
     */
    protected function replaceDatabase()
    {
        $database = config('database');
        $default  = array_get($database, 'default');
        $config   = config('antares/updater::sandbox.database');
        $config   = [
            'username'         => array_get($database, "connections.{$default}.username"),
            'primary_database' => 'temporary',
            'command_path'     => config('laravel-backup.mysql.dump_command_path'),
            'character_set'    => array_get($config, 'character_set'),
            'collation'        => array_get($config, 'collation'),
        ];

        $protocol = $this->getProtocolString();
        $file     = storage_path('app/dumps/dump.sql');
        $command  = sprintf("%smysql %s -u %s %s < %s", array_get($config, 'command_path'), $protocol, array_get($config, 'username'), array_get($config, 'primary_database'), $file);
        $process  = new Process($command);
        $process->run();
    }

    /**
     * Gets protocol string
     * 
     * @return string
     */
    private function getProtocolString()
    {
        return '--protocol=socket -S /opt/lampp/var/mysql/mysql.sock';
    }

    /**
     * Clears storage directories
     */
    protected function clearDirectories()
    {
        $this->clearSession();
        $this->clearCache();
        $this->clearStorage();
    }

    /**
     * Clears session directories
     * 
     * @return void
     */
    protected function clearSession()
    {
        $path   = storage_path('framework/sessions');
        $finder = new Finder();
        $finder = $finder->in($path)->files()->ignoreVCS(true)->exclude('.gitignore');
        foreach ($finder as $element) {
            File::delete($element);
        }
        return;
    }

    /**
     * Clearing storage files before installation 
     */
    protected function clearStorage()
    {
        $filesystem = File::getFacadeRoot();
        $finder     = new Finder();
        $paths      = config('antares/installer::storage_path');
        $finder     = $finder->files()->ignoreVCS(true);
        foreach ($paths as $path) {
            $current = storage_path($path);
            if (!is_dir($current)) {
                continue;
            }
            $finder = $finder->in($current);
        }
        $finder->exclude('.gitignore');
        foreach ($finder as $element) {
            $filesystem->delete($element);
        }
        try {
            $directories = $finder->directories();
            foreach ($directories as $dir) {
                $files = $filesystem->allFiles($dir->getPath(), true);
                if (empty($files)) {
                    $filesystem->deleteDirectory($dir->getPath());
                }
            }
        } catch (Exception $e) {
            Log::alert($e);
        }
        return;
    }

    /**
     * clear global cache
     * 
     * @return boolean
     */
    protected function clearCache()
    {
        try {
            $cache = app('cache');
            $store = $cache->store()->getStore();
            if ($store instanceof FileStore) {
                $directory = $store->getDirectory();
                $store->getFilesystem()->cleanDirectory($directory);
                return true;
            }
        } catch (Exception $e) {
            Log::emergency($e);
            return false;
        }
    }

}
