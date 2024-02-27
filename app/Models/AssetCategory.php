<?php

namespace App\Models;

use App\Trait\UuidTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AssetCategory extends Model
{
    use SoftDeletes, UuidTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $primaryKey = 'asset_category_id';

    protected $fillable = ['asset_category_name', 'asset_category_code'];

    public function asset()
    {
        return $this->hasMany(Asset::class, 'asset_category_id', 'asset_category_id');
    }
}
