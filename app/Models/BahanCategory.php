<?php

namespace App\Models;

use App\Trait\UuidTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BahanCategory extends Model
{
    use SoftDeletes, UuidTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $primaryKey = 'bahan_category_id';

    protected $fillable = ['bahan_category_name'];

    public function asset()
    {
        return $this->hasMany(Asset::class, 'bahan_category_id', 'bahan_category_id');
    }
}
