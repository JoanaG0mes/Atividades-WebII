@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="my-4">Detalhes do Livro</h1>

    @if (session('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
    @endif
  @if (session('error'))
    <div class="alert alert-danger" role="alert">
        {{ session('error') }}
    </div>
 @endif

    <div class="card mb-4">
        <div class="card-body d-flex flex-column flex-md-row align-items-start">
            <div class="me-md-4 mb-3 mb-md-0 text-center">
                @if($book->cover_image)
                    <img src="{{ asset('storage/' . $book->cover_image) }}" alt="Capa do Livro" class="img-fluid rounded shadow" style="max-width: 200px; height: auto;">
                @else
                    <img src="{{ asset('img/default_cover.png') }}" alt="Capa Padrão" class="img-fluid rounded shadow" style="max-width: 200px; height: auto;">
                @endif
            </div>
            <div>
                <h2>{{ $book->title }}</h2>
                <p><strong>Autor:</strong>
                    <a href="{{ route('authors.show', $book->author->id) }}">
                        {{ $book->author->name }}
                    </a>
                </p>
                <p><strong>Publicação:</strong>
                    <a href="{{ route('publishers.show', $book->publisher->id) }}">
                        {{ $book->publisher->name }}
                    </a>
                </p>
                <p><strong>Categoria:</strong>
                    <a href="{{ route('categories.show', $book->category->id) }}">
                        {{ $book->category->name }}
                    </a>
                </p>
            </div>
        </div>
        <div class="card-footer d-flex align-items-center">
            <a href="{{ route('books.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Voltar à Lista
            </a>
            <div class="ms-auto">
                @can('update', $book)
                    <a href="{{ route('books.edit', $book) }}" class="btn btn-warning">Editar</a>
                @endcan
                @can('delete', $book)
                    <form action="{{ route('books.destroy', $book) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Tem a certeza?')">Excluir</button>
                    </form>
                @endcan
            </div>
        </div>
    </div>

    <!-- Formulário para Empréstimos -->
    @can('realizar emprestimos')
        <div class="card mb-4">
            <div class="card-header">
                <h5>Realizar Empréstimo</h5>
            </div>
            <div class="card-body">
                @if($isAvailable)
                    <form action="{{ route('books.borrow', $book) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-success">Pegar Livro Emprestado</button>
                    </form>
                @else
                    <p class="text-danger">Este livro não está disponível para empréstimo no momento.</p>
                @endif
            </div>
        </div>
    @endcan

    <!-- Histórico de Empréstimos -->
    <div class="card mt-4">
        <div class="card-header">Histórico de Empréstimos</div>
        <div class="card-body">
            @if($book->users->isEmpty())
                <p>Este livro nunca foi emprestado.</p>
            @else
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Utilizador</th>
                            <th>Data de Empréstimo</th>
                            <th>Data de Devolução</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($book->users as $user)
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>{{ \Carbon\Carbon::parse($user->pivot->borrowed_at)->format('d/m/Y') }}</td>
                                <td>
                                    @if($user->pivot->returned_at)
                                        {{ \Carbon\Carbon::parse($user->pivot->returned_at)->format('d/m/Y') }}
                                    @else
                                        <span class="badge bg-warning text-dark">Emprestado</span>
                                    @endif
                                </td>
                                <td>
                                    @if(is_null($user->pivot->returned_at))
                                        <form action="{{ route('borrowings.return', $user->pivot->id) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button class="btn btn-warning btn-sm">Devolver</button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</div>
@endsection
