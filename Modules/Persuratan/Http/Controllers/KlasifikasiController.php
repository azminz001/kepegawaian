<?php

namespace Modules\Persuratan\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use Modules\Persuratan\Entities\Klasifikasi;

class KlasifikasiController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $cari = request('cari');
        if(!empty($cari)){
            $klasifikasi = Klasifikasi::where('kode', 'like',"%".$cari."%")->orWhere('nama', 'like', "%".$cari."%")->latest()->paginate(100);
            $klasifikasi_count = Klasifikasi::where('kode', 'like',"%".$cari."%")->orWhere('nama', 'like', "%".$cari."%")->count();
        }else{
            $klasifikasi = Klasifikasi::latest()->paginate(15);
            $klasifikasi_count = Klasifikasi::count();
        }

        return view('Persuratan::klasifikasi.index', compact('klasifikasi', 'klasifikasi_count'));
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
        
        Klasifikasi::create([
            'kode'     => $request->kode,
            'nama'     => $request->nama,
        ]);

        return redirect()->back()->with('success', 'Data berhasil disimpan.');
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

        $klasifikasi = Klasifikasi::findOrFail($id);

        $klasifikasi->update([
            'kode'     => $request->kode,
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
        $klasifikasi = Klasifikasi::find($id);
        
        if ($klasifikasi) {
            $klasifikasi->delete();

            return redirect()->back()->with('success', 'Klasifikasi berhasil dihapus.');
        } else {
            return redirect()->back()->with('error', 'Klasifikasi tidak ditemukan.');
        }
    }

    public function getKlasifikasis()
    {
        $klasifikasi = Klasifikasi::all();
        return response()->json($klasifikasi);
    }
}