<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('absen_userdata', function (Blueprint $table) {
            $table->id();
            $table->string('username');
            $table->string('kelas');
            $table->date('tanggal'); // Tanggal absensi
            $table->enum('status_absen', [
                'hadir', 
                'terlambat', 
                'tidak_masuk', 
                'izin_sakit', 
                'urusan_keluarga', 
                'dispensasi'
            ])->default('tidak_masuk');
            $table->time('waktu_absen')->nullable();
            $table->timestamps();
            
            // Unique: 1 user hanya 1 status per hari
            $table->unique(['username', 'tanggal']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('absen_userdata');
    }
};