<?php
namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Book;
use App\Models\Publisher;
use App\Models\Author;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    // Formulário com input de ID
    public function createWithId()
    {
        return view('books.create-id');
    }
public function store(Request $request, Book $book)
{
    $request->validate([
        'user_id' => 'required|exists:users,id',
    ]);

    Borrowing::create([
        'user_id' => $request->user_id,
        'book_id' => $book->id,
        'borrowed_at' => now(),
    ]);

    return redirect()->route('books.show', $book)->with('success', 'Empréstimo registrado com sucesso.');
}
    // Salvar livro com input de ID
    public function storeWithId(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'publisher_id' => 'required|exists:publishers,id',
            'author_id' => 'required|exists:authors,id',
            'category_id' => 'required|exists:categories,id',
        ]);

        Book::create($request->all());

        return redirect()->route('books.index')->with('success', 'Livro criado com sucesso.');
    }

    // Formulário com input select
    public function createWithSelect()
    {
        $publishers = Publisher::all();
        $authors = Author::all();
        $categories = Category::all();

        return view('books.create-select', compact('publishers', 'authors', 'categories'));
    }

    // Salvar livro com input select
    public function storeWithSelect(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'publisher_id' => 'required|exists:publishers,id',
            'author_id' => 'required|exists:authors,id',
            'category_id' => 'required|exists:categories,id',
        ]);

        Book::create($request->all());

        return redirect()->route('books.index')->with('success', 'Livro criado com sucesso.');
    }
    public function edit(Book $book)
{
    $publishers = Publisher::all();
    $authors = Author::all();
    $categories = Category::all();

    return view('books.edit', compact('book', 'publishers', 'authors', 'categories'));
}
public function update(Request $request, Book $book)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'publisher_id' => 'required|exists:publishers,id',
        'author_id' => 'required|exists:authors,id',
        'category_id' => 'required|exists:categories,id',
    ]);

    $book->update($request->all());

    return redirect()->route('books.index')->with('success', 'Livro atualizado com sucesso.');
}
public function show(Book $book)
{
    // Carregando autor, editora e categoria do livro com eager loading
    $book->load(['author', 'publisher', 'category']);

    // Carregar todos os usuários para o formulário de empréstimo
    $users = User::all();

    return view('books.show', compact('book','users'));
}
public function index()
{
    // Carregar os livros com autores usando eager loading e paginação
    $books = Book::with('author')->paginate(20);

    return view('books.index', compact('books'));
}
    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()->route('categories.index')->with('success', 'Categoria excluída com sucesso.');
    }
}