<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCancelledField extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('job_schedules', function (Blueprint $table) {
            $table->increments('id');
            $table->string('cancel_status')->nullable();
            $table->longText('cancel_reason')->nullable();
            $table->string('cancel_file_path')->nullable();
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
