<?php

namespace Modules\Kepegawaian\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Kepegawaian\Entities\RiwayatGajiBerkala;

class RiwayatGajiBerkalaController extends Controller
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
            'no_surat'               => 'required|string|max:255',
            'tanggal_surat'              => 'required|date|',
            'gaji_pokok_lama'          => 'required|int',
            'gaji_pokok_baru'              => 'required|int',
            'tanggal_mulai_berlaku'             => 'required|date',
        ]);

        // dd($request);
        
        if ($request->hasFile('dokumen_gaji')) {
            $dokumen_gaji = $request->file('dokumen_gaji');
            $nama_file = $dokumen_gaji->getClientOriginalName(); // Menggunakan nama file asli untuk menyimpan file
            if ($dokumen_gaji->getSize() > 2097152) {
                $ukuran = 2097152 / 1024 / 1024;
                return redirect()->back()->with(['error' =>'Ukuran File terlalu besar. Pastikan File tidak lebih dari '.$ukuran.' MB']);
            }
    
            // Simpan file ke direktori
            $dokumen_gaji->storeAs('public/dokumen_pegawai/'.$request->pegawai_id.'/', $nama_file);
    
            // Update data pegawai dengan nama file yang baru
            $store_gaji = RiwayatGajiBerkala::create([
                'no_surat' => $request->no_surat,
                'tanggal_surat' => $request->tanggal_surat,
                'gaji_pokok_lama' => $request->gaji_pokok_lama,
                'gaji_pokok_baru' => $request->gaji_pokok_baru,
                'tanggal_mulai_berlaku' => $request->tanggal_mulai_berlaku,
                'is_gaji_terakhir' => (int)$request->is_gaji_terakhir,
                'pegawai_id' => $request->pegawai_id,
                'dokumen_gaji' => $nama_file
            ]);
    
            return redirect()->back()->with(['success' => 'Data Riwayat Gaji Berkala Berhasil Disimpan']);
        } else {
            RiwayatGajiBerkala::create([
                'no_surat' => $request->no_surat,
                'tanggal_surat' => $request->tanggal_surat,
                'gaji_pokok_lama' => $request->gaji_pokok_lama,
                'gaji_pokok_baru' => $request->gaji_pokok_baru,
                'tanggal_mulai_berlaku' => $request->tanggal_mulai_berlaku,
                'is_gaji_terakhir' => $request->is_gaji_terakhir,
                'pegawai_id' => $request->pegawai_id,
            ]);
    
            return redirect()->back()->with(['success' => 'Data Riwayat Gaji Berkala Berhasil Disimpan']);
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
        $riwayat_gaji = RiwayatGajiBerkala::findOrFail($id);
        return response()->json($riwayat_gaji);
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
            'no_surat'               => 'required|string|max:255',
            'tanggal_surat'              => 'required|date|',
            'gaji_pokok_lama'          => 'required|int',
            'gaji_pokok_baru'              => 'required|int',
            'tanggal_mulai_berlaku'             => 'required|date',
        ]);

        $riwayat_gaji = RiwayatGajiBerkala::findOrFail($id);

        if ($request->hasFile('dokumen_gaji')) {
            
            $dokumen_gaji = $request->file('dokumen_gaji');
            $nama_file = $dokumen_gaji->getClientOriginalName(); // Menggunakan nama file asli untuk menyimpan file
            if ($dokumen_gaji->getSize() > 2097152) {
                $ukuran = 2097152 / 1024 / 1024;
                return redirect()->back()->with(['error' =>'Ukuran File terlalu besar. Pastikan File tidak lebih dari '.$ukuran.' MB']);
            }
            \Storage::delete('public/dokumen_pegawai/'.$riwayat_diklat->pegawai_id . '/' . $riwayat_diklat->dokumen_gaji);
    
            // Simpan file ke direktori
            $dokumen_gaji->storeAs('public/dokumen_pegawai/'.$request->pegawai_id.'/', $nama_file);
    
            // Update data pegawai dengan nama file yang baru
            $riwayat_gaji->update([
                'no_surat' => $request->no_surat,
                'tanggal_surat' => $request->tanggal_surat,
                'gaji_pokok_lama' => $request->gaji_pokok_lama,
                'gaji_pokok_baru' => $request->gaji_pokok_baru,
                'tanggal_mulai_berlaku' => $request->tanggal_mulai_berlaku,
                'is_gaji_terakhir' => $request->is_gaji_terakhir,
                'pegawai_id' => $request->pegawai_id,
                'dokumen_gaji' => $nama_file
            ]);

            return redirect()->back()->with(['success' => 'Data Riwayat Gaji Berkala Berhasil Disimpan']);
        } else {
            $riwayat_gaji->update([
                'no_surat' => $request->no_surat,
                'tanggal_surat' => $request->tanggal_surat,
                'gaji_pokok_lama' => $request->gaji_pokok_lama,
                'gaji_pokok_baru' => $request->gaji_pokok_baru,
                'tanggal_mulai_berlaku' => $request->tanggal_mulai_berlaku,
                'is_gaji_terakhir' => $request->is_gaji_terakhir,
                'pegawai_id' => $request->pegawai_id,
            ]);

            return redirect()->back()->with(['success' => 'Data Riwayat Gaji Berkala Berhasil Disimpan']);
        }

    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        $riwayat_gaji = RiwayatGajiBerkala::find($id);
        
        if ($riwayat_gaji) {
            $riwayat_gaji->delete();

            return redirect()->back()->with('success', 'Data Riwayat Gaji Berkala berhasil dihapus.');
        } else {
            return redirect()->back()->with('error', 'Riwayat Gaji Berkala tidak ditemukan.');
        }
    }
}
