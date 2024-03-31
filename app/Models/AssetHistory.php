<?php

namespace App\Models;

use App\Trait\UuidTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AssetHistory extends Model
{
    use SoftDeletes, UuidTrait;

    protected $primaryKey = 'asset_history_id';
    protected $fillable = [
        'asset_history_status',
        'asset_id',
        'historyable_id',
        'historyable_type',
        'asset_history_user_id',
    ];

    /**
     * Get the user that owns the AssetHistory
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'asset_history_user_id', 'user_id');
    }

    public function historyable()
    {
        return $this->morphTo();
    }
}
