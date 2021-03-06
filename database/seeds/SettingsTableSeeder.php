<?php

use Illuminate\Database\Seeder;

class SettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('settings')->insert([
            'updated_at'=> date('Y-m-d H:i:s'),
            'terms_conditions' => '',
            'privacy_policy' => '',
            'point_basic'   => '100',
            'point_min'   => '70',
            'point_reject_job'   => '-5',
            'point_late_job'   => '-5',
            'point_cancel_job_before_72_hours'   => '-10',
            'point_cancel_job_within_72_hours'   => '-15',
            'point_dont_turnup_job'   => '-20',
        ]);
    }
}
