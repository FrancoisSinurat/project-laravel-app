<?php

namespace App\Models;

use App\Trait\UuidTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AssetTemporary extends Model
{
    use SoftDeletes, UuidTrait;

    protected $table = 'asset_temporaries';
    protected $primaryKey = 'asset_temporary_id';

    protected $fillable = [
        'asset_temporary_user_id',
        'asset_temporary_bpad_code',
        'asset_temporary_serial_number',
        'asset_temporary_frame_number',
        'asset_temporary_machine_number',
        'asset_temporary_police_number',
    ];

}
