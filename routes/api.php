<?php

use App\Http\Controllers\AicsAssistanceController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AicsClientController;
use App\Http\Controllers\AicsBeneficiaryController;
use App\Http\Controllers\AicsTypeController;

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

Route::group(['prefix' => '/aics'], function () {
    Route::resource('assistances', AicsAssistanceController::class);
    Route::get('assistance-types', [AicsTypeController::class, 'index']);
    Route::get('assistance-types/{assistance-type}', [AicsTypeController::class, 'show']);
    Route::get('beneficiaries', [AicsBeneficiaryController::class, 'index']);
    Route::get('clients', [AicsClientController::class, 'index']);
});
