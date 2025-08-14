<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class FineController extends Controller
{

    public function index()
    {
        $this->authorize('gerenciar multas');

        $usersWithDebit = User::where('debit', '>', 0)->paginate(10);

        return view('admin.fines.index', compact('usersWithDebit'));
    }


    public function clearDebit(User $user)
    {
        $this->authorize('gerenciar multas');

        $user->update(['debit' => 0]);

        return redirect()->back()->with('success', 'Débito do utilizador ' . $user->name . ' foi zerado com sucesso.');
    }
}
