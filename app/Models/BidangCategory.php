<?php

namespace App\Models;

use App\Trait\UuidTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class BidangCategory extends Authenticatable
{
    use SoftDeletes, UuidTrait;
 
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $primaryKey = 'bidang_category_id';

    protected $fillable = ['bidang_category_name','bidang_category_singkatan'];
}

