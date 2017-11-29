<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeJobscheduleStatus extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
         DB::statement("ALTER TABLE job_schedules CHANGE job_status job_status ENUM('pending','available','accepted','cancelled','completed','rejected','auto_completed','auto_cancelled','approved','reject_request')");
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
