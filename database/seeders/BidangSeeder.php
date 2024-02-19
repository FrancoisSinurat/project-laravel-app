<?php

namespace Database\Seeders;

use App\Models\BidangCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BidangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $bidang = ['SEKERTARIAT', 'BIDANG PEMANFAATAN RUANG', 'BIDANG PENGENDALIAN RUANG', 'BIDANG PERTANAHAN DAN INFORMASI GEOSPASIAL', 'BIDANG BANGUNAN GEDUNG', 'BIDANG BINA KONSTRUKSI', 'BIDANG GEDUNG PEMERINTAH DAERAH', 'SUKU DINAS KOTA', 'SUKU DINAS KABUPATEN', 'UNIT PENGADAAN TANAH CIPTA KARYA, TATA RUANG DAN PERTANAHAN', 'UNIT PEMETAAN DAN PENGUKURAN CIPTA KARYA TATA RUANG DAN PERTANAHAN', 'PUSAT DATA DAN INFORMASI CIPTA KARYA TATA RUANG DAN PERTANAHAN'];

        foreach ($bidang as $value) {
            BidangCategory::updateOrCreate(['bidang_category_name' => $value], ['bidang_category_name' => $value]);
        }
    }
}
