<?php

namespace App\Models;

use App\Trait\UuidTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ItemCategory extends Model
{
    use SoftDeletes, UuidTrait;
 
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $primaryKey = 'item_category_id';

    protected $fillable = ['asset_category_id','item_category_name','item_category_code','item_category_icon','item_category_color','item_category_text', 'item_category_color_bg'];

    public function asset_category()
    {
        return $this->belongsTo(AssetCategory::class, 'asset_category_id', 'asset_category_id');
    }

    public function asset()
    {
        return $this->hasMany(Asset::class, 'asset_category_id', 'asset_category_id');
    }
}
