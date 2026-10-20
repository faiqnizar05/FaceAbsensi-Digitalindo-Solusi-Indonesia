<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tambahkan kolom register ke tabel data_absen.
     */
    public function up(): void
    {
        Schema::table('data_absen', function (Blueprint $table) {
            $table->string('register')
                ->nullable()
                ->after('id');
        });
    }

    /**
     * Hapus kolom register jika migration di-rollback.
     */
    public function down(): void
    {
        Schema::table('data_absen', function (Blueprint $table) {
            $table->dropColumn('register');
        });
    }
};