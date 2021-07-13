<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDealContentCreatorSurveyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deal_content_creator_survey', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->integer('deal_id');
            $table->integer('user_id');
            $table->tinyInteger('plaiced_rating');
            $table->text('plaiced_what_i_like')->nullable();
            $table->text('plaiced_what_can_get_better')->nullable();
            $table->tinyInteger('other_party_rating');
            $table->text('other_party_what_i_like')->nullable();
            $table->text('other_party_comment')->nullable();
            $table->timestamps();
            $table->foreign('deal_id', 'fk_deal_content_creator_survey_deals_1')->references('id')->on('deals');
            $table->foreign('user_id', 'fk_deal_content_creator_survey_users_1')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('deal_content_creator_survey');
    }
}
