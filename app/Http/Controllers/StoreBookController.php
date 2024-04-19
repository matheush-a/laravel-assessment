<?php

namespace App\Http\Controllers;

use App\Lib\Validator;
use App\Models\StoresBooks;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class StoreBookController extends Controller
{
    protected StoresBooks $storesBooks;
    protected Validator $validator;

    public function __construct(StoresBooks $storesBooks, Validator $validator)
    {
        $this->storesBooks = $storesBooks;
        $this->validator = $validator;
    }
    
    public function index()
    {
        $storesBooks = $this->storesBooks->all();
        return response()->json($storesBooks, Response::HTTP_OK);
    }

    public function store(Request $request)
    {
        $this->validator->validate($request, [
            'book_id' => ['required', 'exists:books,id'],
            'store_id' => ['required', 'exists:stores,id'],
        ]);

        $this->storesBooks->store($request->all());
    }
}
