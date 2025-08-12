<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role; // Importa o modelo Role do Spatie

class UserController extends Controller
{
    /**
     * Exibe uma lista de todos os usuários.
     */
    public function index()
    {
        // Usamos paginação para não sobrecarregar a tela com muitos usuários
        $users = User::paginate(10);
        
        return view('admin.users.index', compact('users'));
    }

    /**
     * Mostra o formulário para editar um usuário específico.
     */
    public function edit(User $user)
    {
        // Aciona a UserPolicy para verificar se o usuário logado PODE ATUALIZAR este $user
        $this->authorize('update', $user);
        
        // Busca todos os papéis disponíveis no banco de dados para popular o formulário
        $roles = Role::all();

        // Retorna a view de edição, passando o usuário a ser editado e a lista de papéis
        return view('admin.users.edit', compact('user', 'roles'));
    }

    /**
     * Atualiza o usuário no banco de dados.
     */
    public function update(Request $request, User $user)
    {
        // Aciona a UserPolicy para garantir que o usuário logado pode fazer esta ação
        $this->authorize('update', $user);

        // Valida se o papel enviado no formulário existe na nossa tabela de 'roles'
        $request->validate([
            'role' => 'required|exists:roles,name',
        ]);

        // Usa o método syncRoles do Spatie para atribuir o novo papel.
        // Ele remove os papéis antigos e adiciona o novo, garantindo que o usuário tenha apenas um.
        $user->syncRoles($request->role);

        return redirect()->route('admin.users.index')->with('success', 'Papel do usuário atualizado com sucesso!');
    }
}