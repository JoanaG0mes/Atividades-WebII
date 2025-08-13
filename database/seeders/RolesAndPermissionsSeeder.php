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
        Permission::create(['name' => 'gerenciar acervo']);
        Permission::create(['name' => 'gerenciar usuarios']);
        Permission::create(['name' => 'realizar emprestimos']); // Garante que esta permissão é criada

        // Criar Papéis e atribuir permissões
        Role::create(['name' => 'cliente'])
            ->givePermissionTo('realizar emprestimos');

        Role::create(['name' => 'bibliotecario'])
            ->givePermissionTo(['gerenciar acervo', 'realizar emprestimos']);

        // Garante que o admin tem TODAS as permissões
        Role::create(['name' => 'admin'])
            ->givePermissionTo(Permission::all());
    }
}
