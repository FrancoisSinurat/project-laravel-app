<?php

namespace App\Models;

use App\Trait\UuidTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ItemType extends Model
{
    use UuidTrait, SoftDeletes;

    protected $primaryKey = 'item_type_id';
    protected $fillable = ['item_type_name', 'item_brand_id'];

    public function item_brand(): BelongsTo
    {
        return $this->belongsTo(ItemBrand::class, 'item_brand_id', 'item_brand_id');
    }
}
