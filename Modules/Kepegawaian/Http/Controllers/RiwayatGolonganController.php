<?php

namespace Modules\Kepegawaian\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Kepegawaian\Entities\RiwayatGolongan;


class RiwayatGolonganController extends Controller
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
            'sk_nomor'         => 'required|string|max:255',
            'tmt'    => 'required|date',
            'sk_tanggal'   => 'required|date',
        ]);

        if ($request->hasFile('dokumen_sk')) {
            $dokumen_sk = $request->file('dokumen_sk');
            $nama_file = $dokumen_sk->getClientOriginalName(); // Menggunakan nama file asli untuk menyimpan file
            if ($dokumen_sk->getSize() > 2097152) {
                $ukuran = 2097152 / 1024 / 1024;
                return redirect()->back()->with(['error' =>'Ukuran File terlalu besar. Pastikan File tidak lebih dari '.$ukuran.' MB']);
            }
    
            // Simpan file ke direktori
            $dokumen_sk->storeAs('public/dokumen_pegawai/'.$request->pegawai_id.'/', $nama_file);
    
            // Update data pegawai dengan nama file yang baru
            RiwayatGolongan::create([
                'no_surat_bkn' => $request->no_surat_bkn,
                'sk_nomor' => $request->sk_nomor,
                'tmt' => $request->tmt,
                'sk_tanggal' => $request->sk_tanggal,
                'golongan_id' => $request->golongan_id,
                'pegawai_id' => $request->pegawai_id,
                'is_golongan_terakhir' => $request->is_golongan_terakhir,
                'dokumen_sk' => $nama_file
            ]);
    
            return redirect()->back()->with(['success' => 'Data Riwayat Golongan Berhasil Disimpan']);
        } else {
            RiwayatGolongan::create([
                'no_surat_bkn' => $request->no_surat_bkn,
                'sk_nomor' => $request->sk_nomor,
                'tmt' => $request->tmt,
                'sk_tanggal' => $request->sk_tanggal,
                'golongan_id' => $request->golongan_id,
                'pegawai_id' => $request->pegawai_id,
                'is_golongan_terakhir' => $request->is_golongan_terakhir,
            ]);
            return redirect()->back()->with(['success' => 'Data Riwayat Golongan Berhasil Disimpan']);
        }
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
        $riwayat_golongan = RiwayatGolongan::findOrFail($id);
        return response()->json($riwayat_golongan);
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
            'sk_nomor'         => 'required|string|max:255',
            'tmt'    => 'required|date',
            'sk_tanggal'   => 'required|date',
        ]);

        $riwayat_golongan = RiwayatGolongan::findOrFail($id);

        if ($request->hasFile('dokumen_sk')) {
            $dokumen_sk = $request->file('dokumen_sk');
            $nama_file = $dokumen_sk->getClientOriginalName(); // Menggunakan nama file asli untuk menyimpan file
            if ($dokumen_sk->getSize() > 2097152) {
                $ukuran = 2097152 / 1024 / 1024;
                return redirect()->back()->with(['error' =>'Ukuran File terlalu besar. Pastikan File tidak lebih dari '.$ukuran.' MB']);
            }
    
            // Simpan file ke direktori
            $dokumen_sk->storeAs('public/dokumen_pegawai/'.$request->pegawai_id.'/', $nama_file);
    
            // Update data pegawai dengan nama file yang baru
            $riwayat_golongan->update([
                'no_surat_bkn' => $request->no_surat_bkn,
                'sk_nomor' => $request->sk_nomor,
                'tmt' => $request->tmt,
                'sk_tanggal' => $request->sk_tanggal,
                'pegawai_id' => $request->pegawai_id,
                'is_golongan_terakhir' => $request->is_golongan_terakhir,
                'dokumen_sk' => $nama_file
            ]);
    
            return redirect()->back()->with(['success' => 'Data Riwayat Golongan Berhasil Disimpan']);
        } else {
            $riwayat_golongan->update([
                'no_surat_bkn' => $request->no_surat_bkn,
                'sk_nomor' => $request->sk_nomor,
                'tmt' => $request->tmt,
                'sk_tanggal' => $request->sk_tanggal,
                'pegawai_id' => $request->pegawai_id,
                'is_golongan_terakhir' => $request->is_golongan_terakhir,
            ]);
            return redirect()->back()->with(['success' => 'Data Riwayat Golongan Berhasil Disimpan']);
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        $riwayat_golongan = RiwayatGolongan::find($id);
        
        if ($riwayat_golongan) {
            \Storage::delete('public/dokumen_pegawai/'.$riwayat_golongan->pegawai_id . '/' . $riwayat_golongan->dokumen_sk);
            $riwayat_golongan->delete();

            return redirect()->back()->with('success', 'Data Riwayat Golongan/Pangkat Pegawai berhasil dihapus.');
        } else {
            return redirect()->back()->with('error', 'Riwayat Golongan/Pangkat  Pegawai tidak ditemukan.');
        }
    }
}
