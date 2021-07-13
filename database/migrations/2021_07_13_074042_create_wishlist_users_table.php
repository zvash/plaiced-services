<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWishlistUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wishlist_users', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->integer('wishlist_id');
            $table->integer('user_id');
            $table->timestamps();
            $table->foreign('user_id', 'fk_wishlist_users_users_1_2')->references('id')->on('users');
            $table->foreign('wishlist_id', 'fk_wishlist_users_wishlists_1')->references('id')->on('wishlists');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wishlist_users');
    }
}
