<?php

use App\Http\Controllers\AicsBeneficiaryController;
use App\Http\Controllers\AicsClientController;
use App\Http\Controllers\AicsDocumentController;
use App\Http\Controllers\QRCodesController;
use Illuminate\Support\Facades\Auth;
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
   
    if ( auth()->check()) return redirect('/home'); 
    return view('auth.login');
});

// Route::group(['prefix' => '/aics'], function () {
//     Route::resource('clients/{client}/documents', AicsDocumentController::class);
//     Route::resource('clients/{client}/beneficiaries', AicsBeneficiaryController::class);
//     Route::resource('clients', AicsClientController::class);
// });

// Route::post('login', 'Auth\LoginController@login');
Route::post('login', [App\Http\Controllers\Auth\LoginController::class, 'login']);
Route::post('logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');
Route::get('login', [App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('login');

//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/holiday-crawler', [App\Models\HolidayCrawler::class, 'crawler'])->name('holiday-crawler');

Route::group(['prefix' => '/pdf'], function () {

    Route::group(['prefix' => '/payrolls'], function () {
        Route::get('printv2/{id}', [\App\Http\Controllers\PayrollController::class, 'printv2'])->name("pdf.payroll.printv2");
        Route::get('print_coe/{id}', [\App\Http\Controllers\PayrollController::class, 'print_coe'])->name("pdf.payroll.print_coe");
    });

    Route::group(['prefix' => '/qr'], function () {
     
        Route::get('page/{id}', [\App\Http\Controllers\PayrollClientController::class, 'qr_codes'])->name("pdf.qr_codes");
        Route::post('/search', [\App\Http\Controllers\QRCodesController::class, 'search'])->name("qr_code.search");
         
    });

    Route::group(['prefix' => '/payrolls'], function () {
        Route::get('page/{id}', [\App\Http\Controllers\PayrollClientController::class, 'print_attestation_single'])->name("pdf.attestation");
        Route::get('batch/{id}', [\App\Http\Controllers\PayrollClientController::class, 'print_attestation_multiple'])->name("pdf.attestation.batch");
    });

    Route::group(['prefix' => '/gis'], function () {
        Route::get('printv2/{id}', [\App\Http\Controllers\PayrollClientController::class, 'printv2'])->name("pdf.payroll_client.printv2");
        Route::get('batch/{id}', [\App\Http\Controllers\AicsClientController::class, 'batchGis'])->name("pdf.batch-gis");
    });

    Route::group(['prefix' => '/coe'], function () {
        Route::get('page/{id}', [\App\Http\Controllers\PayrollClientController::class, 'page_coe'])->name("pdf.coe.print_page");
        Route::get('batch/{id}', [\App\Http\Controllers\AicsClientController::class, 'batchCoe'])->name("pdf.coe.batch");
    });

});



//Route::get('/{any}',  [App\Http\Controllers\HomeController::class, 'index'])->where('any', '.*');
Route::get('/{any}', [App\Http\Controllers\HomeController::class, 'index'])->where('any','^(?!js/).*');