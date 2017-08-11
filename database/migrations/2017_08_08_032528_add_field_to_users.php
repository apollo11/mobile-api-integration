<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldToUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->nullable();
            $table->integer('role_id')->nullable();
            $table->string('platform')->nullable();
            $table->string('mobile_no')->nullable();
            $table->string('business_name')->nullable();
            $table->string('nric_no')->unique()->nullable();
            $table->string('school')->nullable();
            $table->string('social_access_token')->nullable();
            $table->string('social_google_id')->nullable();
            $table->string('social_fb_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
}
