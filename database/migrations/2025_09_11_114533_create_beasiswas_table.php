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
        Schema::create('beasiswas', function (Blueprint $table) {
            $table->id();
            $table->string('nama_beasiswa');
            $table->string('jenis_beasiswa'); // e.g., 'prestasi', 'umum', 'tidak mampu'
            $table->string('lembaga_penyelenggara');
            $table->unsignedInteger('besar_beasiswa'); // in Rupiah
            $table->string('periode'); // e.g., '2025/2026'
            $table->text('deskripsi')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('beasiswas');
    }
};
