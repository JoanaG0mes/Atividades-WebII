<?php

namespace App\Policies;

use App\Models\Author;
use App\Models\User;

class AuthorPolicy
{
    /**
     * Permite que o admin faça qualquer ação.
     */
    public function before(User $user): ?bool
    {
        return $user->hasRole('admin') ? true : null;
    }

    /**
     * Determina se o utilizador pode ver qualquer autor.
     */
    public function viewAny(User $user): bool
    {
        return true; // Todos os utilizadores logados podem ver a lista
    }

    /**
     * Determina se o utilizador pode ver um autor específico.
     */
    public function view(User $user, Author $author): bool
    {
        return true; // Todos os utilizadores logados podem ver os detalhes
    }

    /**
     * Determina se o utilizador pode criar autores.
     */
    public function create(User $user): bool
    {
        return $user->can('gerenciar acervo');
    }

    /**
     * Determina se o utilizador pode atualizar um autor.
     */
    public function update(User $user, Author $author): bool
    {
        return $user->can('gerenciar acervo');
    }

    /**
     * Determina se o utilizador pode excluir um autor.
     */
    public function delete(User $user, Author $author): bool
    {
        return $user->can('gerenciar acervo');
    }
}
