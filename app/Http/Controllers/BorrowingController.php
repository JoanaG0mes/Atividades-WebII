<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Borrowing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Importa o facade de Autenticação

class BorrowingController extends Controller
{
    /**
     * Regista um novo empréstimo.
     */
    public function store(Request $request, Book $book)
    {

        $this->authorize('realizar emprestimos');


        $existingBorrowing = Borrowing::where('book_id', $book->id)
                                      ->whereNull('returned_at')
                                      ->first();


        if ($existingBorrowing) {
            return redirect()->back()->with('error', 'Este livro já está emprestado e não pode ser pego no momento.');
        }


        Borrowing::create([
            'user_id' => Auth::id(), 
            'book_id' => $book->id,
            'borrowed_at' => now(),
        ]);

        return redirect()->route('books.show', $book)->with('success', 'Empréstimo registado com sucesso!');
    }

    public function returnBook(Borrowing $borrowing)
    {
        $borrowing->update(['returned_at' => now()]);
        return redirect()->back()->with('success', 'Devolução registada com sucesso.');
    }
}
