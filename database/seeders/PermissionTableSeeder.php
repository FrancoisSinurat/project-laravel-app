<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run() :void
    {
        $permissions = [
            'asal-oleh-list', // sumber
            'asal-oleh-create',
            'asal-oleh-edit',
            'asal-oleh-delete',
            'aset-list', // aset
            'aset-create',
            'aset-edit',
            'aset-delete',
            'barang-list', // barang
            'barang-create',
            'barang-edit',
            'barang-delete',
            'jenis-aset-list', // jenis aset
            'jenis-aset-create',
            'jenis-aset-edit',
            'jenis-aset-delete',
            'jenis-barang-list', // jenis barang
            'jenis-barang-create',
            'jenis-barang-edit',
            'jenis-barang-delete',
            'role-list', // user role
            'role-create',
            'role-edit',
            'role-delete',
            'satuan-list', // satuan
            'satuan-create',
            'satuan-edit',
            'satuan-delete',
            'user-list', // user
            'user-create',
            'user-edit',
            'user-delete',
            'user-bidang-list', // user bidang
            'user-bidang-create',
            'user-bidang-edit',
            'user-bidang-delete'
         ];
         foreach ($permissions as $permission) {
            Permission::updateOrCreate(['name' => $permission],['name' => $permission]);
         }
    }
}
