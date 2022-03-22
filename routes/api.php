<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\OrderController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

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


// Public Route Orders

Route::get('/users', [UserController::class , 'index']);
Route::get('/users/{id}', [UserController::class , 'show']);
Route::post('/users', [UserController::class , 'store']);
Route::put('/users/{id}', [UserController::class , 'update']);
Route::delete('/users/{id}', [UserController::class, 'destroy']);

// Public Route Orders

Route::get('/orders', [OrderController::class , 'index']);
Route::post('/orders', [OrderController::class , 'store']);
Route::put('/orders/{id}', [OrderController::class , 'update']);
Route::delete('/orders/{id}', [OrderController::class, 'destroy']);

Route::post('/register', [AuthController::class , 'register']);


Route::group(['middleware' => ['auth:sanctum']], function () {
    
    Route::post('/login', [AuthController::class , 'login']);
    Route::get('/orders/{id}', [OrderController::class , 'show']);
                                                                                                                                              
    
    
});

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


