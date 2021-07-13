<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMediaAssetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('media_assets', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->tinyInteger('assetable_object');
            $table->integer('assetable_id');
            $table->string('mime_type');
            $table->string('extension');
            $table->integer('size')->nullable();
            $table->string('url');
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
        Schema::dropIfExists('media_assets');
    }
}
