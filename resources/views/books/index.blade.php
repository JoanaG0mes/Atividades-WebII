{{-- Este é o código completo e corrigido. Por favor, substitua todo o conteúdo do seu ficheiro por este. --}}
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Lista de Livros</h1>
        

        @can('create', App\Models\Book::class)
            <div>
                <a href="{{ route('books.create.select') }}" class="btn btn-primary">
                    Adicionar (com Seleção)
                </a>
                <a href="{{ route('books.create.id') }}" class="btn btn-secondary">
                    Adicionar (com ID)
                </a>
            </div>
        @endcan
    </div>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table table-striped table-hover">
        <thead class="thead-dark">
            <tr>
                <th>ID</th>
                <th>Capa</th>
                <th>Título</th>
                <th>Autor</th>
                <th>Editora</th>
                <th>Categoria</th>
                <th class="text-end">Ações</th>
            </tr>
        </thead>
        <tbody>
            @forelse($books as $book)
                <tr>
                    <td>{{ $book->id }}</td>
                    <td>
                        @if($book->cover_image)
                            <img src="{{ asset('storage/' . $book->cover_image) }}" alt="Capa de {{ $book->title }}" width="50" style="height: 75px; object-fit: cover;">
                        @else
                            <img src="{{ asset('img/default_cover.png') }}" alt="Capa padrão" width="50" style="height: 75px; object-fit: cover;">
                        @endif
                    </td>
                    <td><a href="{{ route('books.show', $book) }}">{{ $book->title }}</a></td>
                    <td>{{ $book->author->name }}</td>
                    <td>{{ $book->publisher->name }}</td>
                    <td>{{ $book->category->name }}</td>
                    <td class="text-end">
                        
              
                        @can('update', $book)
                            <a href="{{ route('books.edit', $book) }}" class="btn btn-warning btn-sm">Editar</a>
                        @endcan

            
                        @can('delete', $book)
                            <form action="{{ route('books.destroy', $book) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza que deseja excluir este livro?')">Excluir</button>
                            </form>
                        @endcan
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">Nenhum livro encontrado.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="d-flex justify-content-center">
        {{ $books->links() }}
    </div>
</div>
@endsection
