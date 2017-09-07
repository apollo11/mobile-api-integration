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
                'user_id' => 1,
                'job_id' => 1,
                'location_id' => 5,
                'location' => 'Bishan',
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
                'job_date' => $faker->dateTime,
                'end_date' => $faker->dateTime,
                'industry_id' => 5,
                'industry' => 'Dental',
                'notes' => $faker->paragraph,
                'status' => 'Active',
                'created_at' =>$faker->dateTime,
                'updated_at' => $faker->dateTime,
                'nationality' => 'singaporean',
                'min_age' => 16,
                'max_age' =>  20,
                'description' => $faker->paragraph
            ]);
        }
    }
}
