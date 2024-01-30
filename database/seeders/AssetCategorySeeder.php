<?php

namespace Database\Seeders;

use App\Models\AssetCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;



class AssetCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $asset = [
            [
                'asset_category_id' => (string) Str::uuid(),
                'asset_category_name' => 'Aset Tetap'
            ], [
                'asset_category_id' => (string) Str::uuid(),
                'asset_category_name' => 'Aset Lancar'
            ]
        ];
        foreach ($asset as $value) {
            AssetCategory::updateOrCreate(['asset_category_name' => $value['asset_category_name']], $value);
        }
    }
}
