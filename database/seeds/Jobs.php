<?php

use Illuminate\Database\Seeder;

class Jobs extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();

        $limit = 20;

        for($i = 0; $i < $limit; $i++) {

            DB::table('jobs')->insert([
                'job_title' => 'Cleaner',
                'user_id' => 1,
                'job_id' => 1,
                'location_id' => 1,
                'location' => 'Woodlands',
                'role' => 'Supervisor',
                'choices' => 'male',
                'job_image_path' => 'jobs/5N1nyc4lbtRGlN4mUEWdSMbWNkJ24y1HhdAFYSvv.jpeg',
                'no_of_person' => 12,
                'contact_person' => $faker->name,
                'contact_no' => $faker->phoneNumber,
                'business_manager' => $faker->name,
                'employer' => 'Maryna Bay Sands',
                'rate' => 20,
                'language' => 'English',
                'job_date' => $faker->dateTime,
                'end_date' =>  $faker->dateTime,
                'industry_id' => 1,
                'industry' => 'IT',
                'notes' => $faker->paragraph,
                'status' => 'Active',
                'created_at' =>$faker->dateTime,
                'updated_at' => $faker->dateTime,
                'nationality' => 'singaporean',
                'age' =>  30
            ]);
        }
    }
}
