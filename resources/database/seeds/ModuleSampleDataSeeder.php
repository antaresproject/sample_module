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
 * @package    Logger
 * @version    0.9.0
 * @author     Antares Team
 * @license    BSD License (3-clause)
 * @copyright  (c) 2017, Antares Project
 * @link       http://antaresproject.io
 */
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class ModuleSampleDataSeeder extends Seeder
{

    /**
     * Run the database seeding.
     *
     * @return void
     */
    public function run()
    {
        $users = users('member');
        if (empty($users)) {
            return;
        }
        $user = $users->first();

        $this->down();
        $faker  = Faker::create();
        $insert = [];
        for ($i = 0; $i < 2; $i++) {
            array_push($insert, [
                'user_id' => $user->id,
                'name'    => $faker->text(20),
                'value'   => '{"field_1":"1"}'
            ]);
        }
        DB::table('tbl_custom_module')->insert($insert);


        $widgetParamsSchemaPath = __DIR__ . '/schemas/widget_params.sql';
        if (file_exists($widgetParamsSchemaPath)) {
            DB::unprepared(file_get_contents($widgetParamsSchemaPath));
        }
    }

    /**
     * delete all database occurences for logger component
     */
    public function down()
    {
        
    }

}
