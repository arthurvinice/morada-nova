<?php

namespace App\Models\Concerns;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

trait BelongsToConfiguration
{
    protected static function bootBelongsToConfiguration(): void
    {
        static::addGlobalScope('configuration', function (Builder $builder) {
            if (Auth::check() && ! Auth::user()->isSuperAdmin()) {
                $builder->where(
                    $builder->getModel()->getTable() . '.configuration_id',
                    Auth::user()->configuration_id
                );
            }
        });

        static::creating(function ($model) {
            if (Auth::check() && empty($model->configuration_id)) {
                $model->configuration_id = Auth::user()->configuration_id;
            }
        });
    }

    public function configuration()
    {
        return $this->belongsTo(Configuration::class);
    }
}