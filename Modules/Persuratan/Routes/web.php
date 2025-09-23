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
Route::middleware(['auth'])->group(function () {
    Route::prefix('persuratan')->group(function () {

        Route::get('/klasifikasi', 'KlasifikasiController@index')->name('persuratan.klasifikasi.index')->middleware('checkUserLevel:2,4');
        Route::post('/klasifikasi', 'KlasifikasiController@index')->name('persuratan.klasifikasi.cari')->middleware('checkUserLevel:2,4');
        Route::post('/klasifikasi/store', 'KlasifikasiController@store')->name('persuratan.klasifikasi.store')->middleware('checkUserLevel:2,4');
        Route::delete('/klasifikasi/destroy/{id}', 'KlasifikasiController@destroy')->name('persuratan.klasifikasi.destroy')->middleware('checkUserLevel:2,4');
        Route::put('/klasifikasi/update/{id}', 'KlasifikasiController@update')->name('persuratan.klasifikasi.update')->middleware('checkUserLevel:2,4');

        Route::get('/nomor', 'NomorController@index')->name('persuratan.nomor.index')->middleware('checkUserLevel:4');
        Route::post('/nomor', 'NomorController@index')->name('persuratan.nomor.cari')->middleware('checkUserLevel:4');
        Route::post('/nomor/store', 'NomorController@store')->name('persuratan.nomor.store')->middleware('checkUserLevel:4');
        Route::delete('/nomor/destroy/{id}', 'NomorController@destroy')->name('persuratan.nomor.destroy')->middleware('checkUserLevel:4');
        Route::put('/nomor/update/{id}', 'NomorController@update')->name('persuratan.nomor.update')->middleware('checkUserLevel:4');
        Route::put('/nomor/upload/{id}', 'NomorController@upload')->name('persuratan.nomor.upload')->middleware('checkUserLevel:4');

        Route::get('/surat_masuk', 'SuratMasukController@index')->name('persuratan.surat_masuk.index')->middleware('checkUserLevel:2,4');
        Route::post('/surat_masuk', 'SuratMasukController@index')->name('persuratan.surat_masuk.cari')->middleware('checkUserLevel:2,4');
        Route::post('/surat_masuk/store', 'SuratMasukController@store')->name('persuratan.surat_masuk.store')->middleware('checkUserLevel:2,4');
        Route::delete('/surat_masuk/destroy/{id}', 'SuratMasukController@destroy')->name('persuratan.surat_masuk.destroy')->middleware('checkUserLevel:2,4');
        Route::put('/surat_masuk/update/{id}', 'SuratMasukController@update')->name('persuratan.surat_masuk.update')->middleware('checkUserLevel:2,4');

        //Route::get('/perjalanan_dinas', 'PerjalananDinasController@index')->name('perjalanan_dinas.index')->middleware('checkUserLevel:2,4');
        //Route::post('/perjalanan_dinas', 'PerjalananDinasController@index')->name('perjalanan_dinas.cari')->middleware('checkUserLevel:2,4');
        //Route::post('/perjalanan_dinas/store', 'PerjalananDinasController@store')->name('perjalanan_dinas.store')->middleware('checkUserLevel:2,4');
        //Route::delete('/perjalanan_dinas/destroy/{id}', 'PerjalananDinasController@destroy')->name('perjalanan_dinas.destroy')->middleware('checkUserLevel:2,4');
        //Route::put('/perjalanan_dinas/update/{id}', 'PerjalananDinasController@update')->name('perjalanan_dinas.update')->middleware('checkUserLevel:2,4');

        Route::get('/surat_keterangan', 'SuratKeteranganController@index')->name('persuratan.surat_keterangan.index');
        Route::post('/surat_keterangan/store', 'SuratKeteranganController@store')->name('persuratan.surat_keterangan.store');
        Route::delete('/surat_keterangan/destroy/{id}', 'SuratKeteranganController@destroy')->name('persuratan.surat_keterangan.destroy');
        Route::put('/surat_keterangan/update/{id}', 'SuratKeteranganController@update')->name('persuratan.surat_keterangan.update');

        Route::get('/buat_suket', 'BuatSuketController@index')->name('persuratan.buat_suket.index');
        Route::post('/buat_suket/store', 'BuatSuketController@store')->name('persuratan.buat_suket.store');
        Route::delete('/buat_suket/destroy/{id}', 'BuatSuketController@destroy')->name('persuratan.buat_suket.destroy');
        Route::put('/buat_suket/update/{id}', 'BuatSuketController@update')->name('persuratan.buat_suket.update');
        Route::get('/buat_suket/preview/{id}', 'BuatSuketController@preview');
        Route::post('/buat_suket/upload/{id}', 'BuatSuketController@upload')->name('persuratan.buat_suket.upload');
        Route::get('/buat_suket/download/{id}', 'BuatSuketController@download')->name('persuratan.buat_suket.download');
        Route::post('/buat_suket/setujui/{id}', 'BuatSuketController@setujui')->name('persuratan.buat_suket.setujui');
        Route::get('/buat_suket/cetak/{id}', 'BuatSuketController@cetak')->name('buat_suket.cetak');
    });
});
