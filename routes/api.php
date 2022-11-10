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
    Route::resource('assistances', \App\Http\Controllers\AicsAssistanceController::class);
    Route::get('assistance-types', [\App\Http\Controllers\AicsTypeController::class, 'index'])->name("api.aics.assistance-types");
    Route::get('assistance-types/{assistance-type}', [\App\Http\Controllers\AicsTypeController::class, 'show']);
    Route::get('beneficiaries', [\App\Http\Controllers\AicsBeneficiaryController::class, 'index']);
    Route::get('clients', [\App\Http\Controllers\AicsClientController::class, 'index']);
});

Route::get('psgc', [\App\Http\Controllers\PsgcController::class, 'index'])->name("api.psgc");
Route::get('psgc/{type}', [\App\Http\Controllers\PsgcController::class, 'show'])->name("api.psgc.show");
Route::get('pdf/{uuid}', [\App\Http\Controllers\AicsAssistanceController::class, 'pdf'])->name("api.pdf.gis");
Route::get('available', [\App\Http\Controllers\AicsAppointmentController::class, 'available'])->name("api.aics.appointment.available");

