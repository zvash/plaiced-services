<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContentTalentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('content_talent', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->integer('content_id')->nullable();
            $table->integer('talent_id')->nullable();
            $table->integer('type_id')->nullable();
            $table->timestamps();
            $table->foreign('content_id', 'fk_content_talent_contents_1')->references('id')->on('contents');
            $table->foreign('type_id', 'fk_content_talent_talent_types_1')->references('id')->on('talent_types');
            $table->foreign('talent_id', 'fk_content_talent_talents_1')->references('id')->on('talents');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('content_talent');
    }
}
