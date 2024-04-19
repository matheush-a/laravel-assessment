<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\StoreBookController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::group(['prefix' => ''], function() {
    Route::post('/login', [AuthController::class, 'login']);
});

Route::group(['middleware' => 'auth:sanctum'], function() {
    Route::group(['prefix' => 'users'], function() {
        Route::delete('/logout', [AuthController::class, 'logout']);
    });
});


Route::group(['prefix' => 'books'], function() {
    Route::get('/', [BookController::class, 'index']);
    Route::get('/{id}', [BookController::class, 'show']);
    Route::group(['middleware' => 'auth:sanctum'], function() {
        Route::delete('/{id}', [BookController::class, 'destroy']);
        Route::post('/', [BookController::class, 'store']);
        Route::put('/{id}', [BookController::class, 'update']);
    });
});

Route::group(['prefix' => 'stores'], function() {
    Route::get('/', [StoreController::class, 'index']);
    Route::get('/{id}', [StoreController::class, 'show']);
    Route::group(['middleware' => 'auth:sanctum'], function()  {
        Route::delete('/{id}', [StoreController::class, 'destroy']);
        Route::post('/', [StoreController::class, 'store']);
        Route::put('/{id}', [StoreController::class, 'update']);
    });
});

Route::group(['prefix' => 'stores-books'], function() {
    Route::get('/', [StoreBookController::class, 'index']);
    Route::get('/{bookId}/{storeId}', [StoreBookController::class, 'show']);
    Route::group(['middleware' => 'auth:sanctum'], function()  {
        Route::delete('/{bookId}/{storeId}', [StoreBookController::class, 'destroy']);
        Route::post('/', [StoreBookController::class, 'store']);
        Route::put('/{bookId}/{storeId}', [StoreBookController::class, 'update']);
    });
});
