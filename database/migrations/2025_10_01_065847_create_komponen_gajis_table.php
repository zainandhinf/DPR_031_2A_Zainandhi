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
        Schema::create('komponen_gajis', function (Blueprint $table) {
            $table->id('id_komponen_gaji');
            $table->string('nama_komponen', 100);
            $table->enum('kategori', ['gaji_pokok', 'tunjangan_melekat', 'tunjangan_lain']);
            $table->enum('jabatan', ['ketua', 'wakil_ketua', 'anggota']);
            $table->decimal('nominal', 17, 2);
            $table->enum('satuan', ['bulan', 'periode']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('komponen_gajis');
    }
};
