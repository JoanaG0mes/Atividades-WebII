@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Gestão de Multas</h5>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <table class="table table-striped table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th>Nome do Utilizador</th>
                        <th>Email</th>
                        <th>Débito (R$)</th>
                        <th class="text-end">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($usersWithDebit as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ number_format($user->debit, 2, ',', '.') }}</td>
                            <td class="text-end">
                                <form action="{{ route('admin.fines.clear', $user) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-success btn-sm" onclick="return confirm('Tem a certeza que deseja zerar o débito deste utilizador?')">
                                        Zerar Débito
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">Nenhum utilizador com débitos pendentes.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection