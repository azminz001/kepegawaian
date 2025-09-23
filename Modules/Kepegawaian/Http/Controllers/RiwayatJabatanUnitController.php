<?php

namespace Modules\Kepegawaian\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use Modules\Kepegawaian\Entities\RiwayatJabatanUnit;


class RiwayatJabatanUnitController extends Controller
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
            'tmt_jabatan_unit'   => 'required|date',
        ]);

        RiwayatJabatanUnit::create([
            'tmt_jabatan_unit' => $request->tmt_jabatan_unit,
            'unit_id' => $request->unit_id,
            'jabatan_unit_id' => $request->jabatan_unit_id,
            'pegawai_id' => $request->pegawai_id,
            'is_jabatan_terakhir' => $request->is_jabatan_terakhir
        ]);
        return redirect()->back()->with(['success' => 'Data Riwayat Jabatan Berhasil Disimpan']);
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
        $riwayat_jabatan = RiwayatJabatanUnit::findOrFail($id);
        return response()->json($riwayat_jabatan);
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
            'tmt_jabatan_unit'   => 'required|date',
        ]);

        $riwayat_jabatan = RiwayatJabatanUnit::findOrFail($id);


        $riwayat_jabatan->update([
            'tmt_jabatan_unit' => $request->tmt_jabatan_unit,
            'unit_id' => $request->unit_id,
            'jabatan_unit_id' => $request->jabatan_unit_id,
            'pegawai_id' => $request->pegawai_id,
            'is_jabatan_terakhir' => $request->is_jabatan_terakhir
        ]);
        return redirect()->back()->with(['success' => 'Data Riwayat Jabatan Berhasil Disimpan']);
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        $jabatan_unit = RiwayatJabatanUnit::find($id);
        
        if ($jabatan_unit) {
            $jabatan_unit->delete();

            return redirect()->back()->with('success', 'Data Pegawai berhasil dihapus.');
        } else {
            return redirect()->back()->with('error', 'Unit tidak ditemukan.');
        }
    }
}
