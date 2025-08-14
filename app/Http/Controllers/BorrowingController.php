<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Borrowing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class BorrowingController extends Controller
{

    public function store(Request $request, Book $book)
    {
   
        $this->authorize('realizar emprestimos');

        $user = Auth::user();

        if ($user->debit > 0) {
            return redirect()->back()->with('error', 'Você possui débitos pendentes (R$ ' . number_format($user->debit, 2, ',', '.') . ') e não pode realizar novos empréstimos.');
        }

        $activeBorrowsCount = Borrowing::where('user_id', $user->id)->whereNull('returned_at')->count();
        if ($activeBorrowsCount >= 5) {
            return redirect()->back()->with('error', 'Você atingiu o limite de 5 livros emprestados simultaneamente.');
        }

    
        if (!$book->is_available) {
            return redirect()->back()->with('error', 'Este livro não está disponível para empréstimo no momento.');
        }

  
        Borrowing::create([
            'user_id' => $user->id,
            'book_id' => $book->id,
            'borrowed_at' => now(),
            'due_back_at' => now()->addDays(15), 
        ]);


        $book->update(['is_available' => false]);

        return redirect()->route('profile.show')->with('success', 'Empréstimo registado com sucesso! Você tem 15 dias para devolver o livro.');
    }


    public function returnBook(Borrowing $borrowing)
    {

        if (Auth::id() !== $borrowing->user_id) {
            abort(403, 'Ação não autorizada.');
        }

        $borrowedDate = Carbon::parse($borrowing->borrowed_at);
        $returnDate = Carbon::now();
        $daysBorrowed = $returnDate->diffInDays($borrowedDate);

        $fineAmount = 0;
        $lateDays = 0;

        if ($daysBorrowed > 15) {
            $lateDays = $daysBorrowed - 15;
            $fineAmount = $lateDays * 0.50;

            $user = $borrowing->user;
            $user->debit += $fineAmount;
            $user->save();
        }

        $borrowing->update(['returned_at' => $returnDate]);

        $borrowing->book->update(['is_available' => true]);
        $message = 'Devolução registada com sucesso.';
        if ($fineAmount > 0) {
            $message .= ' Multa de R$ ' . number_format($fineAmount, 2, ',', '.') . ' foi adicionada à sua conta por ' . $lateDays . ' dia(s) de atraso.';
        }

        return redirect()->back()->with('success', $message);
    }
}
