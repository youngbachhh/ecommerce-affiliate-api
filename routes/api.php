<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Api\v1\UserController;
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




Route::group(['prefix' => 'v1', 'namespace' => 'App\Http\Controllers\api\v1'], function () {
    Route::group([
        'middleware' => 'api',
        'prefix' => 'auth'
    ], function ($router) {
        Route::post('login', [AuthController::class, 'login']);
        Route::post('logout', [AuthController::class, 'logout']);
        Route::post('refresh', [AuthController::class, 'refresh']);
        Route::post('me', [AuthController::class, 'me']);
    });

    Route::group([
        'middleware' => ['api','jwt.auth'],
        'prefix' => 'user'
    ], function ($router) {
        Route::get('/', [UserController::class, 'index']);
        Route::get('/{id}', [UserController::class, 'show']);
        Route::post('/', [UserController::class, 'store']);
        Route::put('/{id}', [UserController::class, 'update']);
        Route::delete('/{id}', [UserController::class, 'destroy']);
    });

    Route::group(['prefix' => 'products'], function ($router) {
        Route::get('/', [ProductController::class, 'index']);
        Route::post('/', [ProductController::class, 'store']);
        Route::get('/{id}', [ProductController::class, 'edit']);
        Route::put('/{id}', [ProductController::class, 'update']);
        Route::delete('/{id}', [ProductController::class, 'destroy']);
    });

    Route::group(['prefix' => 'cart'], function ($router) {
        Route::post('/', [ProductController::class, 'addToCart']);
        Route::get('/', [ProductController::class, 'getToCart']);
        Route::delete('/{id}', [ProductController::class, 'delToCart']);
        Route::put('/{id}', [ProductController::class, 'updateToCart']);
    });
});
