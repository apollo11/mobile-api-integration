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
            $table->enum('gender', ['male', 'female']);
            $table->date('birthdate');
            $table->string('religion');
            $table->longText('address');
            $table->string('email');
            $table->string('school');
            $table->date('school_pass_expiry_date');
            $table->string('front_ic_path');
            $table->string('back_ic_path');
            $table->string('emergency_name');
            $table->string('emergency_contact_no');
            $table->string('emergency_relationship');
            $table->longText('emergency_address');
            $table->enum('contact_method', ['sms', 'phone', 'email', 'other']);
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
