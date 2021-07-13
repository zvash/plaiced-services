<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contents', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->integer('content_creator_id');
            $table->string('title');
            $table->string('avatar')->nullable();
            $table->string('genre');
            $table->integer('type_level_1');
            $table->integer('type_level_2');
            $table->integer('type_level_3');
            $table->text('synopsis')->nullable();
            $table->text('address')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('postal_code')->nullable();
            $table->integer('country_id')->nullable();
            $table->text('general_comment')->nullable();
            $table->longText('demographic_age')->nullable();
            $table->longText('demographic_gender')->nullable();
            $table->integer('demographic_geography_id')->nullable();
            $table->timestamps();
            $table->foreign('content_creator_id', 'fk_contents_content_creators_1')->references('id')->on('content_creators');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contents');
    }
}
