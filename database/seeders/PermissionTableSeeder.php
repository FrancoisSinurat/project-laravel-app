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
    public function run(): void
    {
        $permissions = [
            'asal-oleh-list',
            'asal-oleh-create',
            'asal-oleh-edit',
            'asal-oleh-delete',
            'aset-list',
            'aset-create',
            'aset-edit',
            'aset-delete',
            'aset-penyerahan-list',
            'aset-penyerahan-create',
            'aset-penyerahan-edit',
            'aset-penyerahan-delete',
            'aset-penyerahan-confirmation',
            'aset-peminjaman-list',
            'aset-peminjaman-create',
            'aset-peminjaman-edit',
            'aset-peminjaman-delete',
            'aset-peminjaman-approval',
            'aset-peminjaman-confirmation',
            'barang-list',
            'barang-create',
            'barang-edit',
            'barang-delete',
            'bahan-list',
            'bahan-create',
            'bahan-edit',
            'bahan-delete',
            'asal-pengadaan-list',
            'asal-pengadaan-create',
            'asal-pengadaan-edit',
            'asal-pengadaan-delete',
            'asset-group-list',
            'asset-group-create',
            'asset-group-edit',
            'asset-group-delete',
            'jenis-aset-list',
            'jenis-aset-create',
            'jenis-aset-edit',
            'jenis-aset-delete',
            'kategori-barang-list',
            'kategori-barang-create',
            'kategori-barang-edit',
            'kategori-barang-delete',
            'lokasi-list',
            'lokasi-create',
            'lokasi-edit',
            'lokasi-delete',
            'role-list',
            'role-create',
            'role-edit',
            'role-delete',
            'satuan-list',
            'satuan-create',
            'satuan-edit',
            'satuan-delete',
            'user-list',
            'user-create',
            'user-edit',
            'user-delete',
            'brand-list',
            'brand-create',
            'brand-edit',
            'brand-delete',
            'tipe-list',
            'tipe-create',
            'tipe-edit',
            'tipe-delete',
        ];
        foreach ($permissions as $permission) {
            Permission::updateOrCreate(['name' => $permission], ['name' => $permission]);
        }
    }
}

