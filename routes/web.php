<?php

use App\Http\Controllers\admin\AdminLoginController;
use App\Http\Controllers\admin\CategoryController;
use App\Http\Controllers\admin\HomeController;
use App\Http\Controllers\admin\ProductController;
use App\Http\Controllers\admin\TempImagesController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FrontController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

//main page
Route::get('/', [FrontController::class, 'index'])->name('front.home');

//admin login
Route::get('/admin/login',[AdminLoginController::class,'index'])->name('admin.login');

//Login and Register Routes, localhost/account/login or localhost/account/register
Route::group(['prefix'=>'account'],function(){
    Route::group(['middleware'=>'guest'],function(){
        Route::get('/login',[AuthController::class,'login'])->name('account.login');
        Route::get('/post',[AuthController::class,'authenticate'])->name('account.authenticate');

        Route::get('/register',[AuthController::class,'register'])->name('account.register');
        Route::post('/process-register',[AuthController::class,'processRegister'])->name('account.processRegister');
    });

//logout and profile section
    Route::group(['middleware'=>'auth'],function(){
        Route::get('/profile',[AuthController::class,'profile'])->name('account.profile');
        Route::get('/logout',[AuthController::class,'logout'])->name('account.logout');
    });
});

//admin middleware
Route::group(['prefix'=>'admin'],function(){
Route::group(['middleware'=>'admin.guest'],function(){

Route::get('/login',[AdminLoginController::class,'index'])->name('admin.login');
Route::post('/authenticate',[AdminLoginController::class,'authenticate'])->name('admin.authenticate');
});

Route::group(['middleware'=>'admin.auth'],function(){
Route::get('/dashboard',[HomeController::class,'index'])->name('admin.dashboard');
Route::get('/logout',[HomeController::class,'logout'])->name('admin.logout');

//Category Routes
Route::get('/categories',[CategoryController::class,'index'])->name('categories.index');

Route::get('/categories/create',[CategoryController::class,'create'])->name('categories.create');
Route::post('/categories',[CategoryController::class,'store'])->name('categories.store');


//temp-images.create
Route::post('/upload-temp-image',[TempImagesController::class,'create'])->name('temp-images.create');

Route::get('/getSlug',function(Request $request){
$slug ='';
if(!empty($request->title)){
$slug = Str::slug($request->title);
}
return response()->json([
'status'=>true,
'slug' => $slug

]);
})->name('getSlug');

//Product Routes
 Route::get('/products/create',[ProductController::class,'create'])->name('products.create');
Route::post('/products',[ProductController::class,'store'])->name('products.store');
});

});
