<?php

namespace App\Models;

use App\Trait\UuidTrait;
<<<<<<< HEAD
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class BahanCategory extends Authenticatable
=======
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BahanCategory extends Model
>>>>>>> f1212646ed25f5c37e5d9c7bd17f296dc33664c6
{
    use SoftDeletes, UuidTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $primaryKey = 'bahan_category_id';

    protected $fillable = ['bahan_category_name'];
}
