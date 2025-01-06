<?php

use Illuminate\Database\Seeder;

class InjurytypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('saj_injury_types')->insert([
            ['id' => 1,'name_en' => 'Fractures and bone stress','name' => '骨折、骨圧迫'],
            ['id' => 2,'name_en' => 'Teeth','name' => '歯'],
            ['id' => 3,'name_en' => 'Joint(non-bone)and ligament','name' => '関節(骨以外)と靭帯損傷'],
            ['id' => 4,'name_en' => 'Muscle and tendon','name' => '筋及び腱損傷'],
            ['id' => 5,'name_en' => 'Contusions','name' => '打撲傷'],
            ['id' => 6,'name_en' => 'Laceration and skin lesion','name' => '裂傷、皮膚の損傷'],
            ['id' => 7,'name_en' => 'Nervous system including concussion','name' => '衝突、転倒などに起因する神経系の傷害'],
            ['id' => 8,'name_en' => 'Other','name' => 'その他'],
            ]);
            
    }
}
