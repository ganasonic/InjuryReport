<?php

use Illuminate\Database\Seeder;

class WeatherConditionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('saj_weather_conditions')->insert([
            ['id' => 1,'name_en' => 'Sunny-clear','name' => '晴天'],
            ['id' => 2,'name_en' => 'Cloudy','name' => '曇り'],
            ['id' => 3,'name_en' => 'Raining','name' => '雨'],
            ['id' => 4,'name_en' => 'snowing','name' => '雪'],
            ['id' => 5,'name_en' => 'foggy','name' => '濃霧'],
            ['id' => 6,'name_en' => 'Flat light','name' => '平面光'],
            ['id' => 7,'name_en' => 'Artificial light','name' => '人工照明'],
            ]);
            
    }
}
