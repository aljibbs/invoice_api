<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TransactionsController;
use App\Models\Role;
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

Route::get('roles', function() {
    return Role::all();
});


Route::group(['prefix' => 'auth'], function (){
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);

    Route::middleware('auth:sanctum')->get('logout', [AuthController::class, 'logout']);
});

Route::middleware(['auth:sanctum', 'roleCheck:admin,sales'])->group(function (){
    Route::get('/me', function (Request $request) {
        return response()->json([
            'message' => "User Profile",
            'result' => $request->user()
        ])->setStatusCode(Response::HTTP_OK);
    });

    Route::group(['prefix' => 'transactions'], function (){
        Route::get('/{invoiceNumber}', [TransactionsController::class, 'getInvoice']);
        Route::post('/', [TransactionsController::class, 'save']);
        Route::get('/', [TransactionsController::class, 'all']);
    });

    Route::group(['prefix' => 'products'], function (){
        Route::get('/{id}', [ProductController::class, 'getProduct']);
        Route::get('/', [ProductController::class, 'all']);

        Route::middleware('roleCheck:admin')->group(function(){
            Route::put('/{id}', [ProductController::class, 'update']);
            Route::post('/{id}/add_stock', [ProductController::class, 'addStock']);
            Route::post('/', [ProductController::class, 'save']);
        });
    });

});




