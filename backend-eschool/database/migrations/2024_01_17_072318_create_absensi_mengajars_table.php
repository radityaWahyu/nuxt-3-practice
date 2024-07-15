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
        Schema::create('absensi_mengajar', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('id_guru');
            $table->foreignUuid('id_pembelajaran');
            $table->string('materi');
            $table->enum('status', ['masuk', 'ijin', 'sakit']);
            $table->foreignId('id_ruangan');
            $table->timestamps();
            $table->foreign('id_guru')->references('id')->on('pegawai')->onDelete('restrict');
            $table->foreign('id_pembelajaran')->references('id')->on('pembelajaran')->onDelete('cascade');
            $table->foreign('id_ruangan')->references('id')->on('ruangan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('absensi_mengajars');
    }
};
