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
                'user_id' => 13,
                'job_id' => 13,
                'location_id' => 2,
                'location' => 'Yishun',
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
                'job_date' => $faker->dateTime,
                'end_date' => $faker->dateTime,
                'industry_id' => 2,
                'industry' => 'Finance',
                'notes' => $faker->paragraph,
                'status' => 'Active',
                'created_at' =>$faker->dateTime,
                'updated_at' => $faker->dateTime,
                'nationality' => 'singaporean',
                'age' =>  60
            ]);
        }
    }
}
