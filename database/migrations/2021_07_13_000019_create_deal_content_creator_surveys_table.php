<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDealContentCreatorSurveysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deal_content_creator_surveys', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->unsignedTinyInteger('plaiced_rating');
            $table->text('plaiced_what_i_like')->nullable();
            $table->text('plaiced_what_can_get_better')->nullable();
            $table->unsignedTinyInteger('other_party_rating');
            $table->text('other_party_what_i_like')->nullable();
            $table->text('other_party_comment')->nullable();

            $table->foreignId('deal_id')
                ->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

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
        Schema::dropIfExists('deal_content_creator_surveys');
    }
}
