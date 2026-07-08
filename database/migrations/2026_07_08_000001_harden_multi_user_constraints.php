<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $duplicatePermissions = DB::table('permissions')
            ->select('role_id', 'menu_id', DB::raw('MIN(id) as keep_id'))
            ->groupBy('role_id', 'menu_id')
            ->havingRaw('COUNT(*) > 1')
            ->get();

        foreach ($duplicatePermissions as $permission) {
            DB::table('permissions')
                ->where('role_id', $permission->role_id)
                ->where('menu_id', $permission->menu_id)
                ->where('id', '!=', $permission->keep_id)
                ->delete();
        }

        $duplicateRoleNames = DB::table('roles')
            ->select('nama_role')
            ->groupBy('nama_role')
            ->havingRaw('COUNT(*) > 1')
            ->pluck('nama_role');

        if ($duplicateRoleNames->isNotEmpty()) {
            throw new RuntimeException(
                'Duplicate role names must be resolved before adding unique index: ' . $duplicateRoleNames->implode(', ')
            );
        }

        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['role_id']);
            $table->foreign('role_id')->references('id')->on('roles')->nullOnDelete();
        });

        Schema::table('roles', function (Blueprint $table) {
            $table->unique('nama_role');
        });

        Schema::table('permissions', function (Blueprint $table) {
            $table->unique(['role_id', 'menu_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('permissions', function (Blueprint $table) {
            $table->dropUnique(['role_id', 'menu_id']);
        });

        Schema::table('roles', function (Blueprint $table) {
            $table->dropUnique(['nama_role']);
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['role_id']);
            $table->foreign('role_id')->references('id')->on('roles')->cascadeOnDelete();
        });
    }
};
