<?php

namespace Modules\Persuratan\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Database\QueryException;

use Modules\Persuratan\Entities\Suket;
use Modules\Persuratan\Entities\Klasifikasi;

class SuratKeteranganController extends Controller
{
    public function index()
    {
        $keyword = request('cari'); // Ambil keyword dari input "cari"

        $klasifikasi = Klasifikasi::all();

        $SuketQuery = Suket::join('klasifikasi', 'surat_keterangan.id_klasifikasi', '=', 'klasifikasi.id')
            ->select('surat_keterangan.*', 'klasifikasi.*')
            ->orderBy('kode', 'asc');

        if ($keyword) {
            $SuketQuery->where('klasifikasi.kode', 'like', '%' . $keyword . '%')
                ->orWhere('nama_suket', 'like', '%' . $keyword . '%')
                ->orWhere('keperluan', 'like', '%' . $keyword . '%')
                ->orderBy('kode', 'asc');
        }

        $suket = $SuketQuery->paginate(10);

        return view('Persuratan::surat_keterangan.index', compact('suket', 'klasifikasi'));
    }

    public function store(Request $request)
    {

        // Cek apakah sudah surat keterangan dengan kombinasi yang sama
        $sudahAda = Suket::where('id_klasifikasi', $request->id_klasifikasi)
            ->where('keperluan', strtoupper($request->keperluan))
            ->exists();

        if ($sudahAda) {
            return redirect()->back()->with('error', 'Data sudah ada');
        }

        Suket::create([
            'id_suket'       => $request->id_suket,
            'id_klasifikasi' => $request->id_klasifikasi,
            'nama_suket'     => strtoupper($request->nama_suket),
            'isi'            => $request->isi,
            'keperluan'      => strtoupper($request->keperluan)
        ]);

        return redirect()->back()->with('success', 'Data surat ditambahkan');
    }

    public function destroy($id)
    {
        try {
            $suket = Suket::find($id);
            $suket->delete();

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
        $suket = Suket::findOrFail($id);

        $suket->update([
            'id_klasifikasi' => $request->id_klasifikasi,
            'nama_suket'     => strtoupper($request->nama_suket),
            'isi'            => $request->isi_suket,
            'keperluan'      => strtoupper($request->keperluan)
        ]);

        return redirect()->back()->with(['success' => 'Data Berhasil Diubah!']);
    }
}
