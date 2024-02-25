<?php

namespace App\Models;

use App\Trait\UuidTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

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
        $item = Item::with(['brand.type'])->where('item_id', $input['item_id'])->first();
        if ($item) {
            $name = $item->item_name;
            if (!empty($item->brand)) $name .= ' '.$item->brand[0]->item_brand_name;
            if (!empty($item->brand) && !empty($item->brand[0]->type)) $name .= ' '.$item->brand[0]->type[0]->item_type_name;
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
        $result = $input;
        $result['asset_asaloleh_date'] = Carbon::createFromFormat('d-m-Y', $input['asset_asaloleh_date'])->toDateString();
        $result['asset_price'] = replaceComma($input['asset_price']);
        $result['asset_code'] = self::generateAssetCode($input);
        $result['asset_name'] = self::generateAssetName($input);
        $result['asset_qty'] = isset($input['asset_qty']) ? $input['asset_qty'] : 1;
        $result['asset_status'] = isset($input['asset_used_by']) ? Asset::STATUS_ASSET_DIGUNAKAN : Asset::STATUS_ASSET_TERSEDIA;
        return $result;
    }

    public static function createAsset($input) {
        $createAsset = Asset::create($input);
        $createAssetHistory = [
            'asset_history_status' => isset($input['asset_used_by']) ? Asset::STATUS_ASSET_DIGUNAKAN : Asset::STATUS_ASSET_TERSEDIA,
            'asset_historyable_id' => $createAsset->asset_id,
            'asset_historyable_type' => Asset::class,
            'asset_history_user_id' => Auth::user()->user_id,
        ];
        AssetHistory::create($createAssetHistory);
    }
}
