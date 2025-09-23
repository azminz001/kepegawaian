<?php

namespace Modules\Kepegawaian\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use Modules\Kepegawaian\Entities\JabatanUnit;
use Modules\Kepegawaian\Entities\JenisJabatan;


class JabatanUnitController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        
        $cari = request('cari');
        if(!empty($cari)){
            $jabatan_units = JabatanUnit::with(['jenis_jabatan'])->where('nama', 'like',"%".$cari."%")->latest()->paginate(100);
            $jabatan_unit_count = JabatanUnit::where('nama', 'like',"%".$cari."%")->count();
        }else{
            $jabatan_units = JabatanUnit::with(['jenis_jabatan'])->latest()->paginate(15);
            $jabatan_unit_count = JabatanUnit::count();
        }


        $jenis_jabatans = JenisJabatan::get();

        return view('kepegawaian.jabatanunit.index', compact('jabatan_units', 'jenis_jabatans', 'jabatan_unit_count'));
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

        JabatanUnit::create([
            'nama'     => $request->nama,
            'jenis_jabatan_id'     => $request->jenis_jabatan_id,
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

        $unit = JabatanUnit::findOrFail($id);

        $unit->update([
            'nama'     => $request->nama,
            'jenis_jabatan_id'     => $request->jenis_jabatan_id,
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
        $unit = JabatanUnit::find($id);
        
        if ($unit) {
            $unit->delete();

            return redirect()->back()->with('success', 'Unit berhasil dihapus.');
        } else {
            return redirect()->back()->with('error', 'Unit tidak ditemukan.');
        }
    }

    public function getJabatanUnits()
    {
        $jabatan_units = JabatanUnit::all();
        return response()->json($jabatan_units);
    }
}
