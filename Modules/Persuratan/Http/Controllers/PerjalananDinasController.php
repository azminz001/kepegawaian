<?php

namespace Modules\Persuratan\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
//use Carbon\Carbon;

//use Modules\Persuratan\Entities\Nomor;
//use Modules\Persuratan\Entities\Klasifikasi;
use Modules\Kepegawaian\Entities\ProfilPegawai;


class PerjalananDinasController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
{
    $pegawais = User::all();

    /*
    $cari = request('cari');
    $user = Auth::user();

    if (!empty($cari)) {
        $nomor = Nomor::join('klasifikasi', 'penomoran.id_klasifikasi', '=', 'klasifikasi.id')
                      ->where('penomoran.id_user', $user->id)
                      ->where(function ($query) use ($cari) {
                          $query->where('penomoran.nomor', 'like', "%" . $cari . "%")
                                ->orWhere('penomoran.nama_surat', 'like', "%" . $cari . "%")
                                ->orWhere('penomoran.status', 'like', "%" . $cari . "%")
                                ->orWhere('klasifikasi.kode', 'like', "%" . $cari . "%"); // Pencarian pada kolom nama klasifikasi
                      })
                      ->select('penomoran.*', 'klasifikasi.kode as kode_klas', 'klasifikasi.id as id_klas', 'klasifikasi.nama as nama_klas') // Pilih kolom yang diperlukan
                      ->latest()
                      ->paginate(100);

        $nomor_count = Nomor::join('klasifikasi', 'penomoran.id_klasifikasi', '=', 'klasifikasi.id')
                           ->where('penomoran.id_user', $user->id)
                           ->where(function ($query) use ($cari) {
                               $query->where('penomoran.nomor', 'like', "%" . $cari . "%")
                                     ->orWhere('penomoran.nama_surat', 'like', "%" . $cari . "%")
                                     ->orWhere('penomoran.status', 'like', "%" . $cari . "%")
                                     ->orWhere('klasifikasi.kode', 'like', "%" . $cari . "%"); // Pencarian pada kolom nama klasifikasi
                           })
                           ->count();
    } else {
        $nomor = Nomor::join('klasifikasi', 'penomoran.id_klasifikasi', '=', 'klasifikasi.id')
                      ->where('penomoran.id_user', $user->id)
                      ->select('penomoran.*', 'klasifikasi.kode as kode_klas', 'klasifikasi.id as id_klas', 'klasifikasi.nama as nama_klas') // Pilih kolom yang diperlukan
                      ->latest()
                      ->paginate(100);

        $nomor_count = Nomor::join('klasifikasi', 'penomoran.id_klasifikasi', '=', 'klasifikasi.id')
                           ->where('penomoran.id_user', $user->id)
                           ->count();
    }

    $klasifikasi = Klasifikasi::all();

    */
    return view('persuratan.perjalanan_dinas.index', compact('pegawais'));
}
}