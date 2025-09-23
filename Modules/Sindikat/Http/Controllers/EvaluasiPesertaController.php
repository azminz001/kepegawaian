<?php

namespace Modules\Sindikat\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Kepegawaian\Entities\ProfilPegawai;
use Modules\Sindikat\Entities\EvaluasiPeserta;
use Modules\Sindikat\Entities\PesertaDidik;

class EvaluasiPesertaController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('sindikat::index');
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
    public function store(Request $request, $id)
    {
        $peserta_didik = PesertaDidik::with('institusi')->findOrFail($id);

        $username = Auth::user()->username;
        $instruktur = ProfilPegawai::where('nip_nipppk_nrpk_nrpblud', $username)->first();
        
        $request->validate([
            'catatan'     => 'required|string',
            'dokumen'     => 'required|mimes:pdf,jpg,jpeg,png|max:20000',
        ]);

        $dokumen = $request->file('dokumen');
        $nama_file = $peserta_didik->institusi->nama.'-'.$peserta_didik->nama_lengkap.'-'.time().'.'.$dokumen->getClientOriginalExtension();
        $dokumen->storeAs('public/sindikat/evaluasi_peserta/', $nama_file); 

        EvaluasiPeserta::create([
            'dokumen'  => $nama_file,
            'catatan' => $request->catatan,
            'permohonan_magang_id' => $request->permohonan_magang_id,
            'peserta_didik_id' => $peserta_didik->id,
            'pegawai_id' => $instruktur->id
        ]);

        return redirect()->back()->with('success', 'Data Peserta didik berhasil disimpan');
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
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        $evaluasi = EvaluasiPeserta::findOrFail($id);
        \Storage::delete(['public/sindikat/evaluasi_peserta/'.$evaluasi->dokumen]);
        $evaluasi->delete();
        return redirect()->back()->with('success', 'Data Evaluasi Peserta Berhasil Dihapus');
    }
}
