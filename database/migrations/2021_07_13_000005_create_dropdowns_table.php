<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->id();
            $table->string('title');
            $table->string('value');
            $table->boolean('custom')->default(0)->index();

            $table->foreignId('group_id')
                ->constrained('dropdown_groups')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->foreignId('group_trailing_id')
                ->constrained('dropdown_groups')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

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
        Schema::dropIfExists('dropdowns');
    }
}
