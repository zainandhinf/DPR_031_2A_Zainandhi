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
        Schema::create('anggotas', function (Blueprint $table) {
            $table->bigInteger('id_anggota')->primary();
            $table->string('nama_depan', 100);
            $table->string('nama_belakang', 100);
            $table->string('gelar_depan', 50);
            $table->string('gelar_belakang', 50);
            $table->enum('jabatan', ['ketua', 'wakil_ketua', 'anggota']);
            $table->enum('status_pernikahan', ['kawin', 'belum_kawin']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('anggotas');
    }
};
