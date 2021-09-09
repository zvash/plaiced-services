<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBrandsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('brands', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('title');
            $table->text('description');
            $table->boolean('featured')->default(false)->index();
            $table->text('general_comment')->nullable();
            $table->text('avatar')->nullable();

            $this->columns()->each(function (string $column) use ($table) {
                $table->json($column);
            });

            $table->foreignId('category')
                ->constrained('dropdowns')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->foreignId('subcategory')
                ->constrained('dropdowns')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->foreignId('advertiser_id')
                ->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

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
        Schema::dropIfExists('brands');
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
            'demographic_income',
            'demographic_marital_status',
            'demographic_type_of_families',
            'demographic_household_size',
            'demographic_race',
            'demographic_education',
            'demographic_geography',
            'demographic_psychographic',
        ]);
    }
}
