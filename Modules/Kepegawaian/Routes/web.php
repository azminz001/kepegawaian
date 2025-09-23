<?php
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|

[yotuwp type="playlist" id="PLlaje5r34YWDxcLH69hz778VHY68gepe_" ]
*/

Route::prefix('kepegawaian')->group(function() {
    Route::get('/',[AuthController::class, 'showLoginForm']);
    Route::get('/profil_pegawai/{id}', 'ProfilPegawaiController@getProfilPegawai');
    Route::middleware(['auth'])->group(function () {
        // Route::prefix('profil')->group(function() {
        //     Route::get('/', 'PenggunaController@profil');
        //     Route::get('/storage', function(){
        //         return "Hello World";
        //     });
        // });
        Route::get('/dashboard', 'KepegawaianController@index')->name('kepegawaian.dashboard')->middleware('checkUserLevel:3,4');
        // Route::get('/index', function(){
        //             return "Hello World";
        //         });

        Route::get('/unit', 'UnitController@index')->name('kepegawaian.unit.index')->middleware('checkUserLevel:2,3,4');
        Route::get('/unit/show/{id}', 'UnitController@show')->name('unit.show')->middleware('checkUserLevel:2,3,4');
        Route::post('/unit/store', 'UnitController@store')->name('unit.store')->middleware('checkUserLevel:2,3,4');
        Route::delete('/unit/destroy/{id}', 'UnitController@destroy')->name('unit.destroy')->middleware('checkUserLevel:2,3,4');
        Route::put('/unit/update/{id}','UnitController@update')->name('unit.update')->middleware('checkUserLevel:2,3,4');
        //select2 Option
        Route::get('/units', 'UnitController@getUnits');

        Route::get('/jabatan_unit', 'JabatanUnitController@index')->name('jabatan_unit.index')->middleware('checkUserLevel:2,3,4');
        Route::post('/jabatan_unit', 'JabatanUnitController@index')->name('jabatan_unit.cari')->middleware('checkUserLevel:2,3,4');
        Route::post('/jabatan_unit/store', 'JabatanUnitController@store')->name('jabatan_unit.store')->middleware('checkUserLevel:2,3,4');
        Route::delete('/jabatan_unit/destroy/{id}', 'JabatanUnitController@destroy')->name('jabatan_unit.destroy')->middleware('checkUserLevel:2,3,4');
        Route::put('/jabatan_unit/update/{id}','JabatanUnitController@update')->name('jabatan_unit.update')->middleware('checkUserLevel:2,3,4');
        //select2 Option
        Route::get('/jabatan_units', 'JabatanUnitController@getJabatanUnits');
        Route::get('/profil_pegawai/{id}', 'ProfilPegawaiController@getProfilPegawai');

        Route::get('/kelompok_jabatan', 'KelJabatanController@index')->name('kelompok_jabatan.index')->middleware('checkUserLevel:2,3,4');
        Route::get('/kelompok_jabatan/show/{id}', 'KelJabatanController@show')->name('kelompok_jabatan.show')->middleware('checkUserLevel:2,3,4');
        Route::post('/kelompok_jabatan/store', 'KelJabatanController@store')->name('kelompok_jabatan.store')->middleware('checkUserLevel:2,3,4');
        Route::delete('/kelompok_jabatan/destroy/{id}', 'KelJabatanController@destroy')->name('kelompok_jabatan.destroy')->middleware('checkUserLevel:2,3,4');
        Route::put('/kelompok_jabatan/update/{id}','KelJabatanController@update')->name('kelompok_jabatan.update')->middleware('checkUserLevel:2,3,4');
        //select2 Option
        Route::get('/kelompok_jabatans', 'KelJabatanController@getKelJabatans');

        // Route::get('/event', 'EventsController@index')->name('event.index');


        Route::get('/jabatan', 'JabatanController@index')->name('jabatan.index')->middleware('checkUserLevel:2,3,4');
        Route::post('/jabatan', 'JabatanController@index')->name('jabatan.cari')->middleware('checkUserLevel:2,3,4');
        Route::post('/jabatan/store', 'JabatanController@store')->name('jabatan.store')->middleware('checkUserLevel:2,3,4');
        Route::delete('/jabatan/destroy/{id}', 'JabatanController@destroy')->name('jabatan.destroy')->middleware('checkUserLevel:2,3,4');
        Route::put('/jabatan/update/{id}','JabatanController@update')->name('jabatan.update')->middleware('checkUserLevel:2,3,4');
        Route::get('/detailJabatan/{id}', 'JabatanController@detailJabatan');

        Route::get('/pengguna', 'PenggunaController@index')->name('pengguna.index')->middleware('checkUserLevel:2,3,4');
        Route::post('/pengguna', 'PenggunaController@index')->name('pengguna.cari')->middleware('checkUserLevel:2,3,4');
        Route::post('/pengguna/store', 'PenggunaController@store')->name('pengguna.store')->middleware('checkUserLevel:2,3,4');
        Route::delete('/pengguna/destroy/{id}', 'PenggunaController@destroy')->name('pengguna.destroy')->middleware('checkUserLevel:2,3,4');
        Route::put('/pengguna/update/{id}','PenggunaController@update')->name('pengguna.update');
        Route::put('/pengguna/reset_password/{id}','PenggunaController@reset_password')->name('pengguna.reset_password');
        Route::put('/pengguna/ubah_password/{id}','PenggunaController@ubah_password')->name('pengguna.ubah_password');
        Route::get('/pengguna/edit/{id}', 'PenggunaController@edit')->name('pengguna.edit');

        //select2 Option
        Route::get('/jabatans', 'JabatanController@getJabatans');
        Route::get('/eselons', 'EselonController@getEselons');
        Route::get('/golongans', 'GolonganController@getGolongans');
        Route::get('/jenjang_pendidikans', 'JenjangPendidikanController@getJenjangPendidikans');

        Route::get('/data_pegawai', 'ProfilPegawaiController@index')->name('data_pegawai.index')->middleware('checkUserLevel:2,3,4');
        Route::get('/data_pegawai/{tipe}', 'ProfilPegawaiController@index')->name('data_pegawai.filter')->middleware('checkUserLevel:2,3,4');
        Route::post('/data_pegawai', 'ProfilPegawaiController@index')->name('data_pegawai.cari')->middleware('checkUserLevel:2,3,4');
        Route::put('/data_pegawai/ganti_foto/{id}','ProfilPegawaiController@ganti_foto')->name('data_pegawai.ganti_foto');
        Route::get('/data_pegawai/show/{id}', 'ProfilPegawaiController@show')->name('data_pegawai.show')->middleware('checkUserLevel:2,3,4');;
        Route::post('/data_pegawai/store', 'ProfilPegawaiController@store')->name('data_pegawai.store')->middleware('checkUserLevel:2,3,4');
        Route::delete('/data_pegawai/destroy/{id}', 'ProfilPegawaiController@destroy')->name('data_pegawai.destroy')->middleware('checkUserLevel:2,3,4');
        Route::put('/data_pegawai/update/{id}','ProfilPegawaiController@update')->name('data_pegawai.update');

        Route::get('/data_pegawai/riwayat_jabatan/{id}', 'ProfilPegawaiController@lihat_riwayat_jabatan')->name('data_pegawai.riwayat_jabatan');
        Route::get('/data_pegawai/riwayat_jabatan_unit/{id}', 'ProfilPegawaiController@lihat_riwayat_jabatan_unit')->name('data_pegawai.riwayat_jabatan_unit');
        Route::get('/data_pegawai/riwayat_golongan/{id}', 'ProfilPegawaiController@lihat_riwayat_golongan')->name('data_pegawai.riwayat_golongan');
        Route::get('/data_pegawai/riwayat_gaji_berkala/{id}', 'ProfilPegawaiController@lihat_riwayat_gaji_berkala')->name('data_pegawai.riwayat_gaji_berkala');
        Route::get('/data_pegawai/riwayat_pendidikan/{id}', 'ProfilPegawaiController@lihat_riwayat_pendidikan')->name('data_pegawai.riwayat_pendidikan');
        Route::get('/data_pegawai/riwayat_diklat/{id}', 'ProfilPegawaiController@lihat_riwayat_diklat')->name('data_pegawai.riwayat_diklat');
        Route::get('/data_pegawai/riwayat_karya_ilmiah/{id}', 'ProfilPegawaiController@lihat_riwayat_karya_ilmiah')->name('data_pegawai.riwayat_karya_ilmiah');
        Route::get('/data_pegawai/riwayat_pekerjaan/{id}', 'ProfilPegawaiController@lihat_riwayat_pekerjaan')->name('data_pegawai.riwayat_pekerjaan');
        Route::get('/data_pegawai/riwayat_organisasi/{id}', 'ProfilPegawaiController@lihat_riwayat_organisasi')->name('data_pegawai.riwayat_organisasi');
        Route::get('/data_pegawai/riwayat_pegawai_ci/{id}', 'ProfilPegawaiController@lihat_riwayat_pegawai_ci')->name('data_pegawai.riwayat_pegawai_ci');
        Route::get('/data_pegawai/riwayat_permohonan_diklat/{id}', 'ProfilPegawaiController@lihat_riwayat_permohonan_diklat')->name('data_pegawai.riwayat_permohonan_diklat');
        Route::get('/data_pegawai/dokumen/{id}', 'ProfilPegawaiController@lihat_dokumen')->name('data_pegawai.dokumen');
        Route::get('/data_pegawai/permohonan_kontrak/{id}', 'ProfilPegawaiController@lihat_permohonan_kontrak')->name('data_pegawai.permohonan_kontrak');
        Route::get('/data_pegawai/pasangan/{id}', 'ProfilPegawaiController@lihat_pasangan')->name('data_pegawai.pasangan');
        Route::get('/data_pegawai/anak/{id}', 'ProfilPegawaiController@lihat_anak')->name('data_pegawai.anak');

        Route::get('/riwayat_jabatan/edit/{id}', 'RiwayatJabatanController@edit')->name('riwayat_jabatan.edit');
        Route::post('/riwayat_jabatan/store', 'RiwayatJabatanController@store')->name('riwayat_jabatan.store');
        Route::delete('/riwayat_jabatan/destroy/{id}', 'RiwayatJabatanController@destroy')->name('riwayat_jabatan.destroy');
        Route::put('/riwayat_jabatan/update/{id}','RiwayatJabatanController@update')->name('riwayat_jabatan.update');

        Route::get('/riwayat_jabatan_unit/edit/{id}', 'RiwayatJabatanUnitController@edit')->name('riwayat_jabatan_unit.edit');
        Route::post('/riwayat_jabatan_unit/store', 'RiwayatJabatanUnitController@store')->name('riwayat_jabatan_unit.store');
        Route::delete('/riwayat_jabatan_unit/destroy/{id}', 'RiwayatJabatanUnitController@destroy')->name('riwayat_jabatan_unit.destroy');
        Route::put('/riwayat_jabatan_unit/update/{id}','RiwayatJabatanUnitController@update')->name('riwayat_jabatan_unit.update');

        Route::get('/riwayat_golongan/edit/{id}', 'RiwayatGolonganController@edit')->name('riwayat_golongan.edit');
        Route::post('/riwayat_golongan/store', 'RiwayatGolonganController@store')->name('riwayat_golongan.store');
        Route::delete('/riwayat_golongan/destroy/{id}', 'RiwayatGolonganController@destroy')->name('riwayat_golongan.destroy');
        Route::put('/riwayat_golongan/update/{id}','RiwayatGolonganController@update')->name('riwayat_golongan.update');

        Route::get('/riwayat_gaji_berkala/edit/{id}', 'RiwayatGajiBerkalaController@edit')->name('riwayat_gaji_berkala.edit');
        Route::post('/riwayat_gaji_berkala/store', 'RiwayatGajiBerkalaController@store')->name('riwayat_gaji_berkala.store');
        Route::delete('/riwayat_gaji_berkala/destroy/{id}', 'RiwayatGajiBerkalaController@destroy')->name('riwayat_gaji_berkala.destroy');
        Route::put('/riwayat_gaji_berkala/update/{id}','RiwayatGajiBerkalaController@update')->name('riwayat_gaji_berkala.update');

        Route::get('/riwayat_pendidikan/edit/{id}', 'RiwayatPendidikanController@edit')->name('riwayat_pendidikan.edit');
        Route::post('/riwayat_pendidikan/store', 'RiwayatPendidikanController@store')->name('riwayat_pendidikan.store');
        Route::delete('/riwayat_pendidikan/destroy/{id}', 'RiwayatPendidikanController@destroy')->name('riwayat_pendidikan.destroy');
        Route::put('/riwayat_pendidikan/update/{id}','RiwayatPendidikanController@update')->name('riwayat_pendidikan.update');

        Route::get('/riwayat_diklat/edit/{id}', 'RiwayatDiklatController@edit')->name('riwayat_diklat.edit');
        Route::post('/riwayat_diklat/store', 'RiwayatDiklatController@store')->name('riwayat_diklat.store');
        Route::delete('/riwayat_diklat/destroy/{id}', 'RiwayatDiklatController@destroy')->name('riwayat_diklat.destroy');
        Route::put('/riwayat_diklat/update/{id}','RiwayatDiklatController@update')->name('riwayat_diklat.update');

        Route::get('/riwayat_artikel/edit/{id}', 'RiwayatArtikelController@edit')->name('riwayat_artikel.edit');
        Route::post('/riwayat_artikel/store', 'RiwayatArtikelController@store')->name('riwayat_artikel.store');
        Route::delete('/riwayat_artikel/destroy/{id}', 'RiwayatArtikelController@destroy')->name('riwayat_artikel.destroy');
        Route::put('/riwayat_artikel/update/{id}','RiwayatArtikelController@update')->name('riwayat_artikel.update');

        Route::get('/riwayat_buku/edit/{id}', 'RiwayatBukuController@edit')->name('riwayat_buku.edit');
        Route::post('/riwayat_buku/store', 'RiwayatBukuController@store')->name('riwayat_buku.store');
        Route::delete('/riwayat_buku/destroy/{id}', 'RiwayatBukuController@destroy')->name('riwayat_buku.destroy');
        Route::put('/riwayat_buku/update/{id}','RiwayatBukuController@update')->name('riwayat_buku.update');

        Route::get('/riwayat_inovasi/edit/{id}', 'RiwayatInovasiController@edit')->name('riwayat_inovasi.edit');
        Route::post('/riwayat_inovasi/store', 'RiwayatInovasiController@store')->name('riwayat_inovasi.store');
        Route::delete('/riwayat_inovasi/destroy/{id}', 'RiwayatInovasiController@destroy')->name('riwayat_inovasi.destroy');
        Route::put('/riwayat_inovasi/update/{id}','RiwayatInovasiController@update')->name('riwayat_inovasi.update');

        Route::get('/riwayat_pekerjaan/edit/{id}', 'RiwayatPekerjaanController@edit')->name('riwayat_pekerjaan.edit');
        Route::post('/riwayat_pekerjaan/store', 'RiwayatPekerjaanController@store')->name('riwayat_pekerjaan.store');
        Route::delete('/riwayat_pekerjaan/destroy/{id}', 'RiwayatPekerjaanController@destroy')->name('riwayat_pekerjaan.destroy');
        Route::put('/riwayat_pekerjaan/update/{id}','RiwayatPekerjaanController@update')->name('riwayat_pekerjaan.update');

        Route::get('/riwayat_organisasi/edit/{id}', 'RiwayatOrganisasiController@edit')->name('riwayat_organisasi.edit');
        Route::post('/riwayat_organisasi/store', 'RiwayatOrganisasiController@store')->name('riwayat_organisasi.store');
        Route::delete('/riwayat_organisasi/destroy/{id}', 'RiwayatOrganisasiController@destroy')->name('riwayat_organisasi.destroy');
        Route::put('/riwayat_organisasi/update/{id}','RiwayatOrganisasiController@update')->name('riwayat_organisasi.update');

        Route::get('/riwayat_pegawai_ci/edit/{id}', 'RiwayatPegawaiCIController@edit')->name('riwayat_pegawai_ci.edit');
        Route::post('/riwayat_pegawai_ci/store', 'RiwayatPegawaiCIController@store')->name('riwayat_pegawai_ci.store');
        Route::delete('/riwayat_pegawai_ci/destroy/{id}', 'RiwayatPegawaiCIController@destroy')->name('riwayat_pegawai_ci.destroy');
        Route::put('/riwayat_pegawai_ci/update/{id}','RiwayatPegawaiCIController@update')->name('riwayat_pegawai_ci.update');

        Route::get('/dokumen/edit/{id}', 'DokumenPegawaiController@edit')->name('dokumen.edit');
        Route::post('/dokumen/store', 'DokumenPegawaiController@store')->name('dokumen.store');
        Route::delete('/dokumen/destroy/{id}', 'DokumenPegawaiController@destroy')->name('dokumen.destroy');

        Route::get('/permohonan_kontrak/edit/{id}', 'RiwayatKontrakKerjaController@edit')->name('kontrak_kerja.edit');
        Route::post('/permohonan_kontrak/store', 'RiwayatKontrakKerjaController@store')->name('kontrak_kerja.store');
        Route::delete('/permohonan_kontrak/destroy/{id}', 'RiwayatKontrakKerjaController@destroy')->name('kontrak_kerja.destroy');

        Route::get('/pasangan/edit/{id}', 'PasanganPegawaiController@edit')->name('pasangan.edit');
        Route::post('/pasangan/store', 'PasanganPegawaiController@store')->name('pasangan.store');
        Route::delete('/pasangan/destroy/{id}', 'PasanganPegawaiController@destroy')->name('pasangan.destroy');
        Route::put('/pasangan/update/{id}','PasanganPegawaiController@update')->name('pasangan.update');

        Route::get('/anak/edit/{id}', 'AnakPegawaiController@edit')->name('anak.edit');
        Route::post('/anak/store', 'AnakPegawaiController@store')->name('anak.store');
        Route::delete('/anak/destroy/{id}', 'AnakPegawaiController@destroy')->name('anak.destroy');
        Route::put('/anak/update/{id}','AnakPegawaiController@update')->name('anak.update');


        Route::post('/berita/store', 'KepegawaianController@store_berita')->name('berita.store');
        Route::delete('/berita/destroy/{id}', 'KepegawaianController@destroy_berita')->name('berita.destroy');

        Route::get('/pegawai/profil', 'ProfilPegawaiController@profil')->name('pegawai.profil');

        Route::get('/keluhan', 'KeluhanController@index')->name('data_pegawai.keluhan');
        Route::get('/keluhan/{id}', 'KeluhanController@index')->name('data_pegawai.keluhan.pegawai');
        Route::post('/keluhan', 'KeluhanController@index')->name('data_pegawai.keluhan.cari');
        Route::post('/keluhan/store', 'KeluhanController@store')->name('data_pegawai.keluhan.store');
        Route::delete('/keluhan/destroy/{id}', 'KeluhanController@destroy')->name('data_pegawai.keluhan.destroy');
        Route::get('/keluhan/diskusi/{id}', 'KeluhanController@show')->name('data_pegawai.keluhan.diskusi');

        Route::post('/keluhanbalasan/store', 'KeluhanBalasanController@store')->name('data_pegawai.keluhanbalas.store');
        Route::delete('/keluhanbalasan/destroy/{id}', 'KeluhanBalasanController@destroy')->name('data_pegawai.keluhanbalasan.destroy');

        Route::get('/broadcast', 'KepegawaianController@broadcast')->name('whatsapp.broadcast');



        
    })->name('kepegawaian');
});
/*
Route::prefix('pengguna')->group(function() {
    Route::prefix('profil')->group(function() {
        Route::get('/', 'PenggunaController@profil');
        Route::get('/storage', 'PenggunaController@storage');
    });
    
    Route::get('/dokumen/{id}/{rec_id}', 'PenggunaController@dokumen')->name('pengguna.dokumen');;
    Route::get('/rekomendasi/{id_submission}', 'PenggunaController@rekomendasi')->name('pengguna.rekomendasi');
    Route::post('/rekomendasi', 'PenggunaController@rekomendasi');
    Route::get('/rekomendasi/{id_submission}/{status}', 'PenggunaController@rekomendasi')->name('pengguna.rekomendasi');
    Route::get('/riwayat', 'PenggunaController@riwayat');
    Route::get('/layanan', 'PenggunaController@layanan');
    Route::post('/uploadDokumen', 'PenggunaController@uploadDokumen');
    Route::post('/konfirmasi_usulan', 'PenggunaController@konfirmasi_usulan');
    Route::post('/update_profil', 'PenggunaController@update_profil');
    Route::post('/usulkan', 'PenggunaController@usulkan');
    Route::post('/hapusDokumen', 'PenggunaController@hapusDokumen');
    // Route::delete('/hapus-dokumen/{fileId}', 'PenggunaController@hapusDokumen')->name('hapusDokumen');

    Route::prefix('dashboard')->group(function() {
        Route::get('/', 'DashboardController@index');
        Route::get('/{id_kategori}', 'DashboardController@index');
    });
});    

*/