<?php

namespace App\Models;

use App\Trait\UuidTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ItemBrand extends Model
{
    use UuidTrait, SoftDeletes;

    protected $primaryKey = 'item_brand_id';

    protected $fillable = ['item_brand_name'];

    /**
     * Get the user that owns the ItemBrand
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function type()
    {
        return $this->hasMany(ItemType::class, 'item_brand_id', 'item_brand_id');
    }

    public function asset()
    {
        return $this->hasMany(Asset::class, 'item_brand_id', 'item_brand_id');
    }

}
