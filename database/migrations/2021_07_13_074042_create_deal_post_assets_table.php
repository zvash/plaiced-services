<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDealPostAssetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deal_post_assets', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->integer('post_id');
            $table->string('mime_type');
            $table->string('extension');
            $table->integer('size')->nullable();
            $table->string('url');
            $table->timestamps();
            $table->foreign('post_id', 'fk_deal_post_assets_deal_post_1')->references('id')->on('deal_posts');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('deal_post_assets');
    }
}
