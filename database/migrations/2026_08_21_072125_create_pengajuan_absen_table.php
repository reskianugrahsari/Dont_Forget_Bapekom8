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
        Schema::create('pengajuan_absen', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_surat', 100)->nullable();
            $table->foreignId('pegawai_id')->constrained('pegawai')->cascadeOnDelete();
            $table->foreignId('atasan_id')->constrained('pegawai')->cascadeOnDelete();
            $table->string('jenis_absen', 100);
            $table->text('alasan');
            $table->date('tanggal_lupa');
            $table->date('tanggal_pengajuan');
            $table->string('kota_surat', 50)->default('Makassar');
            $table->string('status', 20)->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengajuan_absen');
    }
};
