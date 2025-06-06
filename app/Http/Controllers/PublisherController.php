<?php

namespace App\Http\Controllers;
use App\Models\Publisher;
use Illuminate\Http\Request;

class PublisherController extends Controller
{
    // Exibe uma lista de publishers
    public function index()
    {
        $publishers = Publisher::all();
        return view('publishers.index', compact('publishers'));
    }

    // Mostra o formulário para criar um novo publisher
    public function create()
    {
        return view('publishers.create');
    }

    // Armazena um novo publisher no banco de dados
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:publishers|max:255',
        ]);

        Publisher::create($request->all());

        return redirect()->route('publishers.index')->with('success', 'Editora criada com sucesso.');
    }

    // Exibe um publisher específico
    public function show(Publisher $publisher)
    {
        return view('publishers.show', compact('publisher'));
    }

    // Mostra o formulário para editar um publisher existente
    public function edit(Publisher $publisher)
    {
        return view('publishers.edit', compact('publisher'));
    }

    // Atualiza um publisher no banco de dados
    public function update(Request $request, Publisher $publisher)
    {
        $request->validate([
            'name' => 'required|string|unique:publishers,name,' . $publisher->id . '|max:255',
        ]);

        $publisher->update($request->all());

        return redirect()->route('publishers.index')->with('success', 'Editora atualizada com sucesso.');
    }

    // Remove um publisher do banco de dados
    public function destroy(Publisher $publisher)
    {
        $publisher->delete();

        return redirect()->route('publishers.index')->with('success', 'Editora excluída com sucesso.');
    }
}