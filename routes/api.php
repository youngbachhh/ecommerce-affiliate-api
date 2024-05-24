<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ImageController;
use Illuminate\Support\Facades\Redis;
use App\Http\Controllers\Api\v1\ProductController;
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
});

Route::group(['prefix' => 'v1', 'namespace' => 'App\Http\Controllers\api\v1'], function () {
    Route::apiResource('get', 'UserController');
});
Route::post('/add-product',[ProductController::class,'store']);
Route::get('/get-product',[ProductController::class,'index']);
Route::get('/show-product/{id}',[ProductController::class,'edit']);
Route::put('/update-product/{id}',[ProductController::class,'update']);
Route::delete('/delete-product/{id}',[ProductController::class,'delete']);
//add to cart
Route::post('/add-to-cart',[ProductController::class,'addToCart']);
