<?php

namespace App\Models;

use App\Trait\UuidTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AsalpengadaanCategory extends Model
{
    use SoftDeletes, UuidTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $primaryKey = 'asalpengadaan_category_id';

    protected $fillable = ['asalpengadaan_category_name','asalpengadaan_category_code'];

    public function asset()
    {
        return $this->hasMany(Asset::class, 'asalpengadaan_category_id', 'asalpengadaan_category_id');
    }
}

