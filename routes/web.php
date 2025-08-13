<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PublisherController;
use App\Http\Controllers\BorrowingController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\UserController as AdminUserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

// Grupo para todas as ações que exigem que o utilizador esteja autenticado
Route::middleware('auth')->group(function () {
    
    // Rotas específicas para criação de livros
    Route::get('/books/create-select', [BookController::class, 'createWithSelect'])->name('books.create.select');
    Route::post('/books/create-select', [BookController::class, 'storeWithSelect'])->name('books.store.select');
    Route::get('/books/create-id', [BookController::class, 'createWithId'])->name('books.create.id');
    Route::post('/books/create-id', [BookController::class, 'storeWithId'])->name('books.store.id');

    // Rotas resource para o resto do acervo (a proteção é feita dentro de cada controller com as Policies)
    Route::resource('books', BookController::class)->except(['create', 'store']);
    Route::resource('authors', AuthorController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('publishers', PublisherController::class);

    // Rota para a página de perfil e empréstimos do cliente
    Route::get('/meus-emprestimos', [ProfileController::class, 'show'])->name('profile.show');

    // Rota para registar um empréstimo
    Route::post('/books/{book}/borrow', [BorrowingController::class, 'store'])->name('books.borrow');
    
    // Rota para devolver um livro
    Route::patch('/borrowings/{borrowing}/return', [BorrowingController::class, 'returnBook'])->name('borrowings.return');
    
    // Rotas de Administração
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::resource('users', AdminUserController::class)->only(['index', 'edit', 'update']);
    });
});
