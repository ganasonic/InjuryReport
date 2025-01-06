<?php

use Illuminate\Database\Seeder;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('saj_categorys')->insert([
            ['id' => 0,'name_en' => '-','name' => '-'],
            ['id' => 1,'name_en' => 'S','name' => 'Sランク'],
            ['id' => 2,'name_en' => 'A','name' => 'Aランク'],
            ['id' => 3,'name_en' => 'U','name' => 'Uランク'],
            ['id' => 4,'name_en' => 'B','name' => 'Bランク'],
            ['id' => 5,'name_en' => 'C','name' => 'Cランク'],
            ['id' => 6,'name_en' => 'D','name' => 'Dランク'],
            ]);            
    }
}
