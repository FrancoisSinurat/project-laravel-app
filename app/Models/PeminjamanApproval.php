<?php

namespace App\Models;

use App\Trait\UuidTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PeminjamanApproval extends Model
{
    use SoftDeletes, UuidTrait;

    protected $table = 'asset_peminjaman_approvals';
    protected $primaryKey = 'asset_peminjaman_approval_id';
    protected $fillable = [
        'asset_peminjaman_id',
        'user_id',
        'asset_peminjaman_approval_status',
        'asset_peminjaman_approval_date',
        'sort'
    ];

    /**
     * Get the user that owns the AssetUsed
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function peminjaman()
    {
        return $this->belongsTo(Peminjaman::class, 'asset_peminjaman_id', 'asset_peminjaman_id');
    }

}
