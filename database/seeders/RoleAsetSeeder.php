<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use App\Services\Siadik;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RoleAsetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissionPejabatAset = [
            'asal-oleh-list',
            'aset-list',
            'aset-create',
            'aset-edit',
            'aset-delete',
            'aset-alokasi',
            'aset-penarikan',
            'aset-persetujuan_peminjaman',
            'peminjaman-list',
            'peminjaman-create',
            'peminjaman-edit',
            'barang-list',
            'barang-create',
            'barang-edit',
            'bahan-list',
            'bahan-create',
            'bahan-edit',
            'asal-pengadaan-list',
            'asal-pengadaan-create',
            'asal-pengadaan-edit',
            'jenis-aset-list',
            'kategori-barang-list',
            'kategori-barang-create',
            'kategori-barang-edit',
            'satuan-list',
            'satuan-create',
            'satuan-edit',
            'brand-list',
            'tipe-list'
        ];

        $permissionPegawai = [
            'aset-list', // aset
            'peminjaman-list', // peminjaman
            'peminjaman-create',
            'peminjaman-edit',
        ];

        $permissionsOperator = [
            'asal-oleh-list', // sumber
            'asal-oleh-create',
            'asal-oleh-edit',
            'aset-list', // aset
            'peminjaman-list', // peminjaman
            'barang-list', // barang
            'barang-create',
            'barang-edit',
            'bahan-list', // bahan
            'bahan-create',
            'bahan-edit',
            'asal-pengadaan-list', // pengadaan
            'asal-pengadaan-create',
            'asal-pengadaan-edit',
            'jenis-aset-list', // jenis aset
            'jenis-aset-create',
            'jenis-aset-edit',
            'kategori-barang-list', // kategori barang
            'kategori-barang-create',
            'kategori-barang-edit',
            'role-list', // user role
            'role-create',
            'role-edit',
            'satuan-list', // satuan
            'satuan-create',
            'satuan-edit',
            'user-list', // user
            'user-create',
            'user-edit',
            'brand-list',
            'tipe-list'
        ];

        $rolePejabat = Role::updateOrCreate(['name' => 'Pejabat Aset'], ['name' => 'Pejabat Aset']);
        $rolePejabat->syncPermissions($permissionPejabatAset);

        $rolePegawai = Role::updateOrCreate(['name' => 'Pegawai'], ['name' => 'Pegawai']);
        $rolePegawai->syncPermissions($permissionPegawai);

        $roleOperator = Role::updateOrCreate(['name' => 'Operator'], ['name' => 'Operator']);
        $roleOperator->syncPermissions($permissionsOperator);

        $nrk = User::PEJABAT_ASET;

        for ($i=0; $i < count($nrk); $i++) {
            try {
                $find = Siadik::findByNRK($nrk[$i]);
                DB::beginTransaction();
                if (!empty($find)) {
                    User::createUserFromSiadik($find);
                }
                DB::commit();
            } catch (\Throwable $th) {
                DB::rollback();
                Log::error($th->getMessage());
            }
        }
    }
}
