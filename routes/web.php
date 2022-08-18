<?php

use App\Http\Controllers\AicsBeneficiaryController;
use App\Http\Controllers\AicsClientController;
use App\Http\Controllers\DocumentController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::group(['prefix' => '/aics'], function () {
    Route::resource('clients/{client}/documents', DocumentController::class);
    Route::resource('clients/{client}/beneficiaries', AicsBeneficiaryController::class);
    Route::resource('clients', AicsClientController::class);
});
