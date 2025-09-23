<?php

namespace Modules\Sindikat\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Sindikat\Entities\KarirPeserta;


class KarirPesertaAllController extends Controller
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

        return view('sindikat::karir.sanggah', compact('peserta'));
    }

    public function data_sanggahan()
    {
        $formasi = request('formasi');

        if ($formasi != null) {
            $peserta = KarirPeserta::whereNotNull('sanggahan')->whereNull('response_sanggah')->where('formasi', $formasi)->latest()->paginate(20);
        }else{

            $peserta = KarirPeserta::whereNotNull('sanggahan')->whereNull('response_sanggah')->latest()->paginate(20);
        }

        $peserta_response = KarirPeserta::whereNotNull('response_sanggah')->latest()->get();

        return view('sindikat::karir.data_sanggahan', compact('peserta', 'peserta_response'));

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
        $peserta = KarirPeserta::findOrFail($id);
        return response()->json($peserta);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function sanggah(Request $request, $id)
    {
        $peserta = KarirPeserta::find($id);

        // dd($request);
        $peserta->update([
            'sanggahan' => $request->sanggah
        ]);

        return redirect()->back()->with('success', 'Pesan Sanggahan Anda berhasil disimpan');
        
    }

    public function tanggapi_sanggahan(Request $request, $id)
    {
        $peserta = KarirPeserta::find($id);

        // dd($request);
        $peserta->update([
            'verifikator_response' => $request->verifikator_response,
            'response_sanggah' => $request->response_sanggah,
            'update_keterangan' => $request->update_keterangan
        ]);

        return redirect()->back()->with('success', 'Pesan Sanggahan Anda berhasil disimpan');
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
