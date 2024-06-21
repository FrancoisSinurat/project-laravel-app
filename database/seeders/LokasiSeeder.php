<?php

namespace Database\Seeders;

use App\Models\Lokasi;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
class LokasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $lokasi = [
            [
                'nama_lokasi' => 'Sekertariat Pusdatin',
                'alamat' => 'Jl. Jatibaru'
            ], 
            [
                'nama_lokasi' => 'Lantai 1 Pusdatin',
                'alamat' => 'Jl. Jatibaru'
            ]
        ];

        foreach ($lokasi as $value) {
            Lokasi::updateOrCreate(['nama_lokasi' => $value['nama_lokasi']], ['alamat' => $value['alamat']]);
        }
    }
}
