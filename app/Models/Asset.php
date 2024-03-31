<?php

namespace App\Models;

use App\Trait\UuidTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

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
    CONST STATUS_ASSET_DIGUNAKAN = 'DIGUNAKAN';
    CONST STATUS_ASSET_DIPINJAM = 'DIPINJAM';
    CONST STATUS_ASSET_DIKEMBALIKAN = 'DIKEMBALIKAN';

    protected $fillable = [
        'asset_category_id',
        'item_category_id',
        'item_id',
        'item_type_id',
        'item_brand_id',
        'asalpengadaan_category_id',
        'bahan_category_id',
        'satuan_category_id',
        'asaloleh_category_id',
        'asset_asaloleh_date',
        'asset_procurement_year',
        'asset_status',
        'asset_used_by',
        'asset_code',
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

    public function asal_pengadaan()
    {
        return $this->belongsTo(AsalpengadaanCategory::class, 'asalpengadaan_category_id', 'asalpengadaan_category_id');
    }

    public function bahan()
    {
        return $this->belongsTo(BahanCategory::class, 'bahan_category_id', 'bahan_category_id');
    }

    public function satuan()
    {
        return $this->belongsTo(SatuanCategory::class, 'satuan_category_id', 'satuan_category_id');
    }

    public function asal_oleh()
    {
        return $this->belongsTo(AsalolehCategory::class, 'asaloleh_category_id', 'asaloleh_category_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'asset_used_by', 'user_id');
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
        $getLastNumber = Asset::where('item_id', $input['item_id'])->count();
        $lastNumber = $getLastNumber ? intval($getLastNumber) + 1 : 1;
        $code = str_pad($lastNumber, 6, '0', STR_PAD_LEFT);
        $item = Item::where('item_id', $input['item_id'])->first();
        $assetCategory = AssetCategory::where('asset_category_id', $input['asset_category_id'])->first();
        $assetCode = $item->item_code.'-'.$assetCategory->asset_category_code.'-'.$code;
        return $assetCode;
    }

    public static function normalize($input) {
        Log::info('normalize asset');
        Log::info($input);
        $result = $input;
        $result['asset_asaloleh_date'] = Carbon::createFromFormat('d-m-Y', $input['asset_asaloleh_date'])->toDateString();
        $result['asset_price'] = replaceComma($input['asset_price']);
        if (!isset($input['asset_code'])) $result['asset_code'] = self::generateAssetCode($input);
        $result['asset_name'] = self::generateAssetName($input);
        $result['asset_qty'] = isset($input['asset_qty']) ? $input['asset_qty'] : 1;
        $result['asset_status'] = isset($input['asset_used_by']) ? Asset::STATUS_ASSET_DIGUNAKAN : Asset::STATUS_ASSET_TERSEDIA;
        return $result;
    }

    public static function createAsset($input) {
        Log::info($input);
        $createAsset = Asset::create($input);
        $historyClass = Asset::class;
        $historyId = $createAsset->asset_id;
        $status = $input['asset_status'];
        if ($status === Asset::STATUS_ASSET_DIGUNAKAN) {
            $assetUsed = AssetUsed::create(['asset_id' => $createAsset->asset_id, 'user_id' => $input['asset_used_by'], 'asset_used_date' => date('Y-m-d')]);
            $historyClass = AssetUsed::class;
            $historyId = $assetUsed->asset_used_id;
        }
        $createAssetHistory = [
            'asset_history_status' => $status,
            'asset_id' =>  $createAsset->asset_id,
            'historyable_id' => $historyId,
            'historyable_type' => $historyClass,
            'asset_history_user_id' => Auth::user()->user_id,
        ];
        AssetHistory::create($createAssetHistory);
    }

    public static function updateAsset($input) {
        Log::info('update asset');
        Log::info($input);
        $beforeUpdate = Asset::where('asset_id', $input['asset_id'])->first();
        $status = $input['asset_status'];
        $historyClass = Asset::class;
        $historyId = $input['asset_id'];
        $usedBy = $input['asset_used_by'] ?? null;
        $input['asset_used_by'] = $usedBy;
        Asset::where('asset_id', $input['asset_id'])->update($input);
        if ($status === Asset::STATUS_ASSET_DIGUNAKAN && $beforeUpdate->asset_used_by != $usedBy) {
            $assetUsed = AssetUsed::create(['asset_id' => $input['asset_id'], 'user_id' => $input['asset_used_by'], 'asset_used_date' => date('Y-m-d')]);
            $historyClass = AssetUsed::class;
            $historyId = $assetUsed->asset_used_id;
        }
        if ($beforeUpdate->asset_status != $status || $beforeUpdate->asset_used_by != $usedBy) {
            $createAssetHistory = [
                'asset_history_status' => $status,
                'asset_id' =>  $input['asset_id'],
                'historyable_id' => $historyId,
                'historyable_type' => $historyClass,
                'asset_history_user_id' => Auth::user()->user_id,
            ];
            AssetHistory::create($createAssetHistory);
        }
    }

    public static function transform($data) {
        return [
            'asset_id' => $data->asset_id ?? null,
            'asset_category_name' => $data->asset_category->asset_category_name ?? null,
            'asset_category_code' => $data->asset_category->asset_category_code ?? null,
            'item_category_code' => $data->item_category->item_category_code ?? null,
            'item_category_name' => $data->item_category->item_category_name ?? null,
            'asset_code' => $data->asset_code ?? null,
            'asset_status' => $data->asset_status ?? null,
            'asset_procurement_year' => $data->asset_procurement_year ?? null,
            'asset_asaloleh_category_name' => $data->asal_oleh->asaloleh_category_name ?? null,
            'asset_asalpengadaan_category_name' => $data->asal_pengadaan->asalpengadaan_category_name ?? null,
            'asset_asaloleh_date' => $data->asset_asaloleh_date ? date('d-m-Y', strtotime($data->asset_asaloleh_date)) : null,
            'asset_name' => $data->asset_name ?? null,
            'asset_item_name' => $data->item->item_name ?? null,
            'asset_bahan_name' => $data->bahan->bahan_category_name ?? null,
            'asset_serial_number' => $data->asset_serial_number ?? null,
            'asset_price' => numberFormat($data->asset_price) ?? null,
            'asset_shrinkage' => $data->asset_shrinkage .'%' ?? null,
            'asset_specification' => $data->asset_specification ?? null,
            'asset_frame_number' => $data->asset_frame_number ?? null,
            'asset_machine_number' => $data->asset_machine_number ?? null,
            'asset_police_number' => $data->asset_police_number ?? null,
        ];
    }
}
