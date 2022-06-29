<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ArchiveController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FileController;


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

Route::get('/orders/{id}', [OrderController::class , 'show']);
Route::post('/orders', [OrderController::class , 'store']);
// Route::put('/orders/{id}', [OrderController::class , 'update']);
Route::delete('/orders/{id}', [OrderController::class, 'destroy']);


// Public Route Orders

Route::get('/archives/{id}', [ArchiveController::class , 'index']);
Route::delete('/archives/{id}', [ArchiveController::class, 'destroy']);
Route::put('/archives/{id}', [ArchiveController::class , 'update']);
Route::get('/messToday', [ArchiveController::class , 'messageToday']);



// Auth route with token

Route::post('/login', [AuthController::class , 'login']);
Route::post('/register', [AuthController::class , 'register']);

// route upload file

Route::post('/file', [FileController::class , 'upload']);



Route::group(['middleware' => ['auth:sanctum']], function () {
    
    Route::get('/orders', [OrderController::class , 'testget']);
    Route::post('/archives', [ArchiveController::class , 'store']);
    Route::put('/orders/{number}', [OrderController::class ,'sub_message']);
    
    
});

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


