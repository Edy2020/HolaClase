<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Auth;

class ProfesorScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     */
    public function apply(Builder $builder, Model $model): void
    {
        if (Auth::hasUser()) {
            $user = Auth::user();

            if (!$user->isAdmin() && $user->profesor_id) {
                if (method_exists($model, 'applyProfesorScope')) {
                    $model->applyProfesorScope($builder, $user->profesor_id);
                } else {
                    $builder->where($model->getTable() . '.profesor_id', $user->profesor_id);
                }
            }
        }
    }
}
