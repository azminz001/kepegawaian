<?php

namespace Modules\Kepegawaian\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use Modules\Kepegawaian\Entities\Jabatan;


class JabatanController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $cari = request('cari');
        if(!empty($cari)){
            $jabatans = Jabatan::where('nama', 'like',"%".$cari."%")->latest()->paginate(100);
            $jabatan_count = Jabatan::where('nama', 'like',"%".$cari."%")->count();
        }else{
            $jabatans = Jabatan::latest()->paginate(15);
            $jabatan_count = Jabatan::count();
        }

        return view('kepegawaian.jabatan.index', compact('jabatans', 'jabatan_count'));

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

        // dd($request);

        Jabatan::create([
            'nama'     => $request->nama,
            'status_kesehatan'     => $request->status_kesehatan,
            'status_medis'     => $request->status_medis,
            'status_perawatan'     => $request->status_perawatan,
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
        return view('kepegawaian::show');
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

        $jabatan = Jabatan::findOrFail($id);

        $jabatan->update([
            'nama'     => $request->nama,
            'status_kesehatan'     => $request->status_kesehatan,
            'status_medis'     => $request->status_medis,
            'status_perawatan'     => $request->status_perawatan,
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
        $jabatan = Jabatan::find($id);
        
        if ($jabatan) {
            $jabatan->delete();

            return redirect()->back()->with('success', 'Unit berhasil dihapus.');
        } else {
            return redirect()->back()->with('error', 'Unit tidak ditemukan.');
        }
    }

    public function getJabatans()
    {
        $jabatan = Jabatan::all();
        return response()->json($jabatan);
    }

    public function detailJabatan($id)
    {
        $detail_jabatan = Jabatan::findOrFail($id);
        return response()->json($detail_jabatan);

    }
}
