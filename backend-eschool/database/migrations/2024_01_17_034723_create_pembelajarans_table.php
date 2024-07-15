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
        Schema::create('pembelajaran', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignId('id_semester');
            $table->foreignUuid('id_kelas');
            $table->foreignUuid('id_mapel');
            $table->foreignUuid('id_guru');

            $table->timestamps();

            $table->foreign('id_semester')->references('id')->on('semester')->onDelete('restrict');
            $table->foreign('id_guru')->references('id')->on('pegawai')->onDelete('restrict');
            $table->foreign('id_kelas')->references('id')->on('kelas')->onDelete('cascade');
            $table->foreign('id_mapel')->references('id')->on('mata_pelajaran')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembelajarans');
    }
};
