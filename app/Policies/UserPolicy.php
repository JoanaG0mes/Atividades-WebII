<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;

class UserPolicy
{
    // Apenas quem pode 'gerenciar usuarios' pode atualizar outros usuários
    public function update(User $user, User $model): bool
    {
        return $user->can('gerenciar usuarios');
    }
}