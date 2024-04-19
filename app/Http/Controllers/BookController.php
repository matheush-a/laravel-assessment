<?php

namespace App\Http\Controllers;

use App\Lib\Validator;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BookController extends Controller
{
    protected Book $book;
    protected Validator $validator;

    public function __construct(Book $book, Validator $validator)
    {
        $this->book = $book;
        $this->validator = $validator;
    }

    public function destroy($id)
    {
        $book = $this->book->find($id);

        if (!$book) {
            return response()->json('Book not found!', Response::HTTP_BAD_REQUEST);
        }

        $this->book->destroy($id);
        return response()->json('Book deleted successfully.', Response::HTTP_NO_CONTENT);
    }
    
    public function index()
    {
        $books = $this->book->all();
        return response()->json($books, Response::HTTP_OK);
    }

    public function show(int $id)
    {
        $book = $this->book->find($id);

        if (!$book) {
            return response()->json('Book not found!', Response::HTTP_BAD_REQUEST);
        }

        return response()->json($book, Response::HTTP_OK);
    }

    public function store(Request $request)
    {
        $this->validator->validate($request, [
            'name' => ['required'],
            'isbn' => ['required', 'integer', 'unique:books'],
            'value' => ['required', 'numeric'],
        ]);

        $this->book->store($request->all());
    }

    public function update(int $id, Request $request) {
        $this->validator->validate($request, [
            'isbn' => ['integer', 'unique:books'],
            'value' => ['numeric'],
        ]);

        $book = $this->book->find($id);

        if (!$book) {
            return response()->json('Book not found!', Response::HTTP_BAD_REQUEST);
        }

        $this->book->updateBook($book, $request->all());
        return response()->json('Book updated successfully.', Response::HTTP_NO_CONTENT);
    }
}
