<?php

use App\Http\Controllers\api\AuthApiController;
use App\Http\Controllers\api\ProductApiController;
use App\Http\Controllers\api\CategoryApiController;
use App\Http\Controllers\api\CartApiController;
use App\Http\Controllers\api\ShopApiController;
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
Route::get('/users' ,[AuthApiController::class, 'getUsers']);
Route::post('/authenticate',[AuthApiController::class,'authenticate']);
Route::get('/logout',[AuthApiController::class,'logout']);
Route::post('/register', [AuthApiController::class, 'processRegister']);
Route::post('/change-password', [AuthApiController::class, 'changePassword']);

//* Product api
Route::get('/products',[ProductApiController::class,'index']);
Route::get('/displayProducts', [ProductApiController::class, 'displayProduct']);
Route::get('/products/latest', [ProductApiController::class, 'getLatestProduct']);

//* Categories api
Route::get('/categories',[CategoryApiController::class,'index']);

//* Cart api
Route::get('/cart', [CartApiController::class, 'cart']);
Route::get('/add-to-cart', [CartApiController::class, 'addToCart']);
Route::get('/update-cart', [CartApiController::class, 'updateCart']);
Route::get('/delete-item', [CartApiController::class, 'deleteItem']);
Route::get('/checkout', [CartApiController::class, 'checkout']);
Route::get('/process-checkout', [CartApiController::class, 'processCheckout']);


//* Shop api
Route::get('/shop/{categorySlug?}', [ShopApiController::class, 'index']);
Route::get('/product/{slug}',[ShopApiController::class,'product']);
Route::get('/shop-getProduct/{title}', [ShopApiController::class, 'productDisplay']);

