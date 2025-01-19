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
        Schema::create('detailKategoris', function (Blueprint $table) {
            $table->id();
            $table->foreignId('idBuku')->constrained('bukus')->onDelete('cascade');
            $table->foreignId('idKategori')->constrained('kategoris')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detailKategoris');
    }
};
