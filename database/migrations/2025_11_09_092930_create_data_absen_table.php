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
        Schema::create('data_absen', function (Blueprint $table) {
            $table->id();

            // No Register peserta
            $table->string('register');

            // Lokasi saat melakukan absensi
            $table->text('location');

            // Status absensi
            $table->enum('status', ['success', 'failed']);

            // Waktu absensi
            $table->timestamp('time_absen');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_absen');
    }
}; 