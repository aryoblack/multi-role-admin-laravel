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
        Schema::create('app_settings', function (Blueprint $table) {
            $table->id();
            $table->string('app_name')->default('Multi Role System');
            $table->string('app_logo')->nullable();
            $table->string('app_favicon')->nullable();
            $table->string('primary_color')->default('#2563eb');
            $table->string('secondary_color')->default('#1d4ed8');
            $table->string('footer_text')->default('© 2026 Multi Role System. All Rights Reserved.');
            $table->boolean('allow_registration')->default(false);
            $table->boolean('maintenance_mode')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('app_settings');
    }
};
