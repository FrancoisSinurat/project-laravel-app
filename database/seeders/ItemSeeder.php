<?php

namespace Database\Seeders;

use App\Models\Item;
use App\Models\ItemBrand;
use App\Models\ItemType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $createItem = [
            [
                'item_category_id' => '9b674b35-acab-4916-9447-b1b23a3965a1',
                'item_name' => 'Laptop',
                'item_code' =>  'ICT-'.date('dmY').'-00001'
            ],
            [
                'item_category_id' => '9b674b35-abd7-482b-af0a-0e30e8791d26',
                'item_name' => 'Mobil',
                'item_code' =>  'KDO-'.date('dmY').'-00001'
            ],
            [
                'item_category_id' => '9b674b35-aad3-4a21-a0ba-e8c2fa9ad0da',
                'item_name' => 'Meja',
                'item_code' =>  'FNR-'.date('dmY').'-00001'
            ],
            [
                'item_category_id' => '9b674b35-ad6a-45f5-8f90-bc133fc3fa81',
                'item_name' => 'Aplikasi Photoshop CS5',
                'item_code' =>  'ATB-'.date('dmY').'-00001'
            ]
        ];

        try {
            DB::beginTransaction();
            $item = Item::updateOrCreate($createItem, $createItem);
            $createItemBrand = [
                'item_brand_id' => $item->item_brand_id,
                'item_brand_name' => 'DELL',
            ];
            $itemBrand = ItemBrand::updateOrCreate($createItemBrand, $createItemBrand);
            $createItemType = [
                    'item_brand_id' => $itemBrand->item_brand_id,
                    'item_type_name' => 'Latitude E7220',
            ];
            ItemType::updateOrCreate($createItemType, $createItemType);
            DB::commit();
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            DB::rollBack();
            //throw $th;
        }

    }
}
