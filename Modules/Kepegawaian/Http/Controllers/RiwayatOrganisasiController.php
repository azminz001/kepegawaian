<?php

namespace Modules\Kepegawaian\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Kepegawaian\Entities\RiwayatOrganisasi;

class RiwayatOrganisasiController extends Controller
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
            'nama'         => 'required|string|max:255',
            'jabatan'         => 'required|string|max:255',
            'tahun_mulai'         => 'required',
        ]);

        RiwayatOrganisasi::create([
            'nama' => $request->nama,
            'jabatan' => $request->jabatan,
            'tahun_mulai' => $request->tahun_mulai,
            'tahun_selesai' => $request->tahun_selesai,
            'keterangan' => $request->keterangan,
            'pegawai_id' => $request->pegawai_id
        ]);

        return redirect()->back()->with(['success' => 'Data Riwayat Organisasi Baru berhasil Disimpan']);
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
        $organisasi = RiwayatOrganisasi::findOrFail($id);
        return response()->json($organisasi);
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
            'nama'         => 'required|string|max:255',
            'jabatan'         => 'required|string|max:255',
            'tahun_mulai'         => 'required',
        ]);

        $organisasi = RiwayatOrganisasi::findOrFail($id);

        $organisasi->update([
            'nama' => $request->nama,
            'jabatan' => $request->jabatan,
            'tahun_mulai' => $request->tahun_mulai,
            'tahun_selesai' => $request->tahun_selesai,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->back()->with(['success' => 'Data Riwayat Organisasi berhasil Disimpan']);
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        $organisasi = RiwayatOrganisasi::findOrFail($id);
        if ($organisasi) {
            $organisasi->delete();

            return redirect()->back()->with('success', 'Data Organisasi berhasil dihapus.');
        } else {
            return redirect()->back()->with('error', 'Riwayat Organisasi tidak ditemukan.');
        }
    }
}
