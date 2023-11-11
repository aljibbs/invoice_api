<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
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

Route::middleware('auth:sanctum')->get('/me', function (Request $request) {
    return response()->json([
        'message' => "User Profile",
        'result' => $request->user()
    ])->setStatusCode(Response::HTTP_OK);
});


Route::group(['prefix' => 'auth'], function (){
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);

    Route::middleware('auth:sanctum')->get('logout', [AuthController::class, 'logout']);
});


Route::group(['prefix' => 'transactions', 'middleware' => 'auth:sanctum'], function (){
    Route::get('/', [AuthController::class, 'all']);
});
