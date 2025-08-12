<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\ProfileController;

Route::get('/', function () { return view('welcome'); });
Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Grupo para todas as ações que exigem login
Route::middleware('auth')->group(function () {
    
    // Rotas de criação de livros
    Route::get('/books/create-select', [BookController::class, 'createWithSelect'])->name('books.create.select');
    Route::post('/books/create-select', [BookController::class, 'storeWithSelect'])->name('books.store.select');
    Route::get('/books/create-id', [BookController::class, 'createWithId'])->name('books.create.id');
    Route::post('/books/create-id', [BookController::class, 'storeWithId'])->name('books.store.id');
    
    // As rotas resource para livros, excluindo as de criação que definimos acima
    Route::resource('books', BookController::class)->except(['create', 'store']);

    // ... outras rotas (categories, authors, etc.) ...

    // Rotas de Admin
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::resource('users', AdminUserController::class)->only(['index', 'edit', 'update']);
    });
       Route::get('/meus-emprestimos', [ProfileController::class, 'show'])->name('profile.show');

});
