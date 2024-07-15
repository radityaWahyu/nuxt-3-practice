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
        Schema::create('pembelajaran_detail', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('id_pembelajaran');
            $table->foreignId('id_hari');
            $table->foreignId('id_jam');
            $table->timestamps();

            $table->foreign('id_jam')->references('id')->on('jam_pelajaran');
            $table->foreign('id_pembelajaran')->references('id')->on('pembelajaran')->onDelete('cascade');
            $table->foreign('id_hari')->references('id')->on('hari');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembelajaran_details');
    }
};
