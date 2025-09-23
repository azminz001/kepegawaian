<?php

namespace Modules\Sindikat\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Sindikat\Entities\KarirPeserta;


class KarirPesertaController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $email = request('email');
        $nik = request('nik');
        if(!empty($email) && !empty($nik)){
            $peserta = KarirPeserta::where('email', $email)->where('nik', $nik)->first();
            if (!$peserta) {
                $peserta = "1";
                // $peserta = "Alamat Email atau NIK yang Anda daftarkan tidak cocok, Pastikan Alamat email dan NIK sesuai dengan data ketika melamar.";
            }
        }else{
            // $peserta = "Bagi Anda yang sudah lolos silahkan ssi alamat Email dan NIK untuk mendapatkan Nomor Registrasi";
            $peserta = "2";
        }

        return view('sindikat::karir.index', compact('peserta'));
    }

    public function verify($nik)
    {
        $peserta = KarirPeserta::where('nik', $nik)->first();

        return view('sindikat::karir.verify', compact('peserta'));

    }
    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('sindikat::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('sindikat::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('sindikat::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        $peserta = KarirPeserta::find($id);
        
        $foto = $request->file('foto');

        if ($foto->getSize() > 2097152) {
            $ukuran = 2097152 / 1024 / 1024;
            // return "<script>alert('Ukuran File terlalu besar. Pastikan File tidak lebih dari 2 M');document.location.href='".route('kelengkapan_berkas.show', $request->nomor_kunjungan)."';</script>";
            return redirect()->back()->with('error', 'Ukuran File terlalu besar. Pastikan File tidak lebih dari 2 MB');

        }
        else{

            $prosesUpload = $foto->storeAs('public/foto_peserta_karir/', $peserta->nik.'.jpg');

            if ($prosesUpload) {
                $peserta->update([
                    'foto' => $peserta->nik.'.jpg'
                ]);
    
                return redirect()->back()->with('success', 'Foto Berhasil Disimpan');
            }
        }

    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }
}
