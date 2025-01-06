<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        $this->call(ReporterTypeTableSeeder::class);
        $this->call(DisciplineTableSeeder::class);
        $this->call(CategoryTableSeeder::class);
        $this->call(GenderTableSeeder::class);
        $this->call(CircumstanceTableSeeder::class);
        $this->call(InjuredBodypartTableSeeder::class);
        $this->call(SideTableSeeder::class);
        $this->call(InjurytypeTableSeeder::class);
        $this->call(ExpectedAbsenceTableSeeder::class);
        $this->call(WithOrWithoutTableSeeder::class);
        $this->call(WeatherConditionTableSeeder::class);
        $this->call(TypeOfSnowTableSeeder::class);
        $this->call(CourseConditionTableSeeder::class);
        $this->call(WindConditionTableSeeder::class);
        $this->call(VideoTableSeeder::class);
        $this->call(InjuryReportTableSeeder::class);
        $this->call(UserTableSeeder::class);

    }
}
