<?php

use App\Http\Controllers\Api\v1\AuthController;
use App\Http\Controllers\Api\v1\LoanApplicationController;
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

Route::group(['prefix' => 'v1', 'namespace' => 'Api/v1'], function () {

    Route::post('/auth/login', [AuthController::class, 'login']);

    Route::group(['middleware' => 'auth:sanctum'], function () {
        Route::post('/auth/logout', [AuthController::class, 'logout']);
        Route::post('/loan-application', [LoanApplicationController::class, 'postLoanApplication']);
        Route::post('/change-application-status', [LoanApplicationController::class, 'changeApplicationStatus']);
        Route::post('/change-weekly-payment', [LoanApplicationController::class, 'changeWeeklyPayment']);
    });
});
