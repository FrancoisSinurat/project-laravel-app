<?php

namespace Database\Seeders;

use App\Models\Location;
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
                'location_name' => 'Sekertariat Pusdatin',
                'address' => 'Jl. Jatibaru'
            ],
            [
                'location_name' => 'Lantai 1 Pusdatin',
                'address' => 'Jl. Jatibaru'
            ]
        ];

        foreach ($lokasi as $value) {
            Location::updateOrCreate(['location_name' => $value['location_name']], ['address' => $value['address']]);
        }
    }
}
