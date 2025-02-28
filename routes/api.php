<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\MessageController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StockController;
use App\Http\Controllers\SupplierBlController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function() {
Route::post('logout', [AuthController::class, 'logout']);

});

Route::apiResource('stocks', StockController::class);
Route::apiResource('users', UserController::class);
Route::apiResource('messages', MessageController::class);

Route::apiResource('clients', ClientController::class);
Route::apiResource('employers', UserController::class);
Route::apiResource('invoices', InvoiceController::class);
Route::apiResource('tasks', TaskController::class);
Route::apiResource('suppliers', SupplierController::class);
Route::apiResource('supplierbls', SupplierBlController::class);


Route::post('register',[AuthController::class,'register']);










/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
|
|Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
|
|
*/


