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
        'asset_handover_date',
        'asset_used_start',
        'asset_used_end',
        'asset_used_status',
        'asset_used_by',
        'asset_handover_by',
        'asset_handover_file'
    ];

    public function histories()
    {
        return $this->morphMany(AssetHistory::class, 'historyable');
    }

    public function asset()
    {
        return $this->belongsTo(Asset::class, 'asset_id', 'asset_id');
    }

    public function user_recipient()
    {
        return $this->belongsTo(User::class, 'asset_used_by', 'asset_id');
    }

    public function user_officer()
    {
        return $this->belongsTo(User::class, 'asset_handover_by', 'asset_id');
    }
}
