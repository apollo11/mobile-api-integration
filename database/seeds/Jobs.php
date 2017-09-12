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
                'job_title' => 'HRM',
                'user_id' => 2,
                'job_id' => 2,
                'location_id' => 3,
                'location' => 'Tampines',
                'role' => 'Manager',
                'choices' => 'male',
                'job_image_path' => 'jobs/0UyQDH5JVMfQl55FPLdJ7ao7I2QSm3my392bE61D.jpeg',
                'no_of_person' => 11,
                'contact_person' => $faker->name,
                'contact_no' => $faker->phoneNumber,
                'business_manager' => $faker->name,
                'employer' => 'Maryna Bay Sands',
                'rate' => 20,
                'language' => 'English',
                'job_date' => $faker->dateTimeBetween($startDate = '-1 year', $endDate = 'now'),
                'end_date' => $faker->dateTimeBetween($startDate = '-1 year', $endDate = 'now'),
                'industry_id' => 3,
                'industry' => 'Dental',
                'notes' => $faker->paragraph,
                'status' => 'Active',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
                'nationality' => 'singaporean',
                'min_age' => 21,
                'max_age' =>  30,
                'job_requirements' => $faker->paragraph
            ]);
        }
    }
}
