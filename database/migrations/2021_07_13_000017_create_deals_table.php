<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDealsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deals', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->text('synopsis')->nullable();
            $table->text('viewership_metrics')->nullable();
            $table->text('content_creator_gets')->nullable();
            $table->json('advertiser_gets');
            $table->text('advertiser_benefits')->nullable();
            $table->json('arrival_speed');
            $table->text('arrival_speed_brief')->nullable();
            $table->boolean('is_public')->default(true)->index();
            $table->boolean('flexible_date')->default(false);

            $table->unsignedTinyInteger('coordinate_added_value')
                ->nullable()
                ->index()
                ->comment('
                    1: pending,
                    2: accepted,
                    3: rejected
                ');

            $table->unsignedTinyInteger('media_accountability')
                ->nullable()
                ->index()
                ->comment('
                    1: pending,
                    2: accepted,
                    3: rejected
                ');

            $table->unsignedTinyInteger('type')
                ->index()
                ->default(1)
                ->comment('
                    1: barter,
                    2: paid
                ');

            $table->unsignedTinyInteger('ownership_type')
                ->index()
                ->default(1)
                ->comment('
                    1: keep,
                    2: loan
                ');

            $table->unsignedTinyInteger('exposure_expectations')
                ->index()
                ->default(1)
                ->comment('
                    1: mandatory,
                    2: flexible
                ');

            $table->unsignedTinyInteger('status')
                ->default(1)
                ->index()
                ->comment('
                    1: pending,
                    2: accepted waiting for payment,
                    3: active,
                    4: finished,
                    5: rejected,
                    6: retracted
                ');

            $table->string('shipping_contact_name')->nullable();
            $table->string('shipping_contact_telephone', 30)->nullable();
            $table->string('shipping_tracking_code')->nullable();
            $table->string('shipping_url')->nullable();
            $table->string('shipping_company')->nullable();
            $table->dateTime('shipping_submitted_at')->nullable();

            $table->foreignId('shipping_submitted_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete()
                ->cascadeOnUpdate();

            $table->text('address')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('postal_code', 30)->nullable();

            $table->foreignId('country_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete()
                ->cascadeOnUpdate();

            $table->morphs('owner');

            $table->foreignId('content_id')
                ->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->foreignId('brand_id')
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
        Schema::dropIfExists('deals');
    }
}
