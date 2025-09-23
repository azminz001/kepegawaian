<?php

namespace Modules\Kepegawaian\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Kepegawaian\Entities\RiwayatKaryaBuku;

class RiwayatBukuController extends Controller
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
            'isbn'         => 'required|string|max:255',
            'halaman'         => 'required|string|max:255',
            'penerbit'         => 'required|string|max:255',
        ]);

        RiwayatKaryaBuku::create([
            'judul' => $request->judul,
            'isbn' => $request->isbn,
            'halaman' => $request->halaman,
            'penerbit' => $request->penerbit,
            'link' => $request->link,
            'pegawai_id' => $request->pegawai_id
        ]);

        return redirect()->back()->with(['success' => 'Data Karya Buku Baru berhasil Disimpan']);
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
        $buku = RiwayatKaryaBuku::findOrFail($id);
        return response()->json($buku);
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
            'isbn'         => 'required|string|max:255',
            'halaman'         => 'required|string|max:255',
            'penerbit'         => 'required|string|max:255',
        ]);

        $buku = RiwayatKaryaBuku::findOrFail($id);

        $buku->update([
            'judul' => $request->judul,
            'isbn' => $request->isbn,
            'halaman' => $request->halaman,
            'penerbit' => $request->penerbit,
            'link' => $request->link,
            'pegawai_id' => $request->pegawai_id
        ]);

        return redirect()->back()->with(['success' => 'Data Karya Buku Baru berhasil Disimpan']);
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        $buku = RiwayatKaryaBuku::find($id);
        
        if ($buku) {
            $buku->delete();

            return redirect()->back()->with('success', 'Data Karya Buku berhasil dihapus.');
        } else {
            return redirect()->back()->with('error', 'Riwayat Karya Buku tidak ditemukan.');
        }
    }
}
