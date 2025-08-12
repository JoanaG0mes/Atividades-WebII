<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    /**
     * Mostra a página de perfil com o histórico de empréstimos do utilizador logado.
     */
    public function show()
    {
  
        $user = Auth::user();

      
        $borrowings = $user->books()
                           ->orderBy('pivot_borrowed_at', 'desc')
                           ->get();


        return view('profile.show', compact('user', 'borrowings'));
    }
}
