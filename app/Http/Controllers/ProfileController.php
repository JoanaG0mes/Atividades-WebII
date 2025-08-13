<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        $borrowings = $user->books()->orderBy('pivot_borrowed_at', 'desc')->get();
        return view('profile.show', compact('user', 'borrowings'));
    }
}