<?php

namespace Modules\Sindikat\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Kepegawaian\Entities\ProfilPegawai;
use Modules\Kepegawaian\Entities\PegawaiCI;

class InstrukturKlinikController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {

        $employees = ProfilPegawai::orderBy('nama', 'ASC')->get();

        $pegawais = ProfilPegawai::with(['instruktur_klinik'=>function($q){
                                        $q->where('status', 1);
                                    },'jabatan_aktif', 'unit_jabatan_aktif'])
                                    ->whereHas('instruktur_klinik', function ($query) {
                                        $query->where('status', 1);
                                    })
                                    ->orderBy('nama', 'ASC')->get();

        return view('sindikat::pegawai.index', compact('pegawais', 'employees'));
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
        // Validasi input jika diperlukan
        $request->validate([
            'jenis_ci' => 'required|string',
            'pegawai_id' => 'required|array',
            'no_sk' => 'required|string',
            'tanggal_sk' => 'required|date',
        ]);

        // Ambil data dari form
        $jenis_ci = $request->input('jenis_ci');
        $no_sk = $request->input('no_sk');
        $tanggal_sk = $request->input('tanggal_sk');
        $pegawai_ids = $request->input('pegawai_id'); // Array of pegawai IDs
        
        // dd($pegawai_ids);
        // Iterasi melalui setiap pegawai_id yang dipilih
        foreach ($pegawai_ids as $pegawai_id) {
            // Buat instance baru untuk tabel `pegawai_ci`

            // dd($pegawai_id);
            $pegawaiCI = new PegawaiCI();
            $pegawaiCI->pegawai_id = $pegawai_id;
            $pegawaiCI->jenis_ci = $jenis_ci;
            $pegawaiCI->no_sk = $no_sk;
            $pegawaiCI->tanggal_sk = $tanggal_sk;
            $pegawaiCI->status = 1; // Jika Anda memiliki status default
            $pegawaiCI->save();
        }

        return redirect()->back()->with('success', 'Data Rekomendasi Instruktur Klinik Berhasil ditambahkan');

    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function profil($id)
    {
        $pegawai = ProfilPegawai::with(['instruktur_klinik'=>function($q){
                                            $q->where('status', 1);
                                        },
                                        'unit_jabatan_aktif', 'jabatan_aktif', 'golongan_aktif', 'riwayat_pendidikan', 'riwayat_diklat', 
                                        'riwayat_artikel', 'riwayat_karya_buku', 'riwayat_inovasi', 'riwayat_pekerjaan', 'riwayat_organisasi'])
                                        ->findOrFail($id);

        return view('sindikat::pegawai.profil', compact('pegawai'));
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
        //
    }
}
