@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="mb-0">Lista de Publicações</h1>
        

        @can('create', App\Models\Publisher::class)
            <a href="{{ route('publishers.create') }}" class="btn btn-success">
                <i class="bi bi-plus"></i> Adicionar Publicação
            </a>
        @endcan
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table table-striped table-hover">
        <thead class="thead-dark">
            <tr>
                <th>#</th>
                <th>Nome</th>
                <th class="text-end">Ações</th>
            </tr>
        </thead>
        <tbody>
            @forelse($publishers as $publisher)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $publisher->name }}</td>
                    <td class="text-end">
        
                        <a href="{{ route('publishers.show', $publisher) }}" class="btn btn-info btn-sm">
                            <i class="bi bi-eye"></i> Visualizar
                        </a>

        
                        @can('update', $publisher)
                            <a href="{{ route('publishers.edit', $publisher) }}" class="btn btn-warning btn-sm">
                                <i class="bi bi-pencil"></i> Editar
                            </a>
                        @endcan

                        @can('delete', $publisher)
                            <form action="{{ route('publishers.destroy', $publisher) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Deseja excluir esta publicação?')">
                                    <i class="bi bi-trash"></i> Excluir
                                </button>
                            </form>
                        @endcan
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="text-center">Nenhuma publicação encontrada.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
