<?php

namespace Database\Seeders;

use App\Models\Beasiswa;
use App\Models\Mahasiswa;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RolesAndPermissionsSeeder::class,
        ]);

        $admin = User::factory()->create([
            'name' => 'Admin',
            'nim' => '0000001',
        ]);

        $admin->assignRole('admin');

        $stafUser = User::factory()->create([
            'name' => 'Staf Akademik',
            'nim' => '0000002',
        ]);
        $stafUser->assignRole('staf');

        DB::table('kategori')->insert([
            [
                'nama_kategori' => 'Tidak mampu',
                'deskripsi' => fake()->paragraph(1),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_kategori' => 'Pemerintah',
                'deskripsi' => fake()->paragraph(1),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_kategori' => 'Swasta',
                'deskripsi' => fake()->paragraph(1),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_kategori' => 'Prestasi',
                'deskripsi' => fake()->paragraph(1),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_kategori' => 'Penelitian dan Pengabdian',
                'deskripsi' => fake()->paragraph(1),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_kategori' => 'Sekali terima',
                'deskripsi' => fake()->paragraph(1),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_kategori' => 'Sampai selesai',
                'deskripsi' => fake()->paragraph(1),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_kategori' => 'Satu periode',
                'deskripsi' => fake()->paragraph(1),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        Beasiswa::factory(20)->create();
        Mahasiswa::factory(50)->create();
    }
}
