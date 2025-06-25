<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Support\Str;
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
            'id' => Str::uuid(),
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin123'),
            'namaLengkap' => 'Admin',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('mahasiswas')->insert(
            [
                [
                    'id' => Str::uuid(),
                    'email' => 'mahasiswa@gmail.com',
                    'password' => Hash::make('mahasiswa123'),
                    'namaLengkap' => 'Mahasiswa',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'id' => Str::uuid(),
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
                'slug' => Str::slug('Teknologi'),
                'deskripsi' => 'Semua tentang teknologi terbaru',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'namaKategori' => 'Bisnis',
                'slug' => Str::slug('Bisnis'),
                'deskripsi' => 'Tips dan trik bisnis sukses',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'namaKategori' => 'Kesehatan',
                'slug' => Str::slug('Kesehatan'),
                'deskripsi' => 'Informasi kesehatan dan gaya hidup',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'namaKategori' => 'Pendidikan',
                'slug' => Str::slug('Pendidikan'),
                'deskripsi' => 'Berita dan perkembangan di dunia pendidikan',
                'status' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'namaKategori' => 'Hiburan',
                'slug' => Str::slug('Hiburan'),
                'deskripsi' => 'Dunia hiburan dan selebriti',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        DB::table('bukus')->insert([
            [
                'judul' => 'Belajar Laravel',
                'slug' => Str::slug('Belajar Laravel'),
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
                'slug' => Str::slug('Mastering PHP'),
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
    }
}
