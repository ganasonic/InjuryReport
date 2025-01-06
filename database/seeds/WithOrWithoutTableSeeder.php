<?php

use Illuminate\Database\Seeder;

class WithOrWithoutTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('saj_with_or_withouts')->insert([
            ['id' => 0,'name_en' => 'Non','name' => '-'],
            ['id' => 1,'name_en' => 'With','name' => '有'],
            ['id' => 2,'name_en' => 'Without','name' => '無'],
            ]);
            
    }
}
