<?php

namespace App\Trait;

use Illuminate\Support\Str;

trait UuidTrait
{
    public static function booted()
    {
        static::creating(function ($model) {
            $model->keyType = 'string';
            $model->incrementing = false;
            $model->{$model->getKeyName()} = $model->{$model->getKeyName()} ?: (string) Str::orderedUuid();
        });
    }

    public function getIncrementing()
    {
        return false;
    }

    public function getKeyType()
    {
        return 'string';
    }
}
