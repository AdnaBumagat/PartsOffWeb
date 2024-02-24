<?php

use App\Http\Controllers\api\AuthenticationController;
use App\Http\Controllers\api\ProductController;
use App\Http\Controllers\api\CategoryController;
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

//*
Route::get('/admin/login',[AuthenticationController::class,'login']);

//* Product api
Route::get('/products',[ProductController::class,'index']);
Route::post('/products/store',[ProductController::class,'store']);
Route::put('products/update/{productID}', [ProductController::class, 'update']);
Route::delete('products/destroy/{productID}', [ProductController::class, 'destroy']);

//* Categories api
Route::get('/categories',[CategoryController::class,'index']);
Route::post('/categories/store',[CategoryController::class,'store']);
Route::put('/categories/update/{categoryID}',[CategoryController::class,'update']);
Route::delete('/categories/destroy/{categoryID}',[CategoryController::class,'destroy']);
