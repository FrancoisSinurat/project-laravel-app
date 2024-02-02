<?php

namespace App\Models;

use App\Trait\UuidTrait;
use Spatie\Permission\Models\Permission as SpatiePermission;

class Permission extends SpatiePermission
{
    use UuidTrait;

    protected $fillable = ['id','name','guard_name'];
}
