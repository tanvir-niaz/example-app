<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;

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

Route::get('/', function () {
    return view('home');
});


Route::post("/register",[UserController::class,'register']);

Route::post("/signin",[UserController::class,'signin']);

Route::post("/product",[ProductController::class,'createProduct']);

Route::get("/product",[ProductController::class,'getProducts']);

Route::get("/product/{id}",[ProductController::class,'getProductById']);

Route::patch("/product/{product_id}", [ProductController::class, 'updateProductById']);
