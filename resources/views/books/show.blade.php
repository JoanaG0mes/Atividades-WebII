@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="my-4">Detalhes do Livro</h1>

    <div class="card mb-4">
        <div class="card-header">
            <strong>Título:</strong>
        </div>
        <div class="card-body d-flex flex-column flex-md-row align-items-center">
            <div class="me-md-4 mb-3 mb-md-0"
                @if($book->cover_image)
                
              
                    <img src="{{ asset('storage/' . $book->cover_image) }}" alt="Capa do Livro" class="img-fluid rounded" style="max-width: 200px; height: auto;">
                @else
                 
                    <img src="{{ asset('imagens/default_cover.png') }}" alt="Capa Padrão" class="img-fluid rounded" style="max-width: 200px; height: auto;">
                @endif
            </div>
            <div>
                <p><strong>Autor:</strong>
                    <a href="{{ route('authors.show', $book->author->id) }}">
              
                    </a>
                </p>
                <p><strong>Editora:</strong>
                    <a href="{{ route('publishers.show', $book->publisher->id) }}">
                        
                    </a>
                </p>
                <p><strong>Categoria:</strong>
                    <a href="{{ route('categories.show', $book->category->id) }}">
               
                    </a>
                </p>
            </div>
        </div>
    </div>

    <a href="{{ route('books.index') }}" class="btn btn-secondary mt-3">
        <i class="bi bi-arrow-left"></i> Voltar
    </a>
</div>

<!-- Formulário para Empréstimos -->
<div class="card mb-4 mt-4">
@can('realizar emprestimos')
    <hr>
    <h5>Registrar Empréstimo</h5>
    <form action="{{ route('books.borrow', $book) }}" method="POST">
        @csrf

        <input type="hidden" name="user_id" value="{{ auth()->id() }}">
        <button type="submit" class="btn btn-success">Realizar emprestimo</button>
    </form>
@endcan

<!-- Histórico de Empréstimos -->
<div class="card mt-4">
    <div class="card-header">Histórico de Empréstimos</div>
    <div class="card-body">
        @if($book->users->isEmpty())
            <p>Nenhum empréstimo registrado.</p>
        @else
            <table class="table">
                <thead>
                    <tr>
                        <th>Usuário</th>
                        <th>Data de Empréstimo</th>
                        <th>Data de Devolução</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
    @foreach($book->users as $user)
        <tr>
            <td>
                <a href="{{ route('users.show', $user->id) }}">
               
                </a>
            </td>
            <td></td>
            <td></td>
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
@endsection
