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
        Schema::create('pwa_settings', function (Blueprint $table) {
            $table->id();
            $table->string('app_name')->default('Dont Forget');
            $table->string('short_name')->default('Dont Forget');
            $table->string('description')->default('Sistem pengajuan lupa absen dan tata usaha');
            $table->string('theme_color', 20)->default('#111827');
            $table->string('background_color', 20)->default('#ffffff');
            $table->string('icon_192')->default('/images/pwa/icon-192.png');
            $table->string('icon_512')->default('/images/pwa/icon-512.png');
            $table->string('start_url')->default('/');
            $table->string('display')->default('standalone');
            $table->string('scope')->default('/');
            $table->string('cache_version')->default('v1');
            $table->boolean('offline_enabled')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pwa_settings');
    }
};
