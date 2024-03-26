<?php

namespace App\Models;

use App\Trait\UuidTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AssetUsed extends Model
{
    use SoftDeletes, UuidTrait;

    protected $table = 'asset_used';
    protected $primaryKey = 'asset_used_id';
    protected $fillable = [
        'asset_id',
        'user_id',
        'asset_used_date'
    ];
}
