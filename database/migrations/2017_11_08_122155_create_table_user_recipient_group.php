<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableUserRecipientGroup extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_recipient_groups', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('recipient_group_id')->unsigned()->nullable();
            $table->foreign('recipient_group_id')->references('id')->on('recipient_groups')->onDelete('cascade');
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
        Schema::dropIfExists('user_recipient_groups');
    }
}
