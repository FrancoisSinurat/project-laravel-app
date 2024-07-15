<?php

namespace App\Models;

use App\Trait\UuidTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class Asset extends Model
{
    use SoftDeletes, UuidTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $primaryKey = 'asset_id';

    CONST STATUS_ASSET_TERSEDIA = 'TERSEDIA';
    CONST STATUS_ASSET_PROSES_PENYERAHAN = 'PROSES PENYERAHAN';
    CONST STATUS_ASSET_PENYERAHAN = 'PROSES PENYERAHAN';
    CONST STATUS_ASSET_DIGUNAKAN = 'DIGUNAKAN';
    CONST STATUS_ASSET_DIPINJAM = 'DIPINJAM';
    CONST STATUS_ASSET_DIKEMBALIKAN = 'DIKEMBALIKAN';

    protected $fillable = [
        'asset_id',
        'asset_category_id',
        'asset_group_id',
        'item_category_id',
        'item_id',
        'item_type_id',
        'item_brand_id',
        'bahan_category_id',
        'satuan_category_id',
        'location_id',
        'asset_status',
        'asset_used_by',
        'asset_code',
        'asset_bpad_code',
        'asset_name',
        'asset_note',
        'asset_specification',
        'asset_serial_number',
        'asset_frame_number',
        'asset_machine_number',
        'asset_police_number',
        'asset_price',
        'asset_qty',
        'asset_shrinkage'
    ];

    public function asset_group()
    {
        return $this->belongsTo(AssetGroup::class, 'asset_group_id', 'asset_group_id');
    }

    public function asset_category()
    {
        return $this->belongsTo(AssetCategory::class, 'asset_category_id', 'asset_category_id');
    }

    public function item_category()
    {
        return $this->belongsTo(ItemCategory::class, 'item_category_id', 'item_category_id');
    }

    public function item()
    {
        return $this->belongsTo(Item::class, 'item_id', 'item_id');
    }

    public function item_type()
    {
        return $this->belongsTo(ItemType::class, 'item_type_id', 'item_type_id');
    }

    public function item_brand()
    {
        return $this->belongsTo(ItemBrand::class, 'item_brand_id', 'item_brand_id');
    }

    public function bahan()
    {
        return $this->belongsTo(BahanCategory::class, 'bahan_category_id', 'bahan_category_id');
    }

    public function satuan()
    {
        return $this->belongsTo(SatuanCategory::class, 'satuan_category_id', 'satuan_category_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'asset_used_by', 'user_id');
    }

    public function location()
    {
        return $this->belongsTo(Location::class, 'location_id', 'location_id');
    }

    public static function generateAssetName($input) {
        $name = '';
        $item = Item::where('item_id', $input['item_id'])->first();
        if ($item) {
            $name = $item->item_name;
            $brand = ItemBrand::where('item_brand_id', $input['item_brand_id'])->first();
            $type = ItemType::where('item_type_id', $input['item_type_id'])->first();
            if (!empty($brand)) $name .= ' '.$brand->item_brand_name;
            if (!empty($type)) $name .= ' '.$type->item_type_name;
        }
        return $name;
    }

    public static function generateAssetCode($input) {
        $item = Item::where('item_id', $input['item_id'])->first();
        $assetCategory = AssetCategory::where('asset_category_id', $input['asset_category_id'])->first();
        $assetCode = $item->item_code.'-'.$assetCategory->asset_category_code.'-';
        return $assetCode;
    }

    public static function incrementAssetGroup($input) {
        return AssetGroup::find($input['asset_group_id'])->increment('asset_group_items');
    }

    public static function decrementAssetGroup($input) {
        return AssetGroup::find($input['asset_group_id'])->decrement('asset_group_items');
    }

    public static function updateOrCreateAssetGroup($input) {
        if (isset($input['asset_group_id'])) {
            $updateGroup = [
                'asalpengadaan_category_id' => $input['asalpengadaan_category_id'],
                'asaloleh_category_id' => $input['asaloleh_category_id'],
                'asset_document_number' => $input['asset_document_number'],
                'asset_asaloleh_date' => Carbon::createFromFormat('d-m-Y', $input['asset_asaloleh_date'])->toDateString(),
                'asset_procurement_year' => $input['asset_procurement_year'],
            ];
            if (isset($input['asset_documents'])) $updateGroup['asset_documents'] = isset($input['asset_documents']);
            AssetGroup::where('asset_group_id', $input['asset_group_id'])->update($updateGroup);
            // if not same group recalculate
            if (isset($input['old_asset_group_id'])) {
                if ($input['old_asset_group_id'] != $input['asset_group_id']) {
                    self::decrementAssetGroup(['asset_group_id' => $input['old_asset_group_id']]);
                    self::incrementAssetGroup(['asset_group_id' => $input['asset_group_id']]);
                }
            }
            return AssetGroup::where('asset_group_id', $input['asset_group_id'])->first();
        } else {
            $create = AssetGroup::create([
                'asalpengadaan_category_id' => $input['asalpengadaan_category_id'],
                'asaloleh_category_id' => $input['asaloleh_category_id'],
                'asset_document_number' => $input['asset_document_number'],
                'asset_asaloleh_date' => Carbon::createFromFormat('d-m-Y', $input['asset_asaloleh_date'])->toDateString(),
                'asset_procurement_year' => $input['asset_procurement_year'],
                'asset_documents' => isset($input['asset_documents']) ? $input['asset_documents'] : null,
                'asset_group_items' => 1,
            ]);
            if (isset($input['old_asset_group_id'])) self::decrementAssetGroup(['asset_group_id' => $input['old_asset_group_id']]);
            return $create;
        }
    }

    public static function createAssetGroupBulkAsset($input) {
        if (isset($input['group']['asset_group_id'])) {
            $find = AssetGroup::where('asset_group_id', $input['group']['asset_group_id'])->first();
            if (!$find) throw new \Exception("not found asset group");
            AssetGroup::find($find->asset_group_id)->increment('asset_group_items', count($input['asset']));
            if (isset($input['group']['asset_documents'])) {
                AssetGroup::where('asset_group_id', $find->asset_group_id)->update([
                    'asset_documents' => $input['group']['asset_documents']
                ]);
            }
            return $find;
        } else {
            $create = AssetGroup::create([
                'asalpengadaan_category_id' => $input['group']['asalpengadaan_category_id'],
                'asaloleh_category_id' => $input['group']['asaloleh_category_id'],
                'asset_document_number' => $input['group']['asset_document_number'],
                'asset_asaloleh_date' => $input['group']['asset_asaloleh_date'],
                'asset_procurement_year' => $input['group']['asset_procurement_year'],
                'asset_documents' => $input['group']['asset_documents'] ?? $input['group']['asset_documents'],
                'asset_group_items' => count($input['asset']),
            ]);
            return $create;
        }
    }

    public static function normalize($input) {
        // Log::info('normalize asset');
        // Log::info($input);
        $result = $input;
        $result['asset_price'] = replaceComma($input['asset_price']);
        $result['asset_name'] = self::generateAssetName($input);
        $result['asset_qty'] = isset($input['asset_qty']) ? $input['asset_qty'] : 1;
        $result['asset_status'] = Asset::STATUS_ASSET_TERSEDIA;
        return $result;
    }

    public static function updateAsset($input) {
        // Log::info('update asset');
        // Log::info($input);
        $beforeUpdate = Asset::query()->with('asset_group')->where('asset_id', $input['asset_id'])->first();
        // not found
        if (!$beforeUpdate) throw new \Exception("Data tidak ditemukan !");
        // status not TERSEDIA
        if ($beforeUpdate->asset_status != Asset::STATUS_ASSET_TERSEDIA) throw new \Exception("Hanya aset yang tersedia yang bisa diupdate!");
        // check if not same with old group by doc number
        if ($beforeUpdate->asset_group->asset_document_number != $input['asset_document_number']) {
            $checkGroup = AssetGroup::where('asset_document_number', $input['asset_document_number'])->first();
            if ($checkGroup) $input['asset_group_id'] = $checkGroup->asset_group_id;
            $input['old_asset_group_id'] = $beforeUpdate->asset_group_id;
        } else {
            $input['asset_group_id'] = $beforeUpdate->asset_group->asset_group_id;
        }
        // update or create asset group
        $getGroup = self::updateOrCreateAssetGroup($input);
        if (!isset($input['asset_group_id'])) $input['asset_group_id'] = $getGroup->asset_group_id;
        // different item generate asset code
        if ($input['item_id'] != $beforeUpdate->item_id) {
            $lastNumber = 1;
            $getLastNumber = Asset::where('item_id', $input['item_id'])->latest('asset_id')->first();
            $code = self::generateAssetCode($input);
            // extract last number
            if ($getLastNumber) {
                $extractAssetCode = explode('-', $getLastNumber->asset_code);
                $assetCodeNumber = last($extractAssetCode);
                $lastNumber = intval($assetCodeNumber) + 1;
            }
            $update['asset_code'] = $code . str_pad($lastNumber, 7, '0', STR_PAD_LEFT);
        }
        $update['asset_id'] = $input['asset_id'];
        $update['asset_group_id'] = $input['asset_group_id'];
        $update['asset_category_id'] = $input['asset_category_id'];
        $update['item_category_id'] = $input['item_category_id'];
        $update['location_id'] = $input['asset_location_id'];
        $update['item_id'] = $input['item_id'];
        $update['item_brand_id'] = $input['item_brand_id'];
        $update['item_type_id'] = $input['item_type_id'];
        $update['satuan_category_id'] = $input['satuan_category_id'];
        $update['asset_price'] = $input['asset_price'];
        $update['asset_shrinkage'] = $input['asset_shrinkage'];
        $update['asset_specification'] = $input['asset_specification'];
        $update['asset_bpad_code'] = $input['asset_bpad_code'];
        $update['asset_serial_number'] = $input['asset_serial_number'];
        $update['asset_machine_number'] = $input['asset_machine_number'];
        $update['asset_frame_number'] = $input['asset_frame_number'];
        $update['asset_police_number'] = $input['asset_police_number'];
        Asset::where('asset_id', $input['asset_id'])->update($update);
    }

    public static function transform($data) {
        return [
            'asset_id' => $data->asset_id ?? null,
            'asset_category_name' => $data->asset_category->asset_category_name ?? null,
            'asset_category_code' => $data->asset_category->asset_category_code ?? null,
            'item_category_code' => $data->item_category->item_category_code ?? null,
            'item_category_name' => $data->item_category->item_category_name ?? null,
            'location_name' => $data->location->location_name ?? null,
            'asset_code' => $data->asset_code ?? null,
            'asset_status' => $data->asset_status ?? null,
            'asset_document_number' => $data->asset_group->asset_document_number ?? null,
            'asset_procurement_year' => $data->asset_group->asset_procurement_year ?? null,
            'asset_asaloleh_category_name' => $data->asset_group->asal_oleh->asaloleh_category_name ?? null,
            'asset_asalpengadaan_category_name' => $data->asset_group->asal_pengadaan->asalpengadaan_category_name ?? null,
            'asset_asaloleh_date' => $data->asset_group->asset_asaloleh_date ? date('d-m-Y', strtotime($data->asset_group->asset_asaloleh_date)) : null,
            'asset_name' => $data->asset_name ?? null,
            'asset_item_name' => $data->item->item_name ?? null,
            'asset_bahan_name' => $data->bahan->bahan_category_name ?? null,
            'asset_bpad_code' => $data->asset_bpad_code ?? null,
            'asset_serial_number' => $data->asset_serial_number ?? null,
            'asset_price' => numberFormat($data->asset_price) ?? null,
            'asset_shrinkage' => $data->asset_shrinkage .'%' ?? null,
            'asset_specification' => $data->asset_specification ?? null,
            'asset_frame_number' => $data->asset_frame_number ?? null,
            'asset_machine_number' => $data->asset_machine_number ?? null,
            'asset_police_number' => $data->asset_police_number ?? null,
            'asset_documents' => isset($data->asset_group) && isset($data->asset_group->asset_documents) ? json_encode(json_decode($data->asset_group->asset_documents)) : null
        ];
    }

    public static function deleteAsset($id) {
        try {
            $asset = Asset::findOrFail($id);
            AssetHistory::where('asset_id', $id)->delete();
            self::decrementAssetGroup(['asset_group_id' => $asset->asset_group_id]);
            $asset->delete();
        } catch (\Throwable $th) {
            throw new \Exception($th->getMessage());
        }
    }

    public static function populateAsset($input) {
        $result = [];
        $arrValues = $input['asset_serial_number'];
        if (count($arrValues) == 0) return $result;
        if (isset($input['asset_group_id'])) $result['group']['asset_group_id'] = $input['asset_group_id'];
        $result['group']['asset_document_number'] = $input['asset_document_number'];
        $result['group']['asset_procurement_year'] = $input['asset_procurement_year'];
        $result['group']['asalpengadaan_category_id'] = $input['asalpengadaan_category_id'];
        $result['group']['asaloleh_category_id'] = $input['asaloleh_category_id'];
        $result['group']['asset_documents'] = $input['asset_documents'] ?? null;
        $result['group']['asset_asaloleh_date'] = Carbon::createFromFormat('d-m-Y', $input['asset_asaloleh_date'])->toDateString();
        $file = [];
        if (isset($input['dokumen_penyedia'])) $file['dokumen_penyedia'] = json_decode($input['dokumen_penyedia'], true);
        if (isset($input['dokumen_barang'])) $file['dokumen_barang'] = json_decode($input['dokumen_barang'], true);
        if (isset($input['dokumen_spj'])) $file['dokumen_spj'] = json_decode($input['dokumen_spj'], true);
        $result['group']['asset_documents'] = json_encode($file);
        $getLastNumber = Asset::where('item_id', $input['item_id'])->latest('asset_id')->first();
        $lastNumber = 1;
        if ($getLastNumber) {
            $extractAssetCode = explode('-', $getLastNumber->asset_code);
            $assetCodeNumber = last($extractAssetCode);
            $lastNumber = intval($assetCodeNumber) + 1;
        }
        $code = self::generateAssetCode($input);
        // Log::info('generate asset code');
        // Log::info($lastNumber);
        // Log::info($code);
        foreach ($arrValues as $i => $v) {
            $lastNumber = intval($lastNumber) + $i;
            $result['asset'][$i]['asset_code'] = $code . str_pad($lastNumber, 7, '0', STR_PAD_LEFT);
            if (isset($input['asset_group_id'])) $result['asset'][$i]['asset_group_id'] = $input['asset_group_id'];
            $result['asset'][$i]['asset_id'] = $input['asset_id'][$i];
            $result['asset'][$i]['asset_category_id'] = $input['asset_category_id'];
            $result['asset'][$i]['item_category_id'] = $input['item_category_id'];
            $result['asset'][$i]['location_id'] = $input['asset_location_id'];
            $result['asset'][$i]['item_id'] = $input['item_id'];
            $result['asset'][$i]['item_brand_id'] = $input['item_brand_id'];
            $result['asset'][$i]['item_type_id'] = $input['item_type_id'];
            $result['asset'][$i]['satuan_category_id'] = $input['satuan_category_id'];
            $result['asset'][$i]['asset_price'] = $input['asset_price'];
            $result['asset'][$i]['asset_shrinkage'] = $input['asset_shrinkage'];
            $result['asset'][$i]['asset_specification'] = $input['asset_specification'];
            $result['asset'][$i]['asset_bpad_code'] = $input['asset_bpad_code'][$i];
            $result['asset'][$i]['asset_serial_number'] = $input['asset_serial_number'][$i];
            $result['asset'][$i]['asset_machine_number'] = $input['asset_machine_number'][$i];
            $result['asset'][$i]['asset_frame_number'] = $input['asset_frame_number'][$i];
            $result['asset'][$i]['asset_police_number'] = $input['asset_police_number'][$i];
            $result['asset_history'][$i]['asset_id'] = $input['asset_id'][$i];
            $result['asset_history'][$i]['asset_history_status'] = Asset::STATUS_ASSET_TERSEDIA;
            $result['asset_history'][$i]['historyable_id'] = $input['asset_id'][$i];
            $result['asset_history'][$i]['historyable_type'] = Asset::class;
            $result['asset_history'][$i]['asset_history_user_id'] = Auth::user()->user_id;

        }
        return $result;
    }

    public static function createBulkAsset($input) {
        $getAssetGroup = self::createAssetGroupBulkAsset($input);
        foreach ($input['asset'] as $k => $v) {
            $uuidAssetGroup = (string) Str::orderedUuid();
            $uuidAsset = (string) Str::orderedUuid();
            $input['asset'][$k]['asset_group_id'] = $getAssetGroup->asset_group_id;
            $input['asset'][$k]['asset_id'] = $uuidAsset;
            $input['asset'][$k]['created_at'] = now();
            $input['asset'][$k]['updated_at'] = now();
            $input['asset_history'][$k]['asset_id'] = $input['asset'][$k]['asset_id'];
            $input['asset_history'][$k]['asset_history_id'] = $uuidAssetGroup;
            $input['asset_history'][$k]['created_at'] = now();
            $input['asset_history'][$k]['updated_at'] = now();
        }
        Asset::insert($input['asset']);
        return AssetHistory::insert($input['asset_history']);

    }
}
