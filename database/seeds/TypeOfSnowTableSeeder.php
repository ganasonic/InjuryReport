<?php

use Illuminate\Database\Seeder;

class TypeOfSnowTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('saj_type_of_snows')->insert([
            ['id' => 1,'name_en' => 'Natural snow','name' => '天然雪'],
            ['id' => 2,'name_en' => 'Artificial snow','name' => '人工雪'],
            ['id' => 3,'name_en' => 'Plastic','name' => '人工芝'],
            ['id' => 4,'name_en' => 'Other その他','name' => ''],
            ]);
            
    }
}
