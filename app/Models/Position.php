<?php

namespace App\Models;

use App\Trait\UuidTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Position extends Model
{
    use SoftDeletes, UuidTrait;

    protected $primaryKey = 'position_id';

    protected $fillable = [
        'user_id',
        'position_name',
        'position_status',
        'position_location',
        'position_sub_location',
        'position_type',
        'position_category',
        'position_echelon'
    ];
}
