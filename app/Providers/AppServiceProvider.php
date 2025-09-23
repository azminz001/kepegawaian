<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\DB;
use Modules\Kepegawaian\Entities\RiwayatPendidikan;
use Modules\Kepegawaian\Entities\RiwayatJabatan;
use Modules\Kepegawaian\Entities\RiwayatJabatanUnit;
use Modules\Kepegawaian\Entities\RiwayatGolongan;
use Modules\Kepegawaian\Entities\RiwayatGajiBerkala;
use Modules\Kepegawaian\Entities\PegawaiCI;
use Modules\Kepegawaian\Entities\ProfilPegawai;
use App\Observers\RiwayatPendidikanObserver;
use App\Observers\RiwayatJabatanObserver;
use App\Observers\RiwayatJabatanUnitObserver;
use App\Observers\RiwayatGolonganObserver;
use App\Observers\RiwayatGajiBerkalaObserver;
use App\Observers\RiwayatPegawaiCIObserver;
use App\Observers\ProfilPegawaiObserver;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        DB::listen(function ($query) {
            Log::info(
                $query->sql,
                $query->bindings,
                $query->time
            );
        });
        RiwayatPendidikan::observe(RiwayatPendidikanObserver::class);
        RiwayatJabatan::observe(RiwayatJabatanObserver::class);
        RiwayatJabatanUnit::observe(RiwayatJabatanUnitObserver::class);
        RiwayatGolongan::observe(RiwayatGolonganObserver::class);
        RiwayatGajiBerkala::observe(RiwayatGajiBerkalaObserver::class);
        PegawaiCI::observe(RiwayatPegawaiCIObserver::class);
        ProfilPegawai::observe(ProfilPegawaiObserver::class);

        View::composer('*', function ($view) {
            if (Auth::check()) { // Periksa apakah pengguna sudah login
                $username = trim(Auth::user()->username);
        
                $menu_pegawai = ProfilPegawai::with('awal_kerja')
                    ->where('nip_nipppk_nrpk_nrpblud', $username)
                    ->first();
        
                $view->with('menu_pegawai', $menu_pegawai);
            } else {
                $view->with('menu_pegawai', null); // Kosongkan data jika tidak login
            }
        });
    }
}
