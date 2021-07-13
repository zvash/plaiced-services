<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDealPostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deal_posts', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->integer('deal_id');
            $table->integer('user_id');
            $table->string('description');
            $table->timestamps();
            $table->foreign('deal_id', 'fk_deal_post_deals_1')->references('id')->on('deals');
            $table->foreign('user_id', 'fk_deal_post_users_1')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('deal_posts');
    }
}
