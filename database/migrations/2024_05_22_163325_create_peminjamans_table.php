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
        Schema::create('peminjamans', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('idAdmin')->references('id')->on('admins');
            $table->foreignUuid('idMahasiswa')->references('id')->on('mahasiswas');
            $table->date('tanggalPengembalian')->nullable();
            $table->date('tanggalPeminjaman');
            $table->integer('jumlahBuku');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peminjamans');
    }
};
