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
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CustomModuleTable extends Migration
{

    /**
     * Run the migrations.
     * @return void
     */
    public function up()
    {

        $this->down();

        Schema::create('tbl_custom_module', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned()->index('user_id');
            $table->string('name');
            $table->text('value')->nullable();
        });

        Schema::table('tbl_custom_module', function(Blueprint $table) {
            $table->foreign('user_id', 'tbl_custom_module_ibfk_1')->references('id')->on('tbl_users')->onUpdate('NO ACTION')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     * 
     * @return void
     */
    public function down()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Schema::dropIfExists('tbl_custom_module');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }

}
