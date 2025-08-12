<?php

namespace App\Policies;

use App\Models\Book;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class BookPolicy
{
    // O admin pode fazer tudo, então damos acesso total antes de outras checagens
    public function before(User $user, string $ability): bool|null
    {
        if ($user->hasRole('admin')) {
            return true;
        }
        return null;
    }
    // Apenas quem tem a permissão 'gerenciar livros' pode criar, editar ou deletar
    public function create(User $user): bool { return $user->can('gerenciar livros'); }
    public function update(User $user): bool { return $user->can('gerenciar livros'); }
    public function delete(User $user): bool { return $user->can('gerenciar livros'); }
}