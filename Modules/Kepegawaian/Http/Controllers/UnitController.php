<?php

namespace Modules\Kepegawaian\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use Modules\Kepegawaian\Entities\Unit;

class UnitController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    // public function __construct()
    // {
    //     // Tidak memerlukan middleware auth
    //     $this->middleware('auth', ['except' => ['index']]);
    // }
    public function index()
    {
        $units = Unit::with('unit_jabatan_pegawai')->latest()->get();
        return view('kepegawaian.unit.index', compact('units'));
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
        //validate form
        // dd($request);
        $request->validate([
            'nama'     => 'required|string|max:255',
        ]);

        Unit::create([
            'nama'     => $request->nama,
            'keterangan'   => $request->keterangan
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
        // Ambil data utama Unit
        $unit = Unit::where('id', $id)->first();

        // Ambil data pegawai_aktif dengan pagination
        $pegawais = $unit->pegawai_aktif()->paginate(10); // Sesuaikan angka 10 dengan jumlah item per halaman yang diinginkan

        return view('kepegawaian.unit.show', compact('unit', 'pegawais'));
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

        $unit = Unit::findOrFail($id);

        $unit->update([
            'nama'     => $request->nama,
            'keterangan'     => $request->keterangan,
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
        $unit = Unit::find($id);
        
        if ($unit) {
            $unit->delete();

            return redirect()->back()->with('success', 'Unit berhasil dihapus.');
        } else {
            return redirect()->back()->with('error', 'Unit tidak ditemukan.');
        }
    }

    public function getUnits()
    {
        $units = Unit::all();
        return response()->json($units);
    }
}
