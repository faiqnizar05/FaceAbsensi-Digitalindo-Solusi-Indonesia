<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('izin_absensi', function (Blueprint $table) {
            $table->id();
            $table->string('username');
            $table->string('kelas');
            $table->string('foto')->nullable(); // Foto surat (opsional)
            $table->text('penjelasan');
            $table->enum('status_izin', ['izin_sakit', 'dispensasi', 'urusan_keluarga']);
            $table->integer('durasi_hari')->default(1); // Berapa hari izin (1-5)
            $table->timestamp('tanggal_mulai')->nullable(); // Kapan mulai izin
            $table->timestamp('tanggal_expired')->nullable(); // Sampai kapan izin berlaku
            $table->enum('cek_status', ['diterima', 'ditolak', 'ditangguhkan'])->default('ditangguhkan');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('izin_absensi');
    }
};