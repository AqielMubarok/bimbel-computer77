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
        Schema::create('nilais', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Relasi ke tabel users
            $table->string('name'); // Nama yang di-auth
            $table->boolean('kehadiran'); // Kehadiran (misalnya: 1 untuk hadir, 0 untuk tidak hadir)
            $table->string('kompetensi'); // Kolom untuk kompetensi
            $table->string('skill'); // Kolom untuk skill 
            $table->timestamps();
            

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nilais');
    }
};