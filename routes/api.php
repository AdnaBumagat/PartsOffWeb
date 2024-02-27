<?php

use App\Http\Controllers\api\AuthApiController;
use App\Http\Controllers\api\ProductApiController;
use App\Http\Controllers\api\CategoryApiController;
use App\Http\Controllers\api\CartApiController;
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

//* Authentication
Route::get('/admin/login',[AuthApiController::class,'login']);

//* Product api
Route::get('/products',[ProductApiController::class,'index']);

//* Categories api
Route::get('/categories',[CategoryApiController::class,'index']);

//* Cart api
Route::get('/cart', [CartApiController::class, 'cart']);
Route::get('/add-to-cart', [CartApiController::class, 'addToCart']);
Route::get('/update-cart', [CartApiController::class, 'updateCart']);
Route::get('/delete-item', [CartApiController::class, 'deleteItem']);
