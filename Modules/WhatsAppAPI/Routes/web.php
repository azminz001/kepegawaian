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

Route::prefix('whatsappapi')->group(function() {
    Route::get('/kirim_ucapan_ultah', 'WhatsAppController@sendBirthdayMessages')->name('whatsappapi.kirim_ucapan_ultah');
    Route::post('/send-birthday-messages', 'WhatsAppController@sendBirthdayMessages')->name('sendBirthdayMessages');
    Route::middleware(['auth'])->group(function () {
        Route::get('/devices', 'DevicesController@index')->name('whatsappapi.device.index');
        Route::put('/devices/update/{id}','DevicesController@update')->name('whatsappapi.device.update');
        Route::get('/log', 'WhatsAppController@log')->name('whatsappapi.log.index');
    });
    Route::post('/send-broadcast', 'WhatsAppController@sendBroadCast')->name('whatsappapi.sendBroadCast');
    Route::post('/send-message', 'WhatsAppController@sendWhatsAppMessage')->name('whatsappapi.sendWhatsAppMessage');

});

