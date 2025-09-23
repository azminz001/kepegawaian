<?php

namespace Modules\Persuratan\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use Modules\Persuratan\Entities\UnitOrganisasi;

class UnitOrganisasiController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $cari = request('cari');
        if(!empty($cari)){
            $unors = UnitOrganisasi::where('nama', 'like',"%".$cari."%")->latest()->paginate(100);
            $unor_count= UnitOrganisasi::where('nama', 'like',"%".$cari."%")->count();
        }else{
            $unors = UnitOrganisasi::latest()->paginate(15);
            $unor_count = UnitOrganisasi::count();
        }

        return view('persuratan.unit_organisasi', compact('unors', 'unor_count'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('persuratan::create');
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

        UnitOrganisasi::create([
            'nama'     => $request->nama
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
        return view('persuratan::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('persuratan::edit');
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
            'nama'     => 'required|string|max:255',
        ]);

        $unor = UnitOrganisasi::findOrFail($id);

        $unor->update([
            'nama'     => $request->nama
        ]);

        return redirect()->back()->with('success', 'Data berhasil disimpan.');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        $unor = UnitOrganisasi::find($id);
        
        if ($unor) {
            $unor->delete();

            return redirect()->back()->with('success', 'Jenis Surat berhasil dihapus.');
        } else {
            return redirect()->back()->with('error', 'Jenis Surat tidak ditemukan.');
        }
    }
}
