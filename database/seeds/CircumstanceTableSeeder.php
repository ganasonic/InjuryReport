<?php

use Illuminate\Database\Seeder;

class CircumstanceTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('saj_circumstances')->insert([
            ['id' => 1,'name_en' => 'Competition','name' => '大会'],
            ['id' => 2,'name_en' => 'Official training','name' => '公式練習'],
            ['id' => 3,'name_en' => 'training','name' => '練習'],
            ['id' => 4,'name_en' => 'Other','name' => 'その他'],
            ]);
            
    }
}
