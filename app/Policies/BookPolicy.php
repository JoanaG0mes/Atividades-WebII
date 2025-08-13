<?php

namespace App\Policies;

use App\Models\Book;
use App\Models\User;

class BookPolicy
{
    /**
     * Permite que o admin faça qualquer ação.
     */
    public function before(User $user): ?bool
    {
        // Força o carregamento da relação de papéis para garantir que os dados estão presentes
        $user->loadMissing('roles'); 

        return $user->hasRole('admin') ? true : null;
    }

    /**
     * Determina se o utilizador pode criar livros.
     */
    public function create(User $user): bool
    {
        return $user->can('gerenciar acervo');
    }

    /**
     * Determina se o utilizador pode atualizar um livro.
     */
    public function update(User $user, Book $book): bool
    {
        return $user->can('gerenciar acervo');
    }

    /**
     * Determina se o utilizador pode excluir um livro.
     */
    public function delete(User $user, Book $book): bool
    {
        return $user->can('gerenciar acervo');
    }
}
