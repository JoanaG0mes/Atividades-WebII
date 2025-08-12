@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Adicionar Novo Livro (com ID)</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('books.store.id') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        {{-- Campo Título --}}
                        <div class="mb-3">
                            <label for="title" class="form-label">Título</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title') }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Campo ID da Editora --}}
                        <div class="mb-3">
                            <label for="publisher_id" class="form-label">ID da Editora</label>
                            <input type="number" class="form-control @error('publisher_id') is-invalid @enderror" id="publisher_id" name="publisher_id" value="{{ old('publisher_id') }}" required>
                            @error('publisher_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Campo ID do Autor --}}
                        <div class="mb-3">
                            <label for="author_id" class="form-label">ID do Autor</label>
                            <input type="number" class="form-control @error('author_id') is-invalid @enderror" id="author_id" name="author_id" value="{{ old('author_id') }}" required>
                            @error('author_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Campo ID da Categoria --}}
                        <div class="mb-3">
                            <label for="category_id" class="form-label">ID da Categoria</label>
                            <input type="number" class="form-control @error('category_id') is-invalid @enderror" id="category_id" name="category_id" value="{{ old('category_id') }}" required>
                            @error('category_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        {{-- Campo de Upload de Imagem --}}
                        <div class="mb-3">
                            <label for="cover_image" class="form-label">Capa do Livro (Opcional)</label>
                            <input class="form-control @error('cover_image') is-invalid @enderror" type="file" id="cover_image" name="cover_image">
                            @error('cover_image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('books.index') }}" class="btn btn-secondary">Cancelar</a>
                            <button type="submit" class="btn btn-success">Salvar Livro</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
