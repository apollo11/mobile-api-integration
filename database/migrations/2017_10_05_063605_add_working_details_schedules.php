<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddWorkingDetailsSchedules extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('job_schedules', function (Blueprint $table) {
            $table->dateTime('checkin_datetime')->nullable();
            $table->string('checkin_location')->nullable();
            $table->dateTime('checkout_datetime')->nullable();
            $table->string('checkout_location')->nullable();
            $table->string('working_hours')->nullable();
            $table->string('job_salary')->nullable();
            $table->dateTime('process_date')->nullable();
            $table->string('payment_methods')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('job_schedules', function (Blueprint $table) {
            //
        });
    }
}
