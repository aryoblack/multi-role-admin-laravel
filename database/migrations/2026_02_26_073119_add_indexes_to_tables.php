<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Users table indexes
        Schema::table('users', function (Blueprint $table) {
            $table->index('email');
            $table->index('role_id');
            $table->index('status');
            $table->index(['role_id', 'status']); // Composite index
        });

        // Permissions table indexes
        Schema::table('permissions', function (Blueprint $table) {
            $table->index('role_id');
            $table->index('menu_id');
            $table->index(['role_id', 'menu_id']); // Composite index for faster lookups
        });

        // Menus table indexes
        Schema::table('menus', function (Blueprint $table) {
            $table->index('parent_id');
            $table->index('url');
            $table->index('urutan');
            $table->index(['parent_id', 'urutan']); // Composite index for menu hierarchy
        });

        // Roles table indexes
        Schema::table('roles', function (Blueprint $table) {
            $table->index('nama_role');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Users table indexes
        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex(['email']);
            $table->dropIndex(['role_id']);
            $table->dropIndex(['status']);
            $table->dropIndex(['role_id', 'status']);
        });

        // Permissions table indexes
        Schema::table('permissions', function (Blueprint $table) {
            $table->dropIndex(['role_id']);
            $table->dropIndex(['menu_id']);
            $table->dropIndex(['role_id', 'menu_id']);
        });

        // Menus table indexes
        Schema::table('menus', function (Blueprint $table) {
            $table->dropIndex(['parent_id']);
            $table->dropIndex(['url']);
            $table->dropIndex(['urutan']);
            $table->dropIndex(['parent_id', 'urutan']);
        });

        // Roles table indexes
        Schema::table('roles', function (Blueprint $table) {
            $table->dropIndex(['nama_role']);
        });
    }
};
