<?php

namespace App\Models;

use App\Trait\UuidTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Item extends Model
{
    use SoftDeletes, UuidTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $primaryKey = 'item_id';

    protected $fillable = ['item_category_id','item_name','item_code'];

    // public function user(): BelongsTo
    // {
    //     return $this->belongsTo(User::class);
    // }
    public function item_category(): BelongsTo
    {
        return $this->belongsTo(ItemCategory::class, 'item_category_id', 'item_category_id');
    }
}
