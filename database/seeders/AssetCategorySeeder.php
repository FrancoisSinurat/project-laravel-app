<?php

namespace Database\Seeders;

use App\Models\AssetCategory;
use App\Models\ItemCategory;
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
                'asset_category_id' => '0716b480-8675-4b01-b651-a3fd039cb2ce',
                'asset_category_name' => 'Aset Lancar',
                'asset_category_code' => 'AL'
            ], [
                'asset_category_id' => 'c34a0c5f-9fc0-4644-bee5-c36861f1c462',
                'asset_category_name' => 'Aset Tetap',
                'asset_category_code' => 'AT'
            ]
        ];

        $itemCategories = [
            [
                'asset_category_id' => 'c34a0c5f-9fc0-4644-bee5-c36861f1c462',
                'item_category_id' => '9b674b35-aad3-4a21-a0ba-e8c2fa9ad0da',
                'item_category_name' => 'Furnitur',
                'item_category_code' => 'FNR'
            ],
            [
                'asset_category_id' => 'c34a0c5f-9fc0-4644-bee5-c36861f1c462',
                'item_category_id' => '9b674b35-abd7-482b-af0a-0e30e8791d26',
                'item_category_name' => 'Kendaraan',
                'item_category_code' => 'KDO'
            ],
            [
                'asset_category_id' => 'c34a0c5f-9fc0-4644-bee5-c36861f1c462',
                'item_category_id' => '9b674b35-acab-4916-9447-b1b23a3965a1',
                'item_category_name' => 'Perangkat IT',
                'item_category_code' => 'ICT'
            ],
            [
                'asset_category_id' => '0716b480-8675-4b01-b651-a3fd039cb2ce',
                'item_category_id' => '9b674b35-ad6a-45f5-8f90-bc133fc3fa81',
                'item_category_name' => 'Tak Berwujud',
                'item_category_code' => 'ATB'
            ],
        ];
        foreach ($asset as $value) {
            AssetCategory::updateOrCreate(['asset_category_name' => $value['asset_category_name']], $value);
        }

        foreach ($itemCategories as $value) {
            ItemCategory::updateOrCreate(['item_category_name' => $value['item_category_name']], $value);
        }
    }
}
