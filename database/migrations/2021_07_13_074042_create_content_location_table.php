<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContentLocationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('content_location', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->integer('content_id');
            $table->integer('location_id');
            $table->foreign('content_id', 'fk_content_creator_location_content_creators_1')->references('id')->on('contents');
            $table->foreign('location_id', 'fk_content_creator_location_locations_1')->references('id')->on('locations');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('content_location');
    }
}
