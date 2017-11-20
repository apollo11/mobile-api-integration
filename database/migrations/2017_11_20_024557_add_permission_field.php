<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPermissionField extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->jsonb('dashboard_permissions')->nullable();
            $table->jsonb('employees_permissions')->nullable();
            $table->jsonb('employers_permissions')->nullable();
            $table->jsonb('payout_permissions')->nullable();
            $table->jsonb('job_permissions')->nullable();
            $table->jsonb('reports_permissions')->nullable();
            $table->jsonb('push_permissions')->nullable();
            $table->jsonb('recipient_permissions')->nullable();
            $table->jsonb('settings_permissions')->nullable();
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
