<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePermissionsTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->getTables('permissions'), function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('guard_name');
            $table->timestamps();
            $table->unique(['name', 'guard_name']);
        });

        Schema::create($this->getTables('roles'), function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('guard_name');
            $table->boolean('is_superadmin')->default(false)->index();
            $table->timestamps();
            $table->unique(['name', 'guard_name']);
        });

        Schema::create($this->getTables('model_has_permissions'), function (Blueprint $table) {
            $table->morphs($this->getColumns('model_morph_name'));

            $table->foreignId('permission_id')
                ->constrained($this->getTables('permissions'))
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->primary([
                'permission_id',
                $this->getColumns('model_morph_key'),
                $this->getColumns('model_morph_type'),
            ]);
        });

        Schema::create($this->getTables('model_has_roles'), function (Blueprint $table) {
            $table->morphs($this->getColumns('model_morph_name'));

            $table->foreignId('role_id')
                ->constrained($this->getTables('roles'))
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->primary([
                'role_id',
                $this->getColumns('model_morph_key'),
                $this->getColumns('model_morph_type'),
            ]);
        });

        Schema::create($this->getTables('role_has_permissions'), function (Blueprint $table) {
            $table->foreignId('permission_id')
                ->constrained($this->getTables('permissions'))
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->foreignId('role_id')
                ->constrained($this->getTables('roles'))
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->primary(['permission_id', 'role_id']);
        });

        $this->removeCaches();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop($this->getTables('role_has_permissions'));
        Schema::drop($this->getTables('model_has_roles'));
        Schema::drop($this->getTables('model_has_permissions'));
        Schema::drop($this->getTables('roles'));
        Schema::drop($this->getTables('permissions'));
    }

    /**
     * Get table names from permission config file.
     *
     * @param  string|null  $table
     * @return array|string
     *
     * @throws Throwable
     */
    private function getTables(?string $table = null)
    {
        $table = data_get(config('permission.table_names'), $table);

        throw_unless($table, Exception::class, 'Error: config/permission.php not loaded.');

        return $table;
    }

    /**
     * Get column names from permission config file.
     *
     * @param  string|null  $column
     * @return array|string
     */
    private function getColumns(?string $column = null)
    {
        return data_get(config('permission.column_names'), $column);
    }

    /**
     * Remove roles and permissions caches.
     *
     * @return void
     */
    private function removeCaches()
    {
        $store = config('permission.cache.store') != 'default' ? config('permission.cache.store') : null;

        app('cache')->store($store)->forget(config('permission.cache.key'));
    }
}
