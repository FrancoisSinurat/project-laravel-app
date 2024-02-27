<?php

namespace Database\Seeders;

use App\Models\AsalpengadaanCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AsalpengadaanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $asalpengadaan = ['PUSAT DATA DAN INFORMASI CIPTA KARYA TATA RUANG DAN PERTANAHAN'];

        foreach ($asalpengadaan as $value) {
            AsalpengadaanCategory::updateOrCreate(['asalpengadaan_category_name' => $value], ['asalpengadaan_category_name' => $value]);
        }
    }
}
