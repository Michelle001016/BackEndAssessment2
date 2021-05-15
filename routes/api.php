<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PassportController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CustomerController;


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
Route::post('login',[PassportController::class,'login']);
Route::post('register',[PassportController::class,'register']);

Route::middleware('auth:api')->group(function (){
    Route::get('products', [ProductController::class, 'index']);
    Route::post('product', [ProductController::class, 'store']);
    Route::put('product/{id}', [ProductController::class, 'update']);
    Route::delete('product/{product}', [ProductController::class, 'destroy']);
    Route::post('/import',[ProductController::class,'import']);
});

Route::middleware('auth:api')->group(function (){
    Route::get('customers', [CustomerController::class, 'index']);
    Route::post('customer', [CustomerController::class, 'store']);
    Route::put('customer/{id}', [CustomerController::class, 'update']);
    Route::delete('customer/{customer}', [CustomerController::class, 'destroy']);
    Route::post('/import',[CustomerController::class,'import']);
    Route::get('/export',[CustomerController::class,'export']);
});
 

