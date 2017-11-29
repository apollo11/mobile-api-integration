<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);
        $this->call(Jobs::class);
        $this->call(DentalYishunSeeder::class);
        $this->call(YewTeeBusinessSeeder::class);
        $this->call(BugisAdministrativeSeeder::class);
        $this->call(IndustrySeederTable::class);
        $this->call(LocationTableSeeder::class);
        $this->call(DeviceTokenSeeder::class);

        $this->call(SettingsTableSeeder::class);
    }
}
