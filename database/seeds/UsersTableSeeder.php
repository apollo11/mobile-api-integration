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
            'name' => '',
            'email' => '',
            'password' => bcrypt(''),
            'role_id' => 0,
            'role'=> 'Administrator',
            'dashboard_permissions' => 'true',
            'employees_permissions'=> 'true',
            'employers_permissions' => 'true',
            'payout_permissions' => 'true',
            'job_permissions' => 'true',
            'reports_permissions' => 'true',
            'push_permissions' => 'true',
            'recipient_permissions' => 'true',
            'settings_permissions' => 'true'
        ]);
    }
}
