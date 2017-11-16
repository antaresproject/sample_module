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
 * @package    Logger
 * @version    0.9.2
 * @author     Antares Team
 * @license    BSD License (3-clause)
 * @copyright  (c) 2017, Antares
 * @link       http://antaresproject.io
 */
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class ModuleSampleDataSeeder extends Seeder
{

    /**
     * Faker instance
     *
     * @var Faker 
     */
    protected $faker;

    /**
     * Construct
     */
    public function __construct()
    {
        $this->faker = Faker::create();
    }

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
        $this->down();
        $insert = [];
        foreach ($users as $user) {
            for ($i = 0; $i < 2; $i++) {
                array_push($insert, $this->createInsert($user->id));
            }
        }
        for ($i = 0; $i < 10; $i++) {
            $user = $users->random();
            array_push($insert, $this->createInsert($user->id));
        }
        DB::table('tbl_custom_module')->insert($insert);
        $widgetParamsSchemaPath = __DIR__ . '/schemas/widget_params.sql';
        if (file_exists($widgetParamsSchemaPath)) {
            DB::unprepared(file_get_contents($widgetParamsSchemaPath));
        }
    }

    /**
     * Creates insert array
     * 
     * @param mixed $uid
     * @return array
     */
    protected function createInsert($uid)
    {
        $field1 = rand(1, 2);
        $field2 = rand(0, 1);
        return [
            'user_id' => $uid,
            'name'    => $this->faker->text(20),
            'value'   => '{"field_1":"' . $field1 . '","field_2":"' . $field2 . '"}'
        ];
    }

    /**
     * Delete all database occurences from tbl_custom_module
     */
    public function down()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('tbl_custom_module')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }

}
