<?php

namespace App\Models;

use App\Trait\UuidTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AsalolehCategory extends Model
{
    use SoftDeletes, UuidTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $primaryKey = 'asaloleh_category_id';

    protected $fillable = ['asaloleh_category_name'];

    public function asset_group()
    {
        return $this->hasMany(AssetGroup::class, 'asaloleh_category_id', 'asaloleh_category_id');
    }
}
