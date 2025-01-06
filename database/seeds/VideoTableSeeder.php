<?php

use Illuminate\Database\Seeder;

class VideoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('saj_videos')->insert([
            ['id' => 1,'name_en' => 'No','name' => 'なし'],
            ['id' => 2,'name_en' => 'TV broadcast','name' => 'TV放送ビデオ'],
            ['id' => 3,'name_en' => 'Other video','name' => 'その他のビデオ'],
            ]);
            
    }
}
