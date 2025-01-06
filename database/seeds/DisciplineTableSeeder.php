<?php

use Illuminate\Database\Seeder;

class DisciplineTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('saj_disciplines')->insert([
            ['id' => 1,'name_en' => 'Jumping','name' => 'ジャンプ'],
            ['id' => 2,'name_en' => 'Combined','name' => 'コンバインド'],
            ['id' => 3,'name_en' => 'Cross Country','name' => 'クロスカントリー'],
            ['id' => 4,'name_en' => 'Alpine','name' => 'アルペン'],
            ['id' => 5,'name_en' => 'Freestyle Moguls','name' => 'フリースタイル・モーグル'],
            ['id' => 6,'name_en' => 'Freestyle Aerials','name' => 'フリースタイル・エアリアル'],
            ['id' => 7,'name_en' => 'Freestyle Ski Cross','name' => 'フリースタイル・スキークロス'],
            ['id' => 8,'name_en' => 'Freestyle Half Pipe','name' => 'フリースタイル・ハーフパイプ'],
            ['id' => 9,'name_en' => 'Freestyle Slopestyle/Big Air','name' => 'フリースタイル・スロープスタイル／ビッグエア'],
            ['id' => 10,'name_en' => 'Snowboard Half Pipe','name' => 'スノーボード・ハーフパイプ'],
            ['id' => 11,'name_en' => 'Snowboard Alpine','name' => 'スノーボード・アルペン'],
            ['id' => 12,'name_en' => 'Snowboard Cross','name' => 'スノーボード・クロス'],
            ['id' => 13,'name_en' => 'Snowboard Slopestyle/Big Air','name' => 'スノーボード・スロープスタイル／ビッグエア'],
            ]);
            
    }
}
