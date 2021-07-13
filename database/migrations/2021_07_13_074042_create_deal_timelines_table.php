<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDealTimelinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deal_timelines', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->integer('deal_id');
            $table->integer('post_id');
            $table->integer('template_id');
            $table->longText('parameters')->nullable();
            $table->string('created_on');
            $table->dateTime('updated_on')->nullable();
            $table->foreign('deal_id', 'fk_deal_logs_deals_1')->references('id')->on('deals');
            $table->foreign('post_id', 'fk_deal_timeline_deal_posts_1')->references('id')->on('deal_posts');
            $table->foreign('template_id', 'fk_deal_timeline_deal_timeline_templates_1')->references('id')->on('deal_timeline_templates');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('deal_timelines');
    }
}
