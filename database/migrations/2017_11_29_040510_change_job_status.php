<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeJobStatus extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::table('jobs', function (Blueprint $table) {
            //

        DB::statement("ALTER TABLE jobs CHANGE status status ENUM('pending','active','inactive','cancelled','auto_cancelled','expired','draft mode')");


        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Schema::table('jobs', function (Blueprint $table) {
            //
        // });
    }
}
