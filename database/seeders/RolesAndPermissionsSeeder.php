<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // Resetar roles e permissions cacheados
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Criar Permissões
        Permission::create(['name' => 'gerenciar livros']);
        Permission::create(['name' => 'gerenciar usuarios']);
        Permission::create(['name' => 'fazer emprestimos']);

        // Criar Papéis e atribuir permissões
        $cliente = Role::create(['name' => 'cliente']);
        $cliente->givePermissionTo('fazer emprestimos');

        $bibliotecario = Role::create(['name' => 'bibliotecario']);
        $bibliotecario->givePermissionTo('gerenciar livros');
        $bibliotecario->givePermissionTo('fazer emprestimos');

        $admin = Role::create(['name' => 'admin']);
        // O Admin herda todas as permissões do bibliotecario
        $admin->givePermissionTo($bibliotecario->permissions);
        // E também pode gerenciar usuários
        $admin->givePermissionTo('gerenciar usuarios');
    }
}