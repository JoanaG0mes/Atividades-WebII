<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Borrowing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BorrowingController extends Controller
{

    public function store(Request $request, Book $book)
    {
     
        $this->authorize('realizar emprestimos');

        $user = Auth::user();


        $activeBorrowsCount = Borrowing::where('user_id', $user->id)
                                       ->whereNull('returned_at')
                                       ->count();


        if ($activeBorrowsCount >= 5) {

            return redirect()->back()->with('error', 'Você atingiu o limite de 5 livros emprestados simultaneamente.');
        }

        $isBookAvailable = !Borrowing::where('book_id', $book->id)
                                     ->whereNull('returned_at')
                                     ->exists();

        if (!$isBookAvailable) {
            return redirect()->back()->with('error', 'Este livro já está emprestado e não pode ser pego no momento.');
        }


        Borrowing::create([
            'user_id' => $user->id,
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
