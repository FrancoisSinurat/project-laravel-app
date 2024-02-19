<?php

namespace Database\Seeders;

use App\Models\BahanCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BahanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $bahan = [
            'Kayu',
            'Besi',
            'Rotan',
            'Jok',
            'Plastik',
            'Gelas/Beling',
            'Fiberglass',
            'Emas',
            'Intan',
            'Alumunium',
            'Tembaga',
            'Mika',
            'Kain',
            'Akrilik',
            'Kertas',
            'Batu',
            'Kanvas',
            'Benang',
            'Busa',
            'Kaolin',
            'Karet',
            'Karpet',
            'Foto',
            'Kulit',
            'Kuningan',
            'Logam',
            'Perunggu',
            'Plakat',
            'Porselen',
            'Rapido',
            'Semen',
            'Tulang',
            'Wool',
            'Baja',
            'Keramik',
            'Kristal',
            'Bensin',
            'Marmer',
            'Melamin',
            'Metal',
            'Pasir',
            'Triplek',
            'Timah',
            'Seng',
            'Aspal',
            'Beton',
            'Bertulang',
            'Canblok',
            'Hotmix',
            'Pipa',
            'Kabel',
            'Campuran',
            'Lainnya'
        ];

        foreach ($bahan as $value) {
            BahanCategory::updateOrCreate(['bahan_category_name' => $value], ['bahan_category_name' => $value]);
        }
    }
}
