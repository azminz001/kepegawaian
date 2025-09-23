<?php

namespace Modules\Kepegawaian\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Kepegawaian\Entities\RiwayatInovasi;

class RiwayatInovasiController extends Controller
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
            'judul'         => 'required|string|max:255',
            'tahun'         => 'required',
            'jenis'         => 'required|string|max:255',
        ]);

        RiwayatInovasi::create([
            'judul' => $request->judul,
            'tahun' => $request->tahun,
            'jenis' => $request->jenis,
            'keterangan' => $request->keterangan,
            'pegawai_id' => $request->pegawai_id
        ]);

        return redirect()->back()->with(['success' => 'Data Karya Inovasi Baru berhasil Disimpan']);
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
        $inovasi = RiwayatInovasi::findOrFail($id);
        return response()->json($inovasi);
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
            'judul'         => 'required|string|max:255',
            'tahun'         => 'required',
            'jenis'         => 'required|string|max:255',
        ]);

        $inovasi = RiwayatInovasi::findOrFail($id);

        $inovasi->update([
            'judul' => $request->judul,
            'tahun' => $request->tahun,
            'jenis' => $request->jenis,
            'keterangan' => $request->keterangan,
            'pegawai_id' => $request->pegawai_id
        ]);

        return redirect()->back()->with(['success' => 'DataKarya Inovasi berhasil Disimpan']);
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        $inovasi = RiwayatInovasi::find($id);
        
        if ($inovasi) {
            $inovasi->delete();

            return redirect()->back()->with('success', 'Data Karya Inovasi berhasil dihapus.');
        } else {
            return redirect()->back()->with('error', 'Riwayat Karya Inovasi tidak ditemukan.');
        }
    }
}
