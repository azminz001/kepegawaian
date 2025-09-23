<?php

namespace Modules\Kepegawaian\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Kepegawaian\Entities\PasanganPegawai;

class PasanganPegawaiController extends Controller
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
            'pekerjaan'         => 'required|string|max:255',
            'nik'         => 'required|string|max:16',
            'no_bpjs'         => 'required|string|max:16',
            'tanggal_lahir'    => 'required|date',
            'tanggal_nikah'   => 'required|date',
        ]);

        PasanganPegawai::create([
            'jenis' => $request->jenis,
            'nama' => $request->nama,
            'nik' => $request->nik,
            'no_bpjs' => $request->no_bpjs,
            'tanggal_lahir' => $request->tanggal_lahir,
            'tanggal_nikah' => $request->tanggal_nikah,
            'pekerjaan' => $request->pekerjaan,
            'status' => $request->status,
            'pegawai_id' => $request->pegawai_id
        ]);

        return redirect()->back()->with(['success' => 'Data Suami / Istri Berhasil Disimpan']);
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
        $pasangan = PasanganPegawai::findOrFail($id);
        return response()->json($pasangan);
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
            'pekerjaan'         => 'required|string|max:255',
            'nik'         => 'required|string|max:16',
            'no_bpjs'         => 'required|string|max:16',
            'tanggal_lahir'    => 'required|date',
            'tanggal_nikah'   => 'required|date',
        ]);

        $pasangan = PasanganPegawai::findOrFail($id);

        $pasangan->update([
            'jenis' => $request->jenis,
            'nama' => $request->nama,
            'nik' => $request->nik,
            'no_bpjs' => $request->no_bpjs,
            'tanggal_lahir' => $request->tanggal_lahir,
            'tanggal_nikah' => $request->tanggal_nikah,
            'pekerjaan' => $request->pekerjaan,
            'status' => $request->status,
            'pegawai_id' => $request->pegawai_id
        ]);

        return redirect()->back()->with(['success' => 'Data Suami / Istri Berhasil Disimpan']);
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        $pasangan = PasanganPegawai::find($id);
        
        if ($pasangan) {
            $pasangan->delete();

            return redirect()->back()->with('success', 'Data Suami / Istri Pegawai berhasil dihapus.');
        } else {
            return redirect()->back()->with('error', 'Riwayat Suami / Istri Pegawai tidak ditemukan.');
        }
    }
}
