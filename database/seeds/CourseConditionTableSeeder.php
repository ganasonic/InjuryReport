<?php

use Illuminate\Database\Seeder;

class CourseConditionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('saj_course_conditions')->insert([
            ['id' => 1,'name_en' => 'Ice','name' => '氷'],
            ['id' => 2,'name_en' => 'Soft','name' => '軟雪'],
            ['id' => 3,'name_en' => 'Compact','name' => '圧雪'],
            ['id' => 4,'name_en' => 'Injected snow','name' => '注ぎ足された雪'],
            ['id' => 5,'name_en' => 'Chemicals used:salt、snow solidifier、others','name' => 'ケミカルの使用：塩、その他薬品で固めた雪'],
            ['id' => 6,'name_en' => 'Other','name' => 'その他'],
            ]);
            
    }
}
