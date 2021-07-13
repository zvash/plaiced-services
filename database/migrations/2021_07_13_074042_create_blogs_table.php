<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBlogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blogs', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->string('title');
            $table->string('small_description');
            $table->text('description');
            $table->string('image_url');
            $table->boolean('is_featured');
            $table->string('tags');
            $table->string('slug');
            $table->string('og_title');
            $table->text('og_description');
            $table->string('og_image');
            $table->timestamps();
            $table->dateTime('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('blogs');
    }
}
