<?php

namespace Modules\Persuratan\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Database\QueryException;

use Modules\Persuratan\Entities\PerjalananDinas;
use Modules\Persuratan\Entities\SuratMasuk;
use Modules\Kepegawaian\Entities\ProfilPegawai;


class PerjalananDinasController extends Controller
{
    public function index()
    {
        $suratMasuk = SuratMasuk::orderBy('tanggal_terima', 'desc')->get();
        $pegawais = ProfilPegawai::orderBy('nip_nipppk_nrpk_nrpblud')->get();

        return view('Persuratan::perjalanan_dinas.index', compact('suratMasuk', 'pegawais'));
    }
}
