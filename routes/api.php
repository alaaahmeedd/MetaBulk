<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Public Routes Authantication


Route::post('/register', [AuthController::class , 'register']);

Route::post('/login', [AuthController::class , 'login']);

// Public Route Orders

Route::get('/orders', [OrderController::class , 'index']);
Route::get('/orders/{id}', [OrderController::class , 'show']);
Route::post('/orders', [OrderController::class , 'store']);
Route::put('/orders/{id}', [OrderController::class , 'update']);
Route::get('/orders/search/{name}', [OrderController::class , 'search']);
Route::delete('/orders/{id}', [OrderController::class, 'destroy']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
