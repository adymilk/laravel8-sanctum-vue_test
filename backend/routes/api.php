<?php

use App\Http\Controllers\API\V1\BoxplotController;
use App\Http\Controllers\API\V1\CapaController;
use App\Http\Controllers\API\V1\IMRController;
use App\Http\Controllers\API\V1\NormTestController;
use App\Http\Controllers\API\V1\OneTController;
use App\Http\Controllers\API\V1\OutlierController;
use App\Http\Controllers\API\V1\PairedController;
use App\Http\Controllers\API\V1\SixpackController;
use App\Http\Controllers\API\V1\TaskController;
use App\Http\Controllers\API\V1\TwoSampleController;
use App\Http\Controllers\API\V1\TwoVariancesController;
use App\Http\Controllers\API\V1\XRChartController;
use App\Http\Controllers\TokenController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

    Route::middleware(['auth:sanctum'])->group(function (){
        Route::apiResource('user', UserController::class);

        Route::post('/imr', [IMRController::class,'index']);
        Route::post('/XRChart', [XRChartController::class,'index']);
        Route::post('/Sixpack', [SixpackController::class,'index']);
        Route::post('/Boxplot', [BoxplotController::class,'index']);
        Route::post('/Capa', [CapaController::class,'index']);
        Route::post('/OneT', [OneTController::class,'index']);
        Route::post('/TwoSample', [TwoSampleController::class,'index']);
        Route::post('/TwoVariances', [TwoVariancesController::class,'index']);
        Route::post('/NormTest', [NormTestController::class,'index']);
        Route::post('/Outlier', [OutlierController::class,'index']);
        Route::post('/Paired', [PairedController::class,'index']);

        Route::any('/getTask/{token}',[TaskController::class,'index']);
        Route::any('/updateTask/{token}',[TaskController::class,'update']);
    });


});



