@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Adicionar Novo Livro (com Seleção)</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('books.store.select') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        {{-- Campo Título --}}
                        <div class="mb-3">
                            <label for="title" class="form-label">Título</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title') }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Campo Editora --}}
                        <div class="mb-3">
                            <label for="publisher_id" class="form-label">Editora</label>
                            <select class="form-select @error('publisher_id') is-invalid @enderror" id="publisher_id" name="publisher_id" required>
                                <option value="" disabled selected>Selecione uma editora</option>
                                @foreach($publishers as $publisher)
                                    <option value="{{ $publisher->id }}" @if(old('publisher_id') == $publisher->id) selected @endif>
                                        {{ $publisher->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('publisher_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Campo Autor --}}
                        <div class="mb-3">
                            <label for="author_id" class="form-label">Autor</label>
                            <select class="form-select @error('author_id') is-invalid @enderror" id="author_id" name="author_id" required>
                                <option value="" disabled selected>Selecione um autor</option>
                                @foreach($authors as $author)
                                    <option value="{{ $author->id }}" @if(old('author_id') == $author->id) selected @endif>
                                        {{ $author->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('author_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Campo Categoria --}}
                        <div class="mb-3">
                            <label for="category_id" class="form-label">Categoria</label>
                            <select class="form-select @error('category_id') is-invalid @enderror" id="category_id" name="category_id" required>
                                <option value="" disabled selected>Selecione uma categoria</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" @if(old('category_id') == $category->id) selected @endif>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
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
