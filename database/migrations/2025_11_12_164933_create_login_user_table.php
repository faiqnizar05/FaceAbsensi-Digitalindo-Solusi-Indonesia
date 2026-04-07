<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('data_login', function (Blueprint $table) {
            $table->id();
            $table->string('username')->unique();
            $table->string('password_login');
            $table->enum('role', ['admin', 'guru', 'siswa'])->default('siswa');
            $table->string('kelas_wali')->nullable(); // Untuk guru: X PPLG 1, XI PPLG 1, XII PPLG 1
            $table->timestamp('last_login')->nullable();
            $table->timestamps();
        });

        // Insert default accounts
        DB::table('data_login')->insert([
            // Admin Utama
            [
                'username' => 'admin',
                'password_login' => Hash::make('admin123'),
                'role' => 'admin',
                'kelas_wali' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Wali Kelas X PPLG 1
            [
                'username' => 'walikelas_xpplg1',
                'password_login' => Hash::make('walikelas12345'),
                'role' => 'guru',
                'kelas_wali' => 'X PPLG 1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Wali Kelas XI PPLG 1
            [
                'username' => 'walikelas_xipplg1',
                'password_login' => Hash::make('walikelas12345'),
                'role' => 'guru',
                'kelas_wali' => 'XI PPLG 1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Wali Kelas XII PPLG 1
            [
                'username' => 'walikelas_xiipplg1',
                'password_login' => Hash::make('walikelas12345'),
                'role' => 'guru',
                'kelas_wali' => 'XII PPLG 1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_login');
    }
};