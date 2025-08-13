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

    /**
     * Mostra o formulário para criar um livro usando menus de seleção.
     */
    public function createWithSelect()
    {
        $this->authorize('create', Book::class);

        $authors = Author::all();
        $publishers = Publisher::all();
        $categories = Category::all();
        
        return view('books.create-select', compact('authors', 'publishers', 'categories'));
    }

    /**
     * Salva o livro vindo do formulário com menus de seleção.
     */
    public function storeWithSelect(Request $request)
    {
        $this->authorize('create', Book::class);

        $request->validate([
            'title' => 'required|string|max:255',
            'publisher_id' => 'required|exists:publishers,id',
            'author_id' => 'required|exists:authors,id',
            'category_id' => 'required|exists:categories,id',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $bookData = $request->except('cover_image');

        if ($request->hasFile('cover_image')) {
            $path = $request->file('cover_image')->store('covers', 'public');
            $bookData['cover_image'] = $path;
        }

        Book::create($bookData);

        return redirect()->route('books.index')->with('success', 'Livro adicionado com sucesso!');
    }

    /**
     * Mostra o formulário para criar um livro inserindo os IDs manualmente.
     */
    public function createWithId()
    {
        $this->authorize('create', Book::class);
        return view('books.create-id');
    }

    /**
     * Salva o livro vindo do formulário com IDs manuais.
     */
    public function storeWithId(Request $request)
    {
        $this->authorize('create', Book::class);
        
        $request->validate([
            'title' => 'required|string|max:255',
            'publisher_id' => 'required|exists:publishers,id',
            'author_id' => 'required|exists:authors,id',
            'category_id' => 'required|exists:categories,id',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $bookData = $request->except('cover_image');

        if ($request->hasFile('cover_image')) {
            $path = $request->file('cover_image')->store('covers', 'public');
            $bookData['cover_image'] = $path;
        }

        Book::create($bookData);

        return redirect()->route('books.index')->with('success', 'Livro adicionado com sucesso!');
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
        
        $request->validate([
            'title' => 'required|string|max:255',
            'publisher_id' => 'required|exists:publishers,id',
            'author_id' => 'required|exists:authors,id',
            'category_id' => 'required|exists:categories,id',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $bookData = $request->except('cover_image');

        if ($request->hasFile('cover_image')) {
            if ($book->cover_image) {
                Storage::disk('public')->delete($book->cover_image);
            }
            $path = $request->file('cover_image')->store('covers', 'public');
            $bookData['cover_image'] = $path;
        }

        $book->update($bookData);

        return redirect()->route('books.index')->with('success', 'Livro atualizado com sucesso!');
    }

    public function destroy(Book $book)
    {
        $this->authorize('delete', $book);

        if ($book->cover_image) {
            Storage::disk('public')->delete($book->cover_image); 
        }

        $book->delete();

        return redirect()->route('books.index')->with('success', 'Livro excluído com sucesso!');
    }
}
