<?php

namespace App\Models\Concerns;

use App\Models\Configuration;
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
     * Resolve a configuration_id do usuário autenticado.
     *
     * Usa um "reentrancy guard" (não um cache de valor) para evitar
     * recursão infinita quando o próprio processo de autenticação
     * (Auth::check()/Auth::id()) precisa resolver o model User, o que
     * reaciona este mesmo Global Scope. Nenhum resultado é memorizado
     * entre chamadas, então o valor é sempre recalculado com base no
     * usuário atualmente autenticado.
     */
    protected static function currentConfigurationId(): ?int
    {
        static $resolving = false;

        if ($resolving) {
            return null;
        }

        $resolving = true;

        try {
            if (! Auth::check()) {
                return null;
            }

            $user = User::withoutGlobalScope('configuration')->find(Auth::id());

            if (! $user || $user->isSuperAdmin()) {
                return null;
            }

            return $user->configuration_id;
        } finally {
            $resolving = false;
        }
    }

    public function configuration()
    {
        return $this->belongsTo(Configuration::class);
    }
}