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

// Route tanpa login (public access)
Route::prefix('rapat')->group(function () {
    Route::get('/display_rapat', 'DisplayRapatController@index')->name('rapat.display_rapat.index');
    Route::get('/display', 'DisplayRapatController@displayGabungan')->name('rapat.display_rapat.displayGabungan');

    Route::get('/kehadiran_rapat/form/{uuid}', 'KehadiranRapatController@form')->name('rapat.kehadiran_rapat.form');
    Route::post('/kehadiran_rapat/store', 'KehadiranRapatController@store')->name('rapat.kehadiran_rapat.store');
});

// Route dengan login (authenticated access)
Route::middleware(['auth'])->group(function () {
    Route::prefix('rapat')->group(function () {
        Route::get('/master_ruangan', 'RuangRapatController@index')->name('rapat.master_ruangan.index');
        Route::post('/master_ruangan/store', 'RuangRapatController@store')->name('rapat.master_ruangan.store');
        Route::delete('/master_ruangan/destroy/{id}', 'RuangRapatController@destroy')->name('rapat.master_ruangan.destroy');
        Route::post('/master_ruangan', 'RuangRapatController@index')->name('rapat.master_ruangan.cari');
        Route::put('/master_ruangan/update/{id}', 'RuangRapatController@update')->name('rapat.master_ruangan.update');

        Route::get('/jadwal_rapat', 'JadwalRapatController@index')->name('rapat.jadwal_rapat.index');
        Route::put('/jadwal_rapat/update/{id}', 'JadwalRapatController@update')->name('rapat.jadwal_rapat.update');
        Route::post('/jadwal_rapat', 'JadwalRapatController@index')->name('rapat.jadwal_rapat.cari');
        Route::delete('/jadwal_rapat/destroy/{id}', 'JadwalRapatController@destroy')->name('rapat.jadwal_rapat.destroy');
        Route::post('/jadwal_rapat/store', 'JadwalRapatController@store')->name('rapat.jadwal_rapat.store');

        Route::get('/kehadiran_rapat', 'KehadiranRapatController@index')->name('rapat.kehadiran_rapat.index');
        Route::delete('/kehadiran_rapat/destroy/{id}', 'KehadiranRapatController@destroy')->name('rapat.kehadiran_rapat.destroy');
        Route::get('/kehadiran_rapat/cetak/{uuid}', 'KehadiranRapatController@cetak')->name('rapat.kehadiran_rapat.cetak');

    });
});
