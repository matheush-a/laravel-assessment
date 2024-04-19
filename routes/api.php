<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\StoreController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::group(['prefix' => 'books'], function() {
    Route::get('/', [BookController::class, 'index']);
    Route::delete('/{id}', [BookController::class, 'destroy']);
    Route::post('/', [BookController::class, 'store']);
    Route::put('/{id}', [BookController::class, 'update']);
    Route::get('/{id}', [BookController::class, 'show']);
});

Route::group(['prefix' => 'stores'], function() {
    Route::get('/', [StoreController::class, 'index']);
    Route::delete('/{id}', [StoreController::class, 'destroy']);
    Route::post('/', [StoreController::class, 'store']);
    Route::put('/{id}', [StoreController::class, 'update']);
    Route::get('/{id}', [StoreController::class, 'show']);
});
