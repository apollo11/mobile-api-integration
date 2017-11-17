<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSettingsFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('settings', function (Blueprint $table) {
            $table->unsignedInteger('point_basic')->default(0)->after('privacy_policy');
            $table->unsignedInteger('point_min')->default(0)->after('point_basic');
            $table->Integer('point_reject_job')->default(0)->after('point_min');
            $table->Integer('point_late_job')->default(0)->after('point_reject_job');
            $table->Integer('point_cancel_job_w_reason')->default(0)->after('point_late_job');
            $table->Integer('point_cancel_job_wt_reason')->default(0)->after('point_cancel_job_w_reason');
            $table->Integer('point_dont_turnup_job')->default(0)->after('point_cancel_job_wt_reason');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
