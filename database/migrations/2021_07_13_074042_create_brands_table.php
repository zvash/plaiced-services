<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBrandsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('brands', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->integer('advertiser_id');
            $table->string('title');
            $table->string('avatar')->nullable();
            $table->integer('placement')->nullable();
            $table->integer('type_level_1');
            $table->integer('type_level_2');
            $table->text('general_comment')->nullable();
            $table->longText('demographic_age')->nullable();
            $table->longText('demographic_gender')->nullable();
            $table->longText('demographic_income')->nullable();
            $table->longText('demographic_maritial_status')->nullable();
            $table->longText('demographic_type_of_families')->nullable();
            $table->longText('demographic_household_size')->nullable();
            $table->longText('demographic_race')->nullable();
            $table->longText('demographic_education')->nullable();
            $table->integer('demographic_geography')->nullable();
            $table->longText('demographic_psychographic')->nullable();
            $table->timestamps();
            $table->foreign('advertiser_id', 'fk_brands_advertisers_1')->references('id')->on('advertisers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('brands');
    }
}
