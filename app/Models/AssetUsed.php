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

    public function histories()
    {
        // return $this->morphMany(AssetHistory::class, 'historyable', AssetUsed::class, 'asset_used_id', 'asset_historyable_id');
        return $this->morphMany(AssetHistory::class, 'historyable');
    }

    /**
     * Get the user that owns the AssetUsed
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
}
