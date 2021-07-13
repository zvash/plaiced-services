<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBrandLocationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('brand_location', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->integer('brand_id')->nullable();
            $table->integer('location_id')->nullable();
            $table->foreign('brand_id', 'fk_advertiser_location_advertisers_1')->references('id')->on('brands');
            $table->foreign('location_id', 'fk_advertiser_location_locations_1')->references('id')->on('locations');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('brand_location');
    }
}
