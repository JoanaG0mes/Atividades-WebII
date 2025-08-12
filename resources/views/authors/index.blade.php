@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="mb-0">Lista de Autores</h1>
        
        {{-- BOTÃO DE ADICIONAR AGORA ESTÁ PROTEGIDO --}}
        @can('create', App\Models\Author::class)
            <a href="{{ route('authors.create') }}" class="btn btn-success">
                <i class="bi bi-plus"></i> Adicionar Autor
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
            @forelse($authors as $author)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $author->name }}</td>
                    <td class="text-end">
                        {{-- O botão de visualizar é público para todos os utilizadores logados --}}
                        <a href="{{ route('authors.show', $author) }}" class="btn btn-info btn-sm">
                            Visualizar
                        </a>

                        {{-- BOTÃO DE EDITAR CORRIGIDO E PROTEGIDO --}}
                        @can('update', $author)
                            <a href="{{ route('authors.edit', $author) }}" class="btn btn-warning btn-sm">
                                Editar
                            </a>
                        @endcan

                        {{-- BOTÃO DE EXCLUIR CORRIGIDO E PROTEGIDO --}}
                        @can('delete', $author)
                            <form action="{{ route('authors.destroy', $author) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Tem a certeza?')">Excluir</button>
                            </form>
                        @endcan
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="text-center">Nenhum autor encontrado.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
