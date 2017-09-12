<?php

use Illuminate\Database\Seeder;

class YewTeeBusinessSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();

        $limit = 30;

        for ($i = 0; $i < $limit; $i++) {

            DB::table('jobs')->insert([
                'job_title' => 'Agogo Dancer',
                'user_id' => 2,
                'job_id' => 2,
                'location_id' => 4,
                'location' => 'Woodlands',
                'role' => 'Manager',
                'choices' => 'female',
                'job_image_path' => 'jobs/kIiO01kZqeURCVZBH24J65kCwEImjzczxuv4QNts.jpeg',
                'no_of_person' => 11,
                'contact_person' => $faker->name,
                'contact_no' => $faker->phoneNumber,
                'business_manager' => $faker->name,
                'employer' => 'Maryna Bay Sands',
                'rate' => 20,
                'language' => 'English',
                'job_date' => $faker->dateTimeBetween($startDate = '-1 year', $endDate = 'now'),
                'end_date' => $faker->dateTimeBetween($startDate = '-1 year', $endDate = 'now'),
                'industry_id' => 4,
                'industry' => 'Finance',
                'notes' => $faker->paragraph,
                'status' => 'Active',
                 'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
                'nationality' => 'singaporean',
                'min_age' =>  21,
                'max_age' => 30,
                'job_requirements' => $faker->paragraph

            ]);
        }
    }
}
