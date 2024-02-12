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
            'aset-alokasi',
            'aset-peminjaman',
            'aset-penarikan',
            'aset-persetujuan-peminjaman',
            'barang-list', // barang
            'barang-create',
            'barang-edit',
            'barang-delete',
            'bahan-list', // bahan
            'bahan-create',
            'bahan-edit',
            'bahan-delete',
            'bidang-list', // bidang
            'bidang-create',
            'bidang-edit',
            'bidang-delete',
            'jenis-aset-list', // jenis aset
            'jenis-aset-create',
            'jenis-aset-edit',
            'jenis-aset-delete',
            'kategori-barang-list', // kategori barang
            'kategori-barang-create',
            'kategori-barang-edit',
            'kategori-barang-delete',
            'lokasi-list', // lokasi
            'lokasi-create',
            'lokasi-edit',
            'lokasi-delete',
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
            'user-delete'
         ];
         foreach ($permissions as $permission) {
            Permission::updateOrCreate(['name' => $permission],['name' => $permission]);
         }
    }
}
