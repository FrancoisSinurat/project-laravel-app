<?php

namespace Database\Seeders;

use App\Models\SatuanCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SatuanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $satuan = ['Buah','Unit','Pcs'];

        foreach ($satuan as $value) {
            SatuanCategory::updateOrCreate(['satuan_category_name' => $value], ['satuan_category_name' => $value]);
        }
    }
}
