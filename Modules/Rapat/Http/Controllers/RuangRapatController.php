<?php

namespace Modules\Rapat\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Database\QueryException;

use Modules\Rapat\Entities\RuangRapat;

class RuangRapatController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $cari = request('cari');
        if (!empty($cari)) {
            $ruang_rapat = RuangRapat::where('nama', 'like', "%" . $cari . "%")->orderBy('nama', 'asc')->paginate(10);
            $ruang_rapat_count = RuangRapat::where('nama', 'like', "%" . $cari . "%")->count();
        } else {
            $ruang_rapat = RuangRapat::orderBy('nama', 'asc')->paginate(10);
            $ruang_rapat_count = RuangRapat::count();
        }

        return view('rapat::master_ruangan.index', compact('ruang_rapat', 'ruang_rapat_count'));
    }

    public function store(Request $request)
    {
        RuangRapat::create([
            'nama'      => strtoupper($request->nama),
            'kapasitas' => $request->kapasitas
        ]);

        return redirect()->back()->with('success', 'Data berhasil disimpan.');
    }

    public function destroy($id)
    {
        try {
            $ruang_rapat = RuangRapat::find($id);
            $ruang_rapat->delete();

            return redirect()->back()->with('success', 'Ruangan rapat berhasil dihapus.');
        } catch (QueryException $e) {
            if ($e->getCode() === '23000') {
                return redirect()->back()->with('error', 'Data sedang digunakan.');
            }
            
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus data.');
        }
    }

    public function update(Request $request, $id)
    {
        $ruangan = RuangRapat::findOrFail($id);

        $ruangan->update([
            'nama'      => strtoupper($request->nama),
            'kapasitas' => $request->kapasitas
        ]);

        return redirect()->back()->with(['success' => 'Data Berhasil Diubah!']);
    }
}
