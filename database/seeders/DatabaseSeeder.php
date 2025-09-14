<?php

namespace Database\Seeders;

use App\Models\Beasiswa;
use App\Models\Mahasiswa;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

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

        Beasiswa::factory(20)->create();
        Mahasiswa::factory(50)->create();
    }
}
