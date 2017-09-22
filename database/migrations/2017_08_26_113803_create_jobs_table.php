<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jobs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('job_id')->unsigned()->nullable();
            $table->string('job_title');
            $table->longText('description')->nullable();
            $table->string('role');
            $table->enum('choices', ['male', 'female', 'both']);
            $table->string('location');
            $table->string('job_image_path');
            $table->integer('no_of_person');
            $table->string('contact_person');
            $table->string('contact_no');
            $table->string('business_manager');
            $table->string('employer');
            $table->string('language');
            $table->dateTimeTz('job_date');
            $table->decimal('rate', 5, 2);
            $table->longText('notes');
            $table->enum('status', ['active', 'inactive', 'draft mode']);
            $table->timestamps();
            $table->foreign('job_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jobs');
    }
}
