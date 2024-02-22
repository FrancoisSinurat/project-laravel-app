<?php

namespace Database\Seeders;

use App\Models\AsalolehCategory;
use Illuminate\Database\Seeder;

class SourceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $source = [
            'Pengadaan Barang Yang Di Beli Atau Diperoleh atas Beban APBD',
            'Hibah/Sumbangan atau yang Sejenis',
            'Pelaksanaan dari Perjanjian/Kontrak',
            'Ketentuan Peraturan Perundang-Undangan',
            'Putusan Pengadilan yang Telah Mempunyai Kekuatan Hukum Tetap',
            'Divestasi',
            'Hasil Inventarisasi',
            'Hasil Tukar Menukar',
            'Pembatalan Penghapusan',
            'Perolehan/Penerimaan Lainnya',
        ];
        foreach ($source as $value) {
            AsalolehCategory::updateOrCreate(['asaloleh_category_name' => $value], ['asaloleh_category_name' => $value]);
        }
    }
}
