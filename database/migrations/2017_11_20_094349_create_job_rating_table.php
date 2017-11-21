<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJobRatingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_ratings', function (Blueprint $table) {
            //
            $table->increments('id');
            $table->unsignedInteger('employee_id');
            $table->unsignedInteger('job_schedule_id');

            $table->unsignedTinyInteger('rating_point')->nullable();
            $table->text('rating_comment')->nullable();

            $table->unsignedInteger('rate_by');
            $table->dateTime('created_at');
            $table->dateTime('updated_at');

            $table->foreign('employee_id')->references('id')->on('users');
            $table->foreign('rate_by')->references('id')->on('users');
            $table->foreign('job_schedule_id')->references('id')->on('job_schedules');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('job_ratings', function (Blueprint $table) {
            //
        });
    }
}
