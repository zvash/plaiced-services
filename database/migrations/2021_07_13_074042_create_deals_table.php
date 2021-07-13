<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDealsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deals', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->integer('content_id');
            $table->integer('brand_id');
            $table->integer('owner_id');
            $table->tinyInteger('type');
            $table->string('initiated_by', 20);
            $table->text('synopsis')->nullable();
            $table->text('viewership_metrics')->nullable();
            $table->text('content_creator_gets');
            $table->longText('advertiser_gets')->nullable();
            $table->text('benefits');
            $table->date('when_needed');
            $table->longText('arrival_speed')->nullable();
            $table->smallInteger('ownership_type');
            $table->smallInteger('exposure_expectations');
            $table->boolean('is_public')->nullable();
            $table->date('paid_on')->nullable();
            $table->integer('shipping_code')->nullable();
            $table->string('shipping_url')->nullable();
            $table->text('address');
            $table->string('state');
            $table->string('city');
            $table->string('postal_code');
            $table->integer('country_id');
            $table->string('shipping_contact')->nullable();
            $table->tinyInteger('coordinate_added_value')->nullable();
            $table->tinyInteger('media_accountability')->nullable();
            $table->tinyInteger('status');
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
        Schema::dropIfExists('deals');
    }
}
