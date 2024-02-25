<?php

namespace App\Models;

use App\Trait\UuidTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Profile extends Model
{
    use SoftDeletes, UuidTrait;

    protected $primaryKey = 'profile_id';

    protected $fillable = [
        'user_id',
        'profile_pegawai_id',
        'profile_nip',
        'profile_phone',
        'profile_photo',
        'profile_photo_thumbnail',
        'profile_signature'
    ];
}
