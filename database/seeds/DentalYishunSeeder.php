<?php

use Illuminate\Database\Seeder;

class DentalYishunSeeder extends Seeder
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
                'job_title' => 'Receptionist',
                'user_id' => 2,
                'job_id' => 2,
                'location_id' => 2,
                'location' => 'Bugis',
                'role' => 'Manager',
                'choices' => 'male',
                'job_image_path' => 'jobs/MjdPoZqa9YlFF1kwANKRhTvDu7E5PCwRf2frCXjj.jpeg',
                'no_of_person' => 11,
                'contact_person' => $faker->name,
                'contact_no' => $faker->phoneNumber,
                'business_manager' => $faker->name,
                'employer' => 'Maryna Bay Sands',
                'rate' => 20,
                'language' => 'English',
                'job_date' => $faker->dateTimeBetween($startDate = '-1 year', $endDate = 'now'),
                'end_date' => $faker->dateTimeBetween($startDate = '-1 year', $endDate = 'now'),
                'industry_id' => 2,
                'industry' => 'Business',
                'notes' => $faker->paragraph,
                'status' => 'Active',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
                'nationality' => 'singaporean',
                'min_age' =>  16,
                'max_age' => 20,
                'job_requirements' => $faker->paragraph
            ]);
        }
    }
}
