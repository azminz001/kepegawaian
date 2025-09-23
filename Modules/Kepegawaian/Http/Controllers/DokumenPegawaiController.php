<?php

namespace Modules\Kepegawaian\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;


use Modules\Kepegawaian\Entities\DokumenPegawai;



class DokumenPegawaiController extends Controller
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
            'nama'               => 'required|string|max:255',
            'file'              => 'required',
        ]);

        // dd($request);

        $dokumen = $request->file('file');
        $nama_file = $dokumen->getClientOriginalName(); // Menggunakan nama file asli untuk menyimpan file
        if ($dokumen->getSize() > 2097152) {
            $ukuran = 2097152 / 1024 / 1024;
            return redirect()->back()->with(['error' =>'Ukuran File terlalu besar. Pastikan File tidak lebih dari '.$ukuran.' MB']);
        }

        // Simpan file ke direktori
        $dokumen->storeAs('public/dokumen_pegawai/'.$request->pegawai_id.'/', $nama_file);

        // Update data pegawai dengan nama file yang baru
        DokumenPegawai::create([
            'nama' => $request->nama,
            'file' => $nama_file,
            'pegawai_id' => $request->pegawai_id,
        ]);

        return redirect()->back()->with(['success' => 'Data Riwayat Diklat Berhasil Disimpan']);

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
        $dokumen = DokumenPegawai::findOrFail($id);
        return response()->json($dokumen);
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
        $dokumen = DokumenPegawai::find($id);
        
        if ($dokumen) {
            \Storage::delete('public/dokumen_pegawai/'.$dokumen->pegawai_id . '/' . $dokumen->file);
            $dokumen->delete();

            return redirect()->back()->with('success', 'Data Dokumen Pegawai berhasil dihapus.');
        } else {
            return redirect()->back()->with('error', 'Riwayat Dokumen tidak ditemukan.');
        }
    }
}
