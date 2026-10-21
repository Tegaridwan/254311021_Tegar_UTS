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
        Schema::create('laporan_ulasans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('Id_Ulasan');
            $table->string('Alasan');
            $table->foreign('Id_Ulasan')->references('Id_Ulasan')->on('ulasan')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporan_ulasans');
    }
};
