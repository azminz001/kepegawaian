<?php

namespace Modules\Kepegawaian\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Kepegawaian\Entities\PegawaiCI;


class RiwayatPegawaiCIController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('kepegawaian::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('kepegawaian::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $request->validate([
            'no_sk'         => 'required|string|max:255',
            'tanggal_sk'    => 'required|date',
            'jenis_ci'      => 'required'
        ]);

        PegawaiCI::create([
            'no_sk' => $request->no_sk,
            'tanggal_sk' => $request->tanggal_sk,
            'jenis_ci' => $request->jenis_ci,
            'keterangan' => $request->keterangan,
            'pegawai_id' => $request->pegawai_id,
            'status' => ($request->status != null) ? $request->status : '0'
        ]);
        return redirect()->back()->with(['success' => 'Data Riwayat Instruktur Klinik Berhasil Disimpan']);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('kepegawaian::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $pegawai_ci = PegawaiCI::findOrFail($id);
        return response()->json($pegawai_ci);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'no_sk'         => 'required|string|max:255',
            'tanggal_sk'    => 'required|date',
            'jenis_ci'      => 'required'
        ]);

        $pegawai_ci = PegawaiCI::findOrFail($id);

        $pegawai_ci->update([
            'no_sk' => $request->no_sk,
            'tanggal_sk' => $request->tanggal_sk,
            'jenis_ci' => $request->jenis_ci,
            'keterangan' => $request->keterangan,
            'status' => ($request->status != null) ? $request->status : '0'
        ]);
        return redirect()->back()->with(['success' => 'Data Riwayat Instruktur Klinik Berhasil Disimpan']);
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        $pegawai_ci = PegawaiCI::findOrFail($id);

        if ($pegawai_ci) {
            $pegawai_ci->delete();

            return redirect()->back()->with('success', 'Data Instruktur Klinik berhasil dihapus.');
        } else {
            return redirect()->back()->with('error', 'Instruktur Klinik tidak ditemukan.');
        }
    }
}
