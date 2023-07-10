<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\{PageController,ProductController};
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('page',[PageController::class,'getPage']);
Route::get('banner/{id}',[PageController::class,'getBanner']);
Route::get('blog/category',[PageController::class,'getBlogCategory']);
Route::get('blog/{page}',[PageController::class,'getBlog']);

Route::get('category',[ProductController::class,'getCategory']);
Route::get('products/{category_id}',[ProductController::class,'getProducts']);
Route::get('product/{id}',[ProductController::class,'getProduct']);