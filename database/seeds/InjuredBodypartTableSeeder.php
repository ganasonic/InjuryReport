<?php

use Illuminate\Database\Seeder;

class InjuredBodypartTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('saj_injured_body_parts')->insert([
            ['id' => 1,'name_en' => 'Head-face','name' => '頭部-顔面'],
            ['id' => 2,'name_en' => 'Jaw-Oral','name' => '顎‐口腔'],
            ['id' => 3,'name_en' => 'Neck-cervical spine','name' => '頸-頚椎'],
            ['id' => 4,'name_en' => 'Shoulder-clavicula','name' => '肩-鎖骨'],
            ['id' => 5,'name_en' => 'Upper arm','name' => '上腕'],
            ['id' => 6,'name_en' => 'Elbow','name' => '肘'],
            ['id' => 7,'name_en' => 'Forearm','name' => '前腕'],
            ['id' => 8,'name_en' => 'Wrist','name' => '手首'],
            ['id' => 9,'name_en' => 'Hand-finger-thumb','name' => '手-指-親指'],
            ['id' => 10,'name_en' => 'Chest(sternum-ribs-upper back)','name' => '胸部（胸骨-肋骨-上背部）'],
            ['id' => 11,'name_en' => 'Abdomen','name' => '腹部'],
            ['id' => 12,'name_en' => 'Lower back-pelvis-sacruｍ','name' => '下背部-骨盤-仙骨'],
            ['id' => 13,'name_en' => 'Hip-groin','name' => '臀部-ソ径部'],
            ['id' => 14,'name_en' => 'Thigh','name' => '大腿部'],
            ['id' => 15,'name_en' => 'Knee','name' => '膝'],
            ['id' => 16,'name_en' => 'Lower leg-Achilles tendon','name' => '下腿-アキレス腱'],
            ['id' => 17,'name_en' => 'Ankle','name' => '足関節'],
            ['id' => 18,'name_en' => 'Foot-heel-toe','name' => '足部-踵-つま先'],
            ]);
            
    }
}
