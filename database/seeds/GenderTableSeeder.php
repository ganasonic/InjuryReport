<?php

use Illuminate\Database\Seeder;

class GenderTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('saj_genders')->insert([
            ['id' => 1,'name_en' => 'Male','name' => '男'],
            ['id' => 2,'name_en' => 'Female','name' => '女'],
            ['id' => 3,'name_en' => 'Other','name' => '未回答'],
            ]);
            
    }
}
