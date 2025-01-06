<?php

use Illuminate\Database\Seeder;

class SideTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('saj_sides')->insert([
            ['id' => 1,'name_en' => 'Right','name' => '右'],
            ['id' => 2,'name_en' => 'Left','name' => '左'],
            ['id' => 3,'name_en' => 'Not applicable','name' => '左右どちらとも言い難い'],
            ]);
            
    }
}
