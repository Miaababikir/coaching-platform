<?php

namespace App\Traits;

trait IsUser
{

    public static function boot(): void
    {
        parent::boot();

        static::creating(function ($model) {
            $model->forceFill(['type' => static::class]);
        });
    }

    public static function booted(): void
    {
        static::addGlobalScope('type', function ($builder) {
            $builder->where('type', static::class);
        });
    }

}
