<?php

namespace Modules\Kepegawaian\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Kepegawaian\Entities\RiwayatDiklat;

class RiwayatDiklatController extends Controller
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
            'nama_diklat'               => 'required|string|max:255',
            'jenis_diklat'              => 'required|string|max:255',
            'nomor_sertifikat'          => 'required|string|max:255',
            'tahun_diklat'              => 'required|int',
            'tanggal_mulai'             => 'required|date',
        ]);

        // dd($request);

        if ($request->hasFile('dokumen_sertifikat')) {
            $dokumen_sertifikat = $request->file('dokumen_sertifikat');
            $nama_file = $dokumen_sertifikat->getClientOriginalName(); // Menggunakan nama file asli untuk menyimpan file
            if ($dokumen_sertifikat->getSize() > 2097152) {
                $ukuran = 2097152 / 1024 / 1024;
                return redirect()->back()->with(['error' =>'Ukuran File terlalu besar. Pastikan File tidak lebih dari '.$ukuran.' MB']);
            }
    
            // Simpan file ke direktori
            $dokumen_sertifikat->storeAs('public/dokumen_pegawai/'.$request->pegawai_id.'/', $nama_file);
    
            // Update data pegawai dengan nama file yang baru
            RiwayatDiklat::create([
                'nama_diklat' => $request->nama_diklat,
                'jenis_diklat' => $request->jenis_diklat,
                'institusi_penyelenggara' => $request->institusi_penyelenggara,
                'nomor_sertifikat' => $request->nomor_sertifikat,
                'tahun_diklat' => $request->tahun_diklat,
                'tanggal_mulai' => $request->tanggal_mulai,
                'tanggal_selesai' => $request->tanggal_selesai,
                'tempat' => $request->tempat,
                'masa_berlaku' => $request->masa_berlaku,
                'durasi' => $request->durasi,
                'pegawai_id' => $request->pegawai_id,
                'dokumen_sertifikat' => $nama_file
            ]);
    
            return redirect()->back()->with(['success' => 'Data Riwayat Diklat Berhasil Disimpan']);
        } else {
            RiwayatDiklat::create([
                'nama_diklat' => $request->nama_diklat,
                'jenis_diklat' => $request->jenis_diklat,
                'institusi_penyelenggara' => $request->institusi_penyelenggara,
                'nomor_sertifikat' => $request->nomor_sertifikat,
                'tahun_diklat' => $request->tahun_diklat,
                'tanggal_mulai' => $request->tanggal_mulai,
                'tanggal_selesai' => $request->tanggal_selesai,
                'tempat' => $request->tempat,
                'masa_berlaku' => $request->masa_berlaku,
                'durasi' => $request->durasi,
                'pegawai_id' => $request->pegawai_id
            ]);
    
            return redirect()->back()->with(['success' => 'Data Riwayat Diklat Berhasil Disimpan']);
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
        $riwayat_diklat = RiwayatDiklat::findOrFail($id);
        return response()->json($riwayat_diklat);
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
            'nama_diklat'               => 'required|string|max:255',
            'jenis_diklat'              => 'required|string|max:255',
            'nomor_sertifikat'          => 'required|string|max:255',
            'tahun_diklat'              => 'required|int',
            'tanggal_mulai'             => 'required|date',
        ]);

        $riwayat_diklat = RiwayatDiklat::findOrFail($id);

        if ($request->hasFile('dokumen_sertifikat')) {
            
            $dokumen_sertifikat = $request->file('dokumen_sertifikat');
            $nama_file = $dokumen_sertifikat->getClientOriginalName(); // Menggunakan nama file asli untuk menyimpan file
            if ($dokumen_sertifikat->getSize() > 2097152) {
                $ukuran = 2097152 / 1024 / 1024;
                return redirect()->back()->with(['error' =>'Ukuran File terlalu besar. Pastikan File tidak lebih dari '.$ukuran.' MB']);
            }
            \Storage::delete('public/dokumen_pegawai/'.$riwayat_diklat->pegawai_id . '/' . $riwayat_diklat->dokumen_sertifikat);
    
            // Simpan file ke direktori
            $dokumen_sertifikat->storeAs('public/dokumen_pegawai/'.$request->pegawai_id.'/', $nama_file);
    
            // Update data pegawai dengan nama file yang baru
            $riwayat_diklat->update([
                'nama_diklat' => $request->nama_diklat,
                'jenis_diklat' => $request->jenis_diklat,
                'institusi_penyelenggara' => $request->institusi_penyelenggara,
                'nomor_sertifikat' => $request->nomor_sertifikat,
                'tahun_diklat' => $request->tahun_diklat,
                'tanggal_mulai' => $request->tanggal_mulai,
                'tanggal_selesai' => $request->tanggal_selesai,
                'tempat' => $request->tempat,
                'masa_berlaku' => $request->masa_berlaku,
                'durasi' => $request->durasi,
                'dokumen_sertifikat' => $nama_file
            ]);

            return redirect()->back()->with(['success' => 'Data Riwayat Diklat Berhasil Disimpan']);
        } else {
            $riwayat_diklat->update([
                'nama_diklat' => $request->nama_diklat,
                'jenis_diklat' => $request->jenis_diklat,
                'institusi_penyelenggara' => $request->institusi_penyelenggara,
                'nomor_sertifikat' => $request->nomor_sertifikat,
                'tahun_diklat' => $request->tahun_diklat,
                'tanggal_mulai' => $request->tanggal_mulai,
                'tanggal_selesai' => $request->tanggal_selesai,
                'tempat' => $request->tempat,
                'masa_berlaku' => $request->masa_berlaku,
                'durasi' => $request->durasi,
            ]);

            return redirect()->back()->with(['success' => 'Data Riwayat Diklat Berhasil Disimpan']);
        }

    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        $riwayat_diklat = RiwayatDiklat::find($id);
        
        if ($riwayat_diklat) {
            $riwayat_diklat->delete();

            return redirect()->back()->with('success', 'Data Riwayat Diklat berhasil dihapus.');
        } else {
            return redirect()->back()->with('error', 'Riwayat Diklat tidak ditemukan.');
        }
    }
}
