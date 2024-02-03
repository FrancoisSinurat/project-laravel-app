<?php

namespace App\Models;

use App\Trait\UuidTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class AsalolehCategory extends Authenticatable
{
    use SoftDeletes, UuidTrait;
 
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $primaryKey = 'asaloleh_category_id';

    protected $fillable = ['asaloleh_category_name'];
}
