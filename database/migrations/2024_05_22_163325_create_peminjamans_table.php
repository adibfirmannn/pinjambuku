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
            // $table->foreignId('idAdmin')->constrained('admins')
            //     ->onDelete('cascade')->nullable();
            $table->foreignId('idAdmin')->nullable()->constrained('admins')
                ->onDelete('set null');
            //membuat foreignId idMahasiswa yang mereferensi table mahasiswas dan ketika baris parentnya dihapus maka, childnya juga dihps
            $table->foreignId('idMahasiswa')->constrained('mahasiswas')
                ->onDelete('cascade');
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
