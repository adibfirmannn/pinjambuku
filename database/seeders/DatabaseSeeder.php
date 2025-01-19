<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        DB::table('admins')->insert([
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin123'),
            'namaLengkap' => 'Admin',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('mahasiswas')->insert(
            [
                [
                    'email' => 'mahasiswa@gmail.com',
                    'password' => Hash::make('mahasiswa123'),
                    'namaLengkap' => 'Mahasiswa',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'email' => 'adib@gmail.com',
                    'password' => Hash::make('adib123'),
                    'namaLengkap' => 'Adib Firmansyah',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ]
        );

        DB::table('kategoris')->insert([
            [
                'namaKategori' => 'Teknologi',
                'deskripsi' => 'Semua tentang teknologi terbaru',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'namaKategori' => 'Bisnis',
                'deskripsi' => 'Tips dan trik bisnis sukses',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'namaKategori' => 'Kesehatan',
                'deskripsi' => 'Informasi kesehatan dan gaya hidup',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'namaKategori' => 'Pendidikan',
                'deskripsi' => 'Berita dan perkembangan di dunia pendidikan',
                'status' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'namaKategori' => 'Hiburan',
                'deskripsi' => 'Dunia hiburan dan selebriti',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        DB::table('bukus')->insert([
            [
                'judul' => 'Belajar Laravel',
                'pengarang' => 'John Doe',
                'deskripsi' => 'Buku panduan lengkap belajar Laravel dari dasar hingga mahir.',
                'gambar' => 'belajarlaravel.jpg',
                'jumlah' => 10,
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'judul' => 'Mastering PHP',
                'pengarang' => 'Jane Smith',
                'deskripsi' => 'Buku ini membahas konsep-konsep lanjutan dalam PHP.',
                'gambar' => 'masteringphp.jpg',
                'jumlah' => 5,
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        DB::table('detailkategoris')->insert([
            [
                'idBuku' => 1,
                'idKategori' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'idBuku' => 1,
                'idKategori' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'idBuku' => 2,
                'idKategori' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'idBuku' => 2,
                'idKategori' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],

        ]);

        DB::table('peminjamans')->insert([
            [
                'idAdmin' => 1,
                'idMahasiswa' => 1,
                'tanggalPengembalian' => now(),
                'tanggalPeminjaman' => now(),
                'jumlahBuku' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'idAdmin' => 1,
                'idMahasiswa' => 1,
                'tanggalPengembalian' => now(),
                'tanggalPeminjaman' => date('Y-m-d', strtotime('2023-08-11')),
                'jumlahBuku' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'idAdmin' => 1,
                'idMahasiswa' => 2,
                'tanggalPengembalian' => now(),
                'tanggalPeminjaman' => date('Y-m-d', strtotime('2023-08-11')),
                'jumlahBuku' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);

        DB::table('detailspeminjamans')->insert([
            [
                'idBuku' => 1,
                'idPeminjaman' => 1,
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'idBuku' => 2,
                'idPeminjaman' => 1,
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'idBuku' => 2,
                'idPeminjaman' => 2,
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'idBuku' => 1,
                'idPeminjaman' => 3,
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
