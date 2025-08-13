@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="mb-0">Lista de Categorias</h1>
   
        @can('create', App\Models\Category::class)
            <a href="{{ route('categories.create') }}" class="btn btn-success">
                <i class="bi bi-plus"></i> Adicionar Categoria
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
            @forelse($categories as $category)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $category->name }}</td>
                    <td class="text-end">
           
                        <a href="{{ route('categories.show', $category) }}" class="btn btn-info btn-sm">
                            Visualizar
                        </a>

                        @can('update', $category)
                            <a href="{{ route('categories.edit', $category) }}" class="btn btn-warning btn-sm">
                                Editar
                            </a>
                        @endcan

               
                        @can('delete', $category)
                            <form action="{{ route('categories.destroy', $category) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Tem a certeza?')">Excluir</button>
                            </form>
                        @endcan
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="text-center">Nenhuma categoria encontrada.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
