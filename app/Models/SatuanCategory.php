<?php

namespace App\Models;

use App\Trait\UuidTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SatuanCategory extends Model
{
    use SoftDeletes, UuidTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $primaryKey = 'satuan_category_id';

    protected $fillable = ['satuan_category_name','satuan_category_description'];

    public function asset()
    {
        return $this->hasMany(Asset::class, 'satuan_category_id', 'satuan_category_id');
    }
}
