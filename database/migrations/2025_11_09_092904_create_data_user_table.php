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
        Schema::create('data_user', function (Blueprint $table) {

            $table->id();

            $table->string('register')->unique();

            $table->string('departement');

            $table->string('nama');

            $table->string('no_telepon');

            $table->date('tanggal_mulai');

            $table->string('image');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_user');
    }
};