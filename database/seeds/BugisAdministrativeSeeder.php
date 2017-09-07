<?php

use Illuminate\Database\Seeder;

class BugisAdministrativeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();

        $limit = 50;

        for ($i = 0; $i < $limit; $i++) {

            DB::table('jobs')->insert([
                'job_title' => 'Teller',
                'user_id' => 1,
                'job_id' => 1,
                'location_id' => 1,
                'location' => 'Woodlands',
                'role' => 'Manager',
                'choices' => 'male',
                'job_image_path' => 'jobs/0jV7hV6wKg0gKn1DrpTL3q6gZS1TorTGDk7gtcU3.jpeg',
                'no_of_person' => 11,
                'contact_person' => $faker->name,
                'contact_no' => $faker->phoneNumber,
                'business_manager' => $faker->name,
                'employer' => 'Maryna Bay Sands',
                'rate' => 20,
                'language' => 'English',
                'job_date' => $faker->dateTime,
                'end_date' => $faker->dateTime,
                'industry_id' => 1,
                'industry' => 'Administrative',
                'notes' => $faker->paragraph,
                'status' => 'Active',
                'created_at' =>$faker->dateTime,
                'updated_at' => $faker->dateTime,
                'nationality' => 'singaporean',
                'age' =>  20
            ]);
        }
    }
}
