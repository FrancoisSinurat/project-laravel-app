<?php

namespace App\Models;

use App\Trait\UuidTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Location extends Model
{
    use SoftDeletes, UuidTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $primaryKey = 'location_id';

    protected $fillable = ['location_name', 'address'];

    public function asset()
    {
        return $this->hasMany(Asset::class, 'location_id', 'location_id');
    }
}
