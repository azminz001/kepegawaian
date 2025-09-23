<?php

namespace Modules\Kepegawaian\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use Modules\Kepegawaian\Entities\KelJabatan;


class KelJabatanController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $kel_jabatans = KelJabatan::with('pegawai_aktif')->latest()->get();

        return view('kepegawaian.keljabatan.index', compact('kel_jabatans'));
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
            'nama'     => 'required|string|max:255',
        ]);

        KelJabatan::create([
            'nama'     => $request->nama,
        ]);

        return redirect()->back()->with('success', 'Data berhasil disimpan.');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        
        // Ambil data utama KelJabatan
        $kel_jabatan = KelJabatan::where('id', $id)->first();

        // Jika KelJabatan ditemukan, paginasi data pegawai_aktif
        if ($kel_jabatan) {
            $pegawais = $kel_jabatan->pegawai_aktif()->paginate(15); // Paginasi dengan 10 item per halaman
        } else {
            $pegawais = collect(); // Jika tidak ditemukan, kembalikan koleksi kosong
        }

        return view('kepegawaian.keljabatan.show', compact('kel_jabatan', 'pegawais'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('kepegawaian::edit');
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
            'nama' => 'required|string|max:255',
        ]);

        $kel_jabatan = KelJabatan::findOrFail($id);

        $kel_jabatan->update([
            'nama'     => $request->nama,
        ]);

        return redirect()->back()->with(['success' => 'Data Berhasil Diubah!']);
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        $kel_jabatan = KelJabatan::find($id);
        
        if ($kel_jabatan) {
            $kel_jabatan->delete();

            return redirect()->back()->with('success', 'Unit berhasil dihapus.');
        } else {
            return redirect()->back()->with('error', 'Unit tidak ditemukan.');
        }
    }
    
    public function getKelJabatans()
    {
        $kel_jabatan = KelJabatan::all();
        return response()->json($kel_jabatan);
    }
}
