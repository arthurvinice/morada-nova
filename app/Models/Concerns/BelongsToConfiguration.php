<?php

namespace App\Models\Concerns;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

trait BelongsToConfiguration
{
    protected static function bootBelongsToConfiguration(): void
    {
        static::addGlobalScope('configuration', function (Builder $builder) {
            $configurationId = static::currentConfigurationId();

            if ($configurationId !== null) {
                $builder->where(
                    $builder->getModel()->getTable() . '.configuration_id',
                    $configurationId
                );
            }
        });

        static::creating(function ($model) {
            if (empty($model->configuration_id)) {
                $model->configuration_id = static::currentConfigurationId();
            }
        });
    }

    /**
     * Resolve a configuration_id do usuário autenticado sem recursão,
     * evitando reaplicar o Global Scope sobre o próprio model User
     * durante a resolução da autenticação.
     */
    protected static function currentConfigurationId(): ?int
    {
        static $resolved = false;
        static $cached = null;

        if ($resolved) {
            return $cached;
        }

        $resolved = true;

        if (! Auth::check()) {
            return $cached;
        }

        $user = User::withoutGlobalScope('configuration')->find(Auth::id());

        if (! $user || $user->isSuperAdmin()) {
            $cached = null;
        } else {
            $cached = $user->configuration_id;
        }

        return $cached;
    }

    public function configuration()
    {
        return $this->belongsTo(Configuration::class);
    }
}