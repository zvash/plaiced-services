<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->integer('user_id');
            $table->integer('deal_id');
            $table->string('amount');
            $table->string('transaction_id');
            $table->tinyInteger('status');
            $table->dateTime('created_on');
            $table->dateTime('updated_on')->nullable();
            $table->foreign('deal_id', 'fk_payments_deals_1')->references('id')->on('deals');
            $table->foreign('user_id', 'fk_payments_users_1')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payments');
    }
}
