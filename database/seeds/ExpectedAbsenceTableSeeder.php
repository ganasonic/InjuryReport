<?php

use Illuminate\Database\Seeder;

class ExpectedAbsenceTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('saj_expected_absences')->insert([
            ['id' => 1,'name_en' => 'No absence','name' => '参加可'],
            ['id' => 2,'name_en' => '1 to 3 days','name' => '1～3日の不参加'],
            ['id' => 3,'name_en' => '4 to 7 days','name' => '4～7日の不参加'],
            ['id' => 4,'name_en' => '8 to 28 days','name' => '8～28日の不参加'],
            ['id' => 5,'name_en' => '＞28 days','name' => '28日以上'],
            ]);
            
    }
}
