<?php
use Illuminate\Support\Facades\Redirect;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
ANDIN
RINA
Kholil
MELLIANA
rizal
ANWAR SAIFUDIN
NAUUL
trisno
Nau'ul 
ZULFA
lia

*/



Route::prefix('karir')->group(function() {
    Route::middleware(['auth'])->group(function () {
        Route::get('/data_sanggahan', 'KarirPesertaAllController@data_sanggahan')->name('karir.data_sanggah');
        Route::post('/data_sanggahan', 'KarirPesertaAllController@data_sanggahan')->name('karir.filter_formasi');
        Route::get('/data_sanggahan/edit/{id}', 'KarirPesertaAllController@edit')->name('karir.edit');
        Route::put('/tanggapi_sanggahan/{id}','KarirPesertaAllController@tanggapi_sanggahan')->name('karir.tanggapi_sanggahan');
    });
    Route::get('/', function(){
        return Redirect::to('https://rsud.brebeskab.go.id/karir/');
    })->name('karir.index');
    Route::get('/sanggah', function(){
        return Redirect::to('https://rsud.brebeskab.go.id/karir/');
    })->name('karir.index')->name('karir.sanggah');
    // Route::post('/', 'KarirPesertaController@index')->name('karir.filter');
    // Route::post('/sanggah', 'KarirPesertaAllController@index')->name('karir.filter_sanggah');
    // Route::get('/verify/{nik}', 'KarirPesertaController@verify')->name('karir.verify');
    // Route::put('/update/{id}','KarirPesertaController@update')->name('karir.update');
    // Route::put('/update_sanggah/{id}','KarirPesertaAllController@sanggah')->name('karir.sanggah');

    
});

Route::prefix('sindikat')->group(function() {
    Route::get('/', 'SindikatController@index')->name('sindikat.landing');
    Route::get('/profil_diklat', 'LandingController@profil_diklat')->name('landing.profil_diklat');
    Route::get('/profil_litbang', 'LandingController@profil_litbang')->name('landing.profil_litbang');
    Route::get('/struktur_organisasi', 'LandingController@so')->name('landing.so');
    Route::get('/login', 'AuthController@showLoginForm')->name('login.sindikat');
    Route::get('/register', 'AuthController@register')->name('register');
    Route::get('/clinical_instructure', 'LandingController@clinical_instructure')->name('landing.clinical_instructure');

    Route::get('/kategori', 'KategoriController@index')->middleware('checkUserLevel:1,2,3,5,6')->name('sindikat.kategori.index');
    Route::get('/kategori/show/{slug}', 'KategoriController@show')->middleware('auth')->name('sindikat.kategori.show');
    Route::post('/kategori/store', 'KategoriController@store')->middleware('auth')->name('sindikat.kategori.store');
    Route::delete('/kategori/destroy/{id}', 'KategoriController@destroy')->name('sindikat.kategori.destroy');
    Route::put('/kategori/update/{id}','KategoriController@update')->name('sindikat.kategori.update');
    //select2 Option
    Route::get('/categories', 'KategoriController@getUnits');


    Route::get('/instruktur', 'InstrukturKlinikController@index')->middleware('auth','checkUserLevel:1,2,3,5,6')->name('sindikat.pegawai.index');
    Route::get('/instruktur/show/{id}', 'InstrukturKlinikController@show')->name('sindikat.pegawai.show');
    Route::post('/instruktur/store', 'InstrukturKlinikController@store')->name('sindikat.pegawai.store');
    Route::get('/instruktur/profil/{id}', 'InstrukturKlinikController@profil')->name('sindikat.pegawai.profil');

    Route::get('/institusi', 'InstitusiController@index')->middleware('auth','checkUserLevel:1,2,3,5,6')->name('sindikat.institusi.index');
    Route::post('/institusi/cari', 'InstitusiController@index')->middleware('auth')->name('sindikat.institusi.cari');
    Route::get('/institusi/pengguna', 'InstitusiController@pengguna')->middleware('auth')->name('sindikat.institusi.pengguna');
    Route::post('/institusi/pengguna/cari', 'InstitusiController@pengguna')->middleware('auth')->name('sindikat.institusi.pengguna.cari');
    Route::get('/institusi/show/{id}', 'InstitusiController@show')->middleware('auth')->name('sindikat.institusi.show');
    Route::post('/institusi/store', 'InstitusiController@store')->middleware('auth')->name('sindikat.institusi.store');
    Route::delete('/institusi/destroy/{id}', 'InstitusiController@destroy')->middleware('auth')->name('sindikat.institusi.destroy');
    Route::put('/institusi/update/{id}','InstitusiController@update')->middleware('auth')->name('sindikat.institusi.update');
    Route::put('/institusi/ganti_logo/{id}','InstitusiController@ganti_logo')->middleware('auth')->name('sindikat.institusi.ganti_logo');

    //select2 Option
    Route::get('/institusis', 'InstitusiController@getUnits');

    Route::get('/institusi/jurusan/{id}', 'InstitusiController@lihat_jurusan')->name('sindikat.institusi.jurusan');
    Route::get('/institusi/peserta_didik/{id}', 'InstitusiController@lihat_peserta_didik')->name('sindikat.institusi.peserta_didik');
    Route::get('/institusi/riwayat_permohonan_magang/{id}', 'InstitusiController@lihat_riwayat_permohonan_magang')->name('sindikat.institusi.permohonan_magang');
    Route::get('/institusi/riwayat_permohonan_studibanding/{id}', 'InstitusiController@lihat_permohonan_studibanding')->name('sindikat.institusi.permohonan_studibanding');

    Route::get('/jenjang', 'JenjangController@index')->middleware('auth')->name('sindikat.jenjang.index');
    Route::post('/jenjang/store', 'JenjangController@store')->middleware('auth')->name('sindikat.jenjang.store');
    Route::delete('/jenjang/destroy/{id}', 'JenjangController@destroy')->middleware('auth')->name('sindikat.jenjang.destroy');
    Route::put('/jenjang/update/{id}','JenjangController@update')->middleware('auth')->name('sindikat.jenjang.update');
    //select2 Option
    Route::get('/jenjangs', 'JenjangController@getJenjangs');
    
    Route::get('/permohonan_magang', 'PermohonanMagangController@index')->middleware('checkUserLevel:1,2,3,5,6')->name('sindikat.permohonan_magang.index');
    Route::post('/permohonan_magang/store', 'PermohonanMagangController@store')->middleware('auth')->name('sindikat.permohonan_magang.store');
    Route::get('/permohonan_magang/edit/{id}', 'PermohonanMagangController@edit')->middleware('auth')->name('sindikat.permohonan_magang.edit');
    Route::get('/permohonan_magang/show/{id}', 'PermohonanMagangController@show')->middleware('auth')->name('sindikat.permohonan_magang.show');
    Route::delete('/permohonan_magang/destroy/{id}', 'PermohonanMagangController@destroy')->middleware('auth')->name('sindikat.permohonan_magang.destroy');
    Route::put('/permohonan_magang/update/{id}','PermohonanMagangController@update')->middleware('auth')->name('sindikat.permohonan_magang.update');
    Route::put('/permohonan_magang/konfirmasi/{id}','PermohonanMagangController@konfirmasi')->middleware('auth')->name('sindikat.permohonan_magang.konfirmasi');

    Route::get('/permohonan_diklat', 'PermohonanDiklatPegawaiController@index')->middleware('checkUserLevel:1,2,3,5,6')->name('sindikat.permohonan_diklat.index');
    Route::post('/permohonan_diklat/store', 'PermohonanDiklatPegawaiController@store')->middleware('auth')->name('sindikat.permohonan_diklat.store');
    Route::get('/permohonan_diklat/edit/{id}', 'PermohonanDiklatPegawaiController@edit')->middleware('auth')->name('sindikat.permohonan_diklat.edit');
    Route::get('/permohonan_diklat/show/{id}', 'PermohonanDiklatPegawaiController@show')->middleware('auth')->name('sindikat.permohonan_diklat.show');
    Route::delete('/permohonan_diklat/destroy/{id}', 'PermohonanDiklatPegawaiController@destroy')->middleware('auth')->name('sindikat.permohonan_diklat.destroy');
    Route::put('/permohonan_diklat/update/{id}','PermohonanDiklatPegawaiController@update')->middleware('auth')->name('sindikat.permohonan_diklat.update');

    Route::get('/permohonan_litbang', 'PermohonanLitbangDetailController@index')->middleware('checkUserLevel:1,2,3,5,6')->name('sindikat.permohonan_litbang.index');

    Route::delete('/peserta_permohonan_diklat/destroy/{id}', 'PesertaPermohonanDiklatController@destroy')->middleware('auth')->name('sindikat.peserta_permohonan_diklat.destroy');

    Route::get('/jurusan/edit/{id}', 'JurusanController@edit')->middleware('auth')->name('sindikat.jurusan.edit');
    Route::post('/jurusan/store', 'JurusanController@store')->middleware('auth')->name('sindikat.jurusan.store');
    Route::delete('/jurusan/destroy/{id}', 'JurusanController@destroy')->middleware('auth')->name('sindikat.jurusan.destroy');
    Route::put('/jurusan/update/{id}','JurusanController@update')->middleware('auth')->name('sindikat.jurusan.update');
    //select2 Option
    Route::get('/jurusans', 'JenjangController@getJurusans');

    Route::get('/peserta_didik', 'PesertaDidikController@index')->middleware('auth')->name('sindikat.peserta_didik.index');
    Route::post('/peserta_didik/cari', 'PesertaDidikController@index')->middleware('auth')->name('sindikat.peserta_didik.cari');
    Route::get('/peserta_didik/show/{id}', 'PesertaDidikController@show')->middleware('auth')->name('sindikat.peserta_didik.show');
    Route::post('/peserta_didik/store', 'PesertaDidikController@store')->middleware('auth')->name('sindikat.peserta_didik.store');
    Route::delete('/peserta_didik/destroy/{id}', 'PesertaDidikController@destroy')->middleware('auth')->name('sindikat.peserta_didik.destroy');
    Route::put('/peserta_didik/update/{id}','PesertaDidikController@update')->middleware('auth')->name('sindikat.peserta_didik.update');
    Route::delete('/peserta_didik/destroy/{id}', 'PesertaDidikController@destroy')->middleware('auth')->name('sindikat.peserta_didik.destroy');

    Route::get('/evaluasi_peserta_magang', 'PesertaDidikController@evaluasi')->middleware('auth')->name('sindikat.evaluasi_peserta_magang.index');
    Route::post('/evaluasi_peserta_magang/store/{id?}', 'EvaluasiPesertaController@store')->middleware('auth')->name('sindikat.evaluasi_peserta.store');
    Route::delete('/evaluasi_peserta_magang/destroy/{id}', 'EvaluasiPesertaController@destroy')->middleware('auth')->name('sindikat.evaluasi_peserta.destroy');

    Route::post('jadwal_peserta_didik/store', 'JadwalPesertaDidikController@store')->middleware('auth')->name('sindikat.jadwal_peserta_didik.store');

    Route::get('/arsip/jenis/{param}', 'ArsipController@index')->middleware('auth')->name('sindikat.arsip.index');
    Route::post('/arsip/jenis/cari', 'ArsipController@index')->middleware('auth')->name('sindikat.arsip.cari');
    Route::get('/arsip/create/', 'ArsipController@create')->middleware('auth')->name('sindikat.arsip.create');
    Route::get('/arsip/{slug}', 'ArsipController@show')->middleware('auth')->name('sindikat.arsip.show');
    Route::post('/arsip/store', 'ArsipController@store')->middleware('auth')->name('sindikat.arsip.store');
    Route::delete('/arsip/destroy/{id}', 'ArsipController@destroy')->middleware('auth')->name('sindikat.arsip.destroy');
    Route::put('/arsip/update/{id}','ArsipController@update')->middleware('auth')->name('sindikat.arsip.update');

    Route::post('/arsipfile/store', 'ArsipFileController@store')->middleware('auth')->name('sindikat.arsipfile.store');
    Route::delete('/arsipfile/destroy/{id}', 'ArsipFileController@destroy')->middleware('auth')->name('sindikat.arsipfile.destroy');

    Route::get('/arsip_diklat', 'DiklatController@index')->middleware('checkUserLevel:1,2,3,5,6')->name('sindikat.arsip_diklat.index');
    Route::post('/arsip_diklat', 'DiklatController@index')->middleware('checkUserLevel:1,2,3,5,6')->name('sindikat.arsip_diklat.cari');
    Route::get('/arsip_diklat/show/{id}', 'DiklatController@show')->middleware('auth')->name('sindikat.arsip_diklat.show');
    Route::delete('/arsip_diklat/destroy/{id}', 'DiklatController@destroy')->middleware('auth')->name('sindikat.arsip_diklat.destroy');
    Route::put('/arsip_diklat/update/{id}','DiklatController@update')->middleware('auth')->name('sindikat.arsip_diklat.update');
    Route::get('/arsip_dikat/export', 'DiklatController@export')->middleware('auth')->name('sindikat.arsip_diklat.export');

    Route::get('/portal_litbang', 'PermohonanLitbangController@login')->name('sindikat.litbang.login');
    Route::get('/form_register_litbang', 'PermohonanLitbangController@create')->name('sindikat.litbang.create_account');
    Route::post('/request_litbang_account', 'PermohonanLitbangController@store')->name('sindikat.litbang.request_account');
    Route::post('/litbang_login_process', 'PermohonanLitbangController@login_process')->name('sindikat.litbang.login_process');
    Route::get('/permohonan_litbang/{id}', 'PermohonanLitbangController@permohonan_litbang')->name('sindikat.litbang.permohonan_litbang');
    Route::put('/litbang_account/update/{id}','PermohonanLitbangController@update')->name('sindikat.litbang.update');
    Route::post('/request_litbang', 'PermohonanLitbangDetailController@store')->name('sindikat.litbang.request_litbang');
    Route::delete('/request_litbang/destroy/{id}', 'PermohonanLitbangDetailController@destroy')->name('sindikat.proposal_litbang.destroy');
    Route::get('/request_litbang/edit/{id}', 'PermohonanLitbangDetailController@edit')->name('sindikat.proposal_litbang.edit');
    Route::put('/litbang_request/update/{id}','PermohonanLitbangDetailController@update')->name('sindikat.request_litbang.update');
});
