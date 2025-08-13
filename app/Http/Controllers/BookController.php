<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Author;
use App\Models\Publisher;
use App\Models\Category;
use App\Models\Borrowing; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{


    public function index()
    {
        $books = Book::with(['author', 'publisher', 'category'])->paginate(10);
        return view('books.index', compact('books'));
    }


    public function show(Book $book)
    {

        $isAvailable = !Borrowing::where('book_id', $book->id)
                                 ->whereNull('returned_at')
                                 ->exists();

        
        $book->load('users');


        return view('books.show', compact('book', 'isAvailable'));
    }


    public function createWithSelect()
    {
        $this->authorize('create', Book::class);
        $authors = Author::all();
        $publishers = Publisher::all();
        $categories = Category::all();
        return view('books.create-select', compact('authors', 'publishers', 'categories'));
    }

    public function storeWithSelect(Request $request)
    {
        $this->authorize('create', Book::class);
        // ... (lógica do seu método store)
    }

    public function createWithId()
    {
        $this->authorize('create', Book::class);
        return view('books.create-id');
    }

    public function storeWithId(Request $request)
    {
        $this->authorize('create', Book::class);
        // ... (lógica do seu método store)
    }

    public function edit(Book $book)
    {
        $this->authorize('update', $book);
        $authors = Author::all();
        $publishers = Publisher::all();
        $categories = Category::all();
        return view('books.edit', compact('book', 'authors', 'publishers', 'categories'));
    }

    public function update(Request $request, Book $book)
    {
        $this->authorize('update', $book);

    }

    public function destroy(Book $book)
    {
        $this->authorize('delete', $book);
 
    }
}
