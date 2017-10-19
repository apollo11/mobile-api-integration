<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Super Admin',
            'email' => 'apollomalapote@gmail.com',
            'password' => bcrypt('123456'),
            'role_id' => 0,
            'role'=> 'Administrator'
        ]);
    }
}
