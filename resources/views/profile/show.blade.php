@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Meu Perfil e Histórico de Empréstimos</h5>
        </div>
        <div class="card-body">
            <p><strong>Nome:</strong> {{ $user->name }}</p>
            <p><strong>Email:</strong> {{ $user->email }}</p>

            <hr>

            <h4>Meus Empréstimos</h4>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Capa</th>
                        <th>Título do Livro</th>
                        <th>Data do Empréstimo</th>
                        <th>Data da Devolução</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($borrowings as $book)
                        <tr>
                            <td>
                                @if($book->cover_image)
                                    <img src="{{ asset('storage/' . $book->cover_image) }}" alt="Capa" width="40">
                                @else
                                    <img src="{{ asset('img/default.png') }}" alt="Capa Padrão" width="40">
                                @endif
                            </td>
                            <td>{{ $book->title }}</td>
                            <td>{{ \Carbon\Carbon::parse($book->pivot->borrowed_at)->format('d/m/Y') }}</td>
                            <td>
                                @if ($book->pivot->returned_at)
                                    {{ \Carbon\Carbon::parse($book->pivot->returned_at)->format('d/m/Y') }}
                                @else
                                    <span class="badge bg-warning text-dark">Emprestado</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">Você ainda não pegou nenhum livro emprestado.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
