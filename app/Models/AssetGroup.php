<?php

namespace App\Models;

use App\Trait\UuidTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AssetGroup extends Model
{
    use SoftDeletes, UuidTrait;
    protected $primaryKey = 'asset_group_id';

    protected $fillable = [
        'asalpengadaan_category_id',
        'asaloleh_category_id',
        'asset_document_number',
        'asset_asaloleh_date',
        'asset_procurement_year',
        'asset_documents',
        'asset_group_items'
    ];

    public function asset()
    {
        return $this->hasMany(Asset::class, 'asset_group_id', 'asset_group_id');
    }

    public function asal_oleh()
    {
        return $this->belongsTo(AsalolehCategory::class, 'asaloleh_category_id', 'asaloleh_category_id');
    }

    public function asal_pengadaan()
    {
        return $this->belongsTo(AsalpengadaanCategory::class, 'asalpengadaan_category_id', 'asalpengadaan_category_id');
    }
}
