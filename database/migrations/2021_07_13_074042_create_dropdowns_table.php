<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDropdownsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dropdowns', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->integer('group_id');
            $table->integer('group_drilldown_id')->nullable();
            $table->string('title');
            $table->string('value');
            $table->boolean('is_custom')->nullable();
            $table->timestamps();
            $table->foreign('group_id', 'fk_dropdowns_dropdown_groups_1')->references('id')->on('dropdown_groups');
            $table->foreign('group_drilldown_id', 'fk_dropdowns_dropdown_groups_2')->references('id')->on('dropdown_groups');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dropdowns');
    }
}
