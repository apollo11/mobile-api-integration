<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdditionalInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('additional_infos', function (Blueprint $table) {

            $table->increments('id');
            $table->enum('gender', ['male', 'female'])->nullable();
            $table->date('birthdate')->nullable();
            $table->string('religion')->nullable();
            $table->longText('address')->nullable();
            $table->string('email')->nullable();
            $table->string('school')->nullable();
            $table->date('school_pass_expiry_date')->nullable();
            $table->string('front_ic_path')->nullable();
            $table->string('back_ic_path')->nullable();
            $table->string('emergency_name')->nullable();
            $table->string('emergency_contact_no')->nullable();
            $table->string('emergency_relationship')->nullable();
            $table->longText('emergency_address')->nullable();
            $table->string('contact_method')->nullable();
            $table->string('criminal_record')->nullable();
            $table->string('medication')->nullable();
            $table->integer('user_id')->unsigned()->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');;
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('additional_infos');
    }
}
