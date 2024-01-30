<?php

namespace App\Models;

use App\Trait\UuidTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class AssetCategory extends Authenticatable
{
    use UuidTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $primaryKey = 'asset_category_id';

    protected $fillable = ['asset_category_name'];
}
