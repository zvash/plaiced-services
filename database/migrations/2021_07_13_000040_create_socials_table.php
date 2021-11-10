<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSocialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('socials', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->text('url');

            $table->unsignedTinyInteger('type')
                ->index()
                ->comment('
                    1: website,
                    2: facebook,
                    3: instagram,
                    4: twitter,
                    5: linkedin
                ');

            $table->morphs('sociable');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('socials');
    }
}
