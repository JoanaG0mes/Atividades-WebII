<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();


        Permission::create(['name' => 'gerenciar acervo']);
        Permission::create(['name' => 'gerenciar usuarios']);
        Permission::create(['name' => 'realizar emprestimos']);
        Permission::create(['name' => 'gerenciar multas']);


        Role::create(['name' => 'admin'])
            ->givePermissionTo(Permission::all());


        Role::create(['name' => 'cliente'])
            ->givePermissionTo('realizar emprestimos');
    }
}