<?php

namespace App\Http\Controllers;

use App\Lib\Validator;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class StoreController extends Controller
{
    protected Store $store;
    protected Validator $validator;

    public function __construct(Store $store, Validator $validator)
    {
        $this->store = $store;
        $this->validator = $validator;
    }

    public function destroy($id)
    {
        $store = $this->store->find($id);

        if (!$store) {
            return response()->json('Store not found!', Response::HTTP_BAD_REQUEST);
        }

        $this->store->destroy($id);
        return response()->json('Store deleted successfully.', Response::HTTP_NO_CONTENT);
    }
    
    public function index()
    {
        $stores = $this->store->all();
        return response()->json($stores, Response::HTTP_OK);
    }

    public function show(int $id)
    {
        $store = $this->store->find($id);

        if (!$store) {
            return response()->json('Store not found!', Response::HTTP_BAD_REQUEST);
        }

        return response()->json($store, Response::HTTP_OK);
    }

    public function store(Request $request)
    {
        $this->validator->validate($request, [
            'name' => ['required'],
            'isbn' => ['integer', 'unique:stores'],
            'value' => ['numeric'],
        ]);

        $this->store->store($request->all());
    }

    public function update(int $id, Request $request) {
        $this->validator->validate($request, [
            'isbn' => ['integer', 'unique:stores'],
            'value' => ['numeric'],
        ]);

        $store = $this->store->find($id);

        if (!$store) {
            return response()->json('Store not found!', Response::HTTP_BAD_REQUEST);
        }

        $this->store->updateStore($store, $request->all());
        return response()->json('Store updated successfully.', Response::HTTP_NO_CONTENT);
    }
}
