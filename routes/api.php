<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::group(['prefix' => 'auth'], function (){
    Route::get('logout', [AuthController::class, 'register']);
    Route::get('logout', [AuthController::class, 'login']);

    Route::middleware('auth:sanctum')->get('logout', [AuthController::class, 'logout']);
});


Route::group(['prefix' => 'transactions', 'middleware' => 'auth:sanctum'], function (){
    Route::get('/', [AuthController::class, 'all']);
});
