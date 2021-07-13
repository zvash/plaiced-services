<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->integer('user_id');
            $table->tinyInteger('type');
            $table->longText('parameters')->nullable();
            $table->boolean('is_viewed')->nullable();
            $table->string('status');
            $table->dateTime('created_on');
            $table->dateTime('updated_on')->nullable();
            $table->foreign('user_id', 'fk_notifications_users_1_2')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notifications');
    }
}
