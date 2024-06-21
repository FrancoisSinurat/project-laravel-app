<?php

namespace App\Models;

use App\Trait\UuidTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lokasi extends Model
{
    use SoftDeletes, UuidTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $table = 'lokasi';

    protected $primaryKey = 'id_lokasi';

    protected $fillable = ['nama_lokasi','alamat'];

    public function asset()
    {
        return $this->hasMany(Asset::class, 'id_lokasi', 'id_lokasi');
    }
}
