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
        Schema::create('kelas', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('nama', 50);
            $table->foreignId('id_semester');
            $table->foreignUuid('id_jurusan');
            $table->foreignUuid('id_guru');
            $table->timestamps();
            $table->foreign('id_semester')->references('id')->on('semester')->onDelete('cascade');
            $table->foreign('id_jurusan')->references('id')->on('jurusan')->onDelete('restrict');
            $table->foreign('id_guru')->references('id')->on('pegawai')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kelas');
    }
};
