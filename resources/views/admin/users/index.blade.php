@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header"><h5>Gerenciar Usuários</h5></div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success" role="alert">
                    {{ session('success') }}
                </div>
            @endif

            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Email</th>
                        <th>Papel</th>
                        <th class="text-end">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                {{-- Pega o primeiro papel do usuário e exibe --}}
                                @if($user->roles->isNotEmpty())
                                    <span class="badge bg-primary">{{ $user->roles->first()->name }}</span>
                                @else
                                    <span class="badge bg-secondary">Nenhum papel</span>
                                @endif
                            </td>
                            <td class="text-end">
                                {{-- Verifica se o usuário logado PODE ATUALIZAR o usuário da linha --}}
                                @can('update', $user)
                                    <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-warning">Editar Papel</a>
                                @endcan
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">Nenhum usuário encontrado.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="d-flex justify-content-center">
                {{ $users->links() }}
            </div>
        </div>
    </div>
</div>
@endsection