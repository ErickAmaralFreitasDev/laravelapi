<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\UserController;
use App\Http\Controllers\Api\V1\InvoiceController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TesteController;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::prefix('v1')->group(function () {
    Route::apiResource('invoices', InvoiceController::class);
    Route::get('/users/{user}', [UserController::class, 'show']);
    Route::get('/users', [UserController::class, 'index']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/teste', [TesteController::class, 'index'])->middleware('ability:teste-index');
        Route::post('/logout', [AuthController::class, 'logout']);
    });

    Route::post('/login', [AuthController::class, 'login']);
});


