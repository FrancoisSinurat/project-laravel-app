<?php

namespace App\Models;

use App\Trait\UuidTrait;
use Spatie\Permission\Models\Role as SpatieRole;

class Role extends SpatieRole
{
    use UuidTrait;

    protected $fillable = ['id','name','guard_name'];
}
