<?php

use Illuminate\Database\Seeder;

class WindConditionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('saj_wind_conditions')->insert([
            ['id' => 0,'name_en' => '-','name' => '不明・その他'],
            ['id' => 1,'name_en' => 'No wind','name' => '無風'],
            ['id' => 2,'name_en' => 'Some wind','name' => '微風'],
            ['id' => 3,'name_en' => 'High wind','name' => '強風'],
            ]);
            
    }
}
