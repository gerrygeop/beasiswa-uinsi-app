<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Buat Permissions untuk Mahasiswa
        Permission::create(['name' => 'view mahasiswas']);
        Permission::create(['name' => 'view_any mahasiswas']);
        Permission::create(['name' => 'create mahasiswas']);
        Permission::create(['name' => 'update mahasiswas']);
        Permission::create(['name' => 'delete mahasiswas']);
        Permission::create(['name' => 'restore mahasiswas']);
        Permission::create(['name' => 'force_delete mahasiswas']);

        // Buat Permissions untuk Beasiswa (Pendaftaran)
        Permission::create(['name' => 'view beasiswas']);
        Permission::create(['name' => 'view_any beasiswas']);
        Permission::create(['name' => 'create beasiswas']);
        Permission::create(['name' => 'update beasiswas']);
        Permission::create(['name' => 'delete beasiswas']);

        // Buat Roles
        $mahasiswaRole = Role::create(['name' => 'mahasiswa']);
        $stafRole = Role::create(['name' => 'staf']);
        $adminRole = Role::create(['name' => 'admin']);

        // Beri Permission ke Role 'staf'
        $stafRole->givePermissionTo([
            'view_any mahasiswas',
            'view mahasiswas',
            'view_any beasiswas',
            'view beasiswas',
        ]);
    }
}
