<?php

use App\Http\Controllers\API\V1\AuthController;
use App\Http\Controllers\API\V1\IMRController;
use App\Http\Controllers\API\V1\TokenController;
use App\Http\Controllers\API\V1\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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


Route::namespace('App\\Http\\Controllers\\API\V1')->group(function (){
    Route::prefix('tokens')->group(function () {
        Route::post('/create', [TokenController::class,'create']);
    });

    Route::middleware('auth:sanctum')->group(function (){
        Route::get('/users/{id}', [UserController::class,'get']);
        Route::post('/imr', [IMRController::class,'index']);
    });

});



