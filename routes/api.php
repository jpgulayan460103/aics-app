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
    Route::resource('users', \App\Http\Controllers\UserController::class);
    Route::get('assistance-types', [\App\Http\Controllers\AicsTypeController::class, 'index'])->name("api.aics.assistance-types");
    Route::get('assistance-types/{assistance-type}', [\App\Http\Controllers\AicsTypeController::class, 'show']);
    Route::get('beneficiaries', [\App\Http\Controllers\AicsBeneficiaryController::class, 'index']);
    Route::get('clients', [\App\Http\Controllers\AicsClientController::class, 'index'])->name("api.clients");
    Route::post('clients', [\App\Http\Controllers\AicsClientController::class, 'client_upload'])->name("api.client.upload");
    Route::post('clients/{id}', [\App\Http\Controllers\AicsClientController::class, 'update'])->name("api.client.update");
    Route::get('categories', [\App\Http\Controllers\AicsBeneficiaryController::class, 'getCategories'])->name("api.categories");
    Route::get('reports', [\App\Http\Controllers\AicsClientController::class, 'report'])->name("api.report");
    Route::post('export/payroll/{id}', [\App\Http\Controllers\PayrollController::class, 'export'])->name("api.payroll.export");
    Route::post('export/clients', [\App\Http\Controllers\AicsClientController::class, 'export'])->name("api.client.export");
    Route::put('payroll-clients/{id}', [\App\Http\Controllers\PayrollClientController::class, 'update'])->name("api.payroll-clients.update");
});

Route::get('psgc', [\App\Http\Controllers\PsgcController::class, 'index'])->name("api.psgc");
Route::get('psgc/{type}', [\App\Http\Controllers\PsgcController::class, 'show'])->name("api.psgc.show");
Route::get('pdf/{uuid}', [\App\Http\Controllers\AicsAssistanceController::class, 'pdf'])->name("api.pdf.gis");
Route::get('gis/{id}', [\App\Http\Controllers\AicsClientController::class, 'gis'])->name("api.pdf.gis2");

Route::get('dirty_list', [\App\Http\Controllers\DirtyListClientsController::class, 'index'])->name("api.dirty_list.index");


Route::post('payrolls', [\App\Http\Controllers\PayrollController::class, 'create'])->name("api.payroll.create");
Route::get('payrolls', [\App\Http\Controllers\PayrollController::class, 'index'])->name("api.payroll.index");
Route::post('payrolls/{id}', [\App\Http\Controllers\PayrollController::class, 'update'])->name("api.payroll.update");
Route::post('payrolls/del/{id}', [\App\Http\Controllers\PayrollController::class, 'destroy'])->name("api.payrolls.delete");
Route::get('payrolls/{id}', [\App\Http\Controllers\PayrollController::class, 'show'])->name("api.payroll.show");
Route::get('payrolls/print/{id}', [\App\Http\Controllers\PayrollController::class, 'print'])->name("api.payroll.print");
Route::get('payrolls/print_footer/{id}', [\App\Http\Controllers\PayrollController::class, 'print_footer'])->name("api.payroll.print_footer");
Route::get('active_payrolls', [\App\Http\Controllers\PayrollController::class, 'active_payrolls'])->name("api.active_payrolls");

Route::get('uploaded-files', [\App\Http\Controllers\DirtyListController::class, 'index'])->name("api.dirty-list.index");
Route::delete('uploaded-files/{id}', [\App\Http\Controllers\DirtyListController::class, 'destroy'])->name("api.dirty-list.delete");

Route::post('payrolls/{id}/claimed', [\App\Http\Controllers\PayrollClientController::class, 'setAllClaimed'])->name("api.payroll.set_claimed");

Route::get('clients', [\App\Http\Controllers\ServedClientController::class, 'index'])->name("api.served-clients.index");
Route::post('clients', [\App\Http\Controllers\ServedClientController::class, 'store'])->name("api.served-clients.store");

Route::get('logs', [\App\Http\Controllers\AicsClientController::class, 'logs'])->name("clients.logs");
