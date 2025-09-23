<?php

namespace Modules\Kepegawaian\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Kepegawaian\Entities\AnakPegawai;

class AnakPegawaiController extends Controller
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
            'nik'         => 'required|string|max:16',
            'no_bpjs'         => 'required|string|max:16',
            'tanggal_lahir'    => 'required|date',
        ]);

        AnakPegawai::create([
            'nama' => $request->nama,
            'jenis_kelamin' => $request->jenis_kelamin,
            'nik' => $request->nik,
            'no_bpjs' => $request->no_bpjs,
            'tanggal_lahir' => $request->tanggal_lahir,
            'pegawai_id' => $request->pegawai_id
        ]);

        return redirect()->back()->with(['success' => 'Data Anak Berhasil Disimpan']);
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
        $anak = AnakPegawai::findOrFail($id);
        return response()->json($anak);
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
            'nik'         => 'required|string|max:16',
            'no_bpjs'         => 'required|string|max:16',
            'tanggal_lahir'    => 'required|date',
        ]);

        $anak = AnakPegawai::findOrFail($id);


        $anak->update([
            'nama' => $request->nama,
            'jenis_kelamin' => $request->jenis_kelamin,
            'nik' => $request->nik,
            'no_bpjs' => $request->no_bpjs,
            'tanggal_lahir' => $request->tanggal_lahir,
            'pegawai_id' => $request->pegawai_id
        ]);

        return redirect()->back()->with(['success' => 'Data Anak Berhasil Disimpan']);
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        $anak = AnakPegawai::find($id);
        
        if ($anak) {
            $anak->delete();

            return redirect()->back()->with('success', 'Data AnakPegawai berhasil dihapus.');
        } else {
            return redirect()->back()->with('error', 'Riwayat Anak Pegawai tidak ditemukan.');
        }
    }
}
