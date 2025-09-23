<?php

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

Route::prefix('simrs_support')->group(function() {
    Route::get('/', 'KuotaPoliController@index');
    Route::get('/suratsehat_list', 'NotifikasiTTEController@suratsehat_list')->name('simrs_support.suratsehat_list')->middleware(['auth']);
    Route::get('/send_wa/{ID}', 'NotifikasiTTEController@send_wa')->name('simrs_support.send_wa');
    Route::get('/send_all_wa', 'NotifikasiTTEController@send_all_wa')->name('simrs_support.send_all_wa');
});
