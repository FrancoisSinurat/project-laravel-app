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
        'asset_historyable_id',
        'asset_historyable_type',
        'asset_history_user_id',
    ];

    public static function createAssetHistory($input) {
        $createAssetHistory = [
            'asset_history_status' => $input['asset_status'],
            'asset_historyable_id' => $input['historyable_id'],
            'asset_historyable_type' => $input['class'],
            'asset_history_user_id' => $input['user_id'],
        ];
        return AssetHistory::create($createAssetHistory);
    }
}
