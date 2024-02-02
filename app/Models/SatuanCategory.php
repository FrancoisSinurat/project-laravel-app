<?php

namespace App\Models;
 
use App\Trait\UuidTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class SatuanCategory extends Authenticatable
{
    use SoftDeletes, UuidTrait;
 
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $primaryKey = 'satuan_category_id';

    protected $fillable = ['satuan_category_name','satuan_category_description'];

}
