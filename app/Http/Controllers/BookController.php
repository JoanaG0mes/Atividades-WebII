<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Author;
use App\Models\Publisher;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{

    public function index()
    {
        $books = Book::with(['author', 'publisher', 'category'])->paginate(10);
        return view('books.index', compact('books'));
    }

    public function createWithId()
    {
        return view('books.create-id');
    }


    public function createWithSelect()
    {
        $authors = Author::all();
        $publishers = Publisher::all();
        $categories = Category::all();
        return view('books.create-select', compact('authors', 'publishers', 'categories'));
    }


    public function storeWithId(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'publisher_id' => 'required|exists:publishers,id',
            'author_id' => 'required|exists:authors,id',
            'category_id' => 'required|exists:categories,id',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $book = new Book($request->all());

        if ($request->hasFile('cover_image')) {

            $path = $request->file('cover_image')->store('covers', 'public');
            $book->cover_image = $path;
        }

        $book->save();

        return redirect()->route('books.index')->with('success', 'Livro adicionado com sucesso!');
    }

  
    public function storeWithSelect(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'publisher_id' => 'required|exists:publishers,id',
            'author_id' => 'required|exists:authors,id',
            'category_id' => 'required|exists:categories,id',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $book = new Book($request->all());

        if ($request->hasFile('cover_image')) {
            $path = $request->file('cover_image')->store('covers', 'public');
            $book->cover_image = $path;
        }

        $book->save();

        return redirect()->route('books.index')->with('success', 'Livro adicionado com sucesso!');
    }

    public function show(Book $book)
    {
        $users = User::all();
        return view('books.show', compact('book', 'users'));
    }

    public function edit(Book $book)
    {
        $authors = Author::all();
        $publishers = Publisher::all();
        $categories = Category::all();
        return view('books.edit', compact('book', 'authors', 'publishers', 'categories'));
    }


    public function update(Request $request, Book $book)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'publisher_id' => 'required|exists:publishers,id',
            'author_id' => 'required|exists:authors,id',
            'category_id' => 'required|exists:categories,id',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('cover_image')) {
            if ($book->cover_image) {
                Storage::disk('public')->delete($book->cover_image); // Usar disk('public') para exclusão
            }
            $path = $request->file('cover_image')->store('covers', 'public');
            $book->cover_image = $path;
        } elseif ($request->input('remove_cover_image')) {
            if ($book->cover_image) {
                Storage::disk('public')->delete($book->cover_image);
            }
            $book->cover_image = null;
        }

        $book->update($request->except('cover_image'));

        return redirect()->route('books.index')->with('success', 'Livro atualizado com sucesso!');
    }


    public function destroy(Book $book)
    {
        if ($book->cover_image) {
            Storage::disk('public')->delete($book->cover_image); 
        }

        $book->delete();

        return redirect()->route('books.index')->with('success', 'Livro excluído com sucesso!');
    }


    public function borrow(Request $request, Book $book)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $book->users()->attach($request->user_id, ['borrowed_at' => now()]);

        return redirect()->back()->with('success', 'Livro emprestado com sucesso!');
    }
}
