<?php

use Illuminate\Database\Seeder;

class ReporterTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('saj_reporter_types')->insert([
            ['id' => 1,'name_en' => 'Trainer','name' => 'トレーナー'],
            ['id' => 2,'name_en' => 'Coach, etc.','name' => 'コーチ'],
            ['id' => 3,'name_en' => 'Division Doctor','name' => 'Divisionドクター'],
            ['id' => 4,'name_en' => 'Other','name' => 'その他'],
            ]);
            
    }
}
