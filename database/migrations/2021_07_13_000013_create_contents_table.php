<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('title');
            $table->boolean('featured')->default(false)->index();
            $table->text('synopsis')->nullable();
            $table->text('viewership_metrics')->nullable();
            $table->text('general_comment')->nullable();
            $table->string('avatar')->nullable();
            $table->string('shipping_contact_name')->nullable();
            $table->string('shipping_contact_telephone', 30)->nullable();
            $table->text('address')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('postal_code', 30)->nullable();

            $table->foreignId('country_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete()
                ->cascadeOnUpdate();

            $this->columns()->each(function (string $column) use ($table) {
                $table->json($column);
            });

            $table->foreignId('genre')
                ->constrained('dropdowns')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->foreignId('category')
                ->constrained('dropdowns')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->foreignId('subcategory')
                ->constrained('dropdowns')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->foreignId('child_subcategory')
                ->constrained('dropdowns')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->foreignId('content_creator_id')
                ->constrained()
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
        Schema::dropIfExists('contents');
    }

    /**
     * List of columns.
     *
     * @return \Illuminate\Support\Collection
     */
    private function columns()
    {
        return collect([
            'locations',
            'demographic_age',
            'demographic_gender',
            'demographic_geography_id',
        ]);
    }
}
