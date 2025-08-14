<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BookController extends Controller
{
 
    public function index()
    {

        $books = Book::with(['author', 'category', 'publisher'])->latest()->paginate(15);
        return response()->json($books);
    }

   
    public function store(Request $request)
    {
  
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'author_id' => 'required|exists:authors,id',
            'category_id' => 'required|exists:categories,id',
            'publisher_id' => 'required|exists:publishers,id',
            'published_year' => 'required|integer|min:1000|max:' . date('Y'),
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $book = Book::create($request->all());

        return response()->json($book, 201);
    }

  
    public function show(Book $book)
    {

        $book->load(['author', 'category', 'publisher']);
        return response()->json($book);
    }

 
    public function update(Request $request, Book $book)
    {
    
        $validator = Validator::make($request->all(), [
            'title' => 'sometimes|required|string|max:255',
            'author_id' => 'sometimes|required|exists:authors,id',
            'category_id' => 'sometimes|required|exists:categories,id',
            'publisher_id' => 'sometimes|required|exists:publishers,id',
            'published_year' => 'sometimes|required|integer|min:1000|max:' . date('Y'),
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $book->update($request->all());
        return response()->json($book);
    }
    public function destroy(Book $book)
    {
        $book->delete();
        return response()->json(null, 204);
    }
}
