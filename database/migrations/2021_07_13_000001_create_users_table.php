<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->ipAddress('ip');
            $table->text('avatar')->nullable();
            $table->string('find_us')->nullable();
            $table->string('company_position');
            $table->unsignedTinyInteger('class')->index();

            $table->unsignedTinyInteger('status')
                ->default(1)
                ->index()
                ->comment('
                    1: pending verification,
                    2: pending first line item,
                    3: pending approval,
                    4: active,
                    5: inactive
                ');

            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
