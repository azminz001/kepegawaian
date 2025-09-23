<?php

namespace Modules\Kepegawaian\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use Modules\Kepegawaian\Entities\RiwayatPendidikan;


class RiwayatPendidikanController extends Controller
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
            'nomor_ijazah'         => 'required|string|max:255',
            'tanggal_lulus'    => 'required|date',
            'tahun_lulus'   => 'required',
            'nama_sekolah_pt'         => 'required|string|max:255',
        ]);
        
        if ($request->hasFile('dokumen_ijazah') || $request->hasFile('dokumen_nilai')) {
            $nama_file_ijazah = null;
            $nama_file_nilai = null;
    

            if ($request->hasFile('dokumen_ijazah')) {
                $dokumen_ijazah = $request->file('dokumen_ijazah');
                if ($dokumen_ijazah->getSize() > 2097152) {
                    $ukuran = 2097152 / 1024 / 1024;
                    return redirect()->back()->with(['error' => 'Ukuran File Ijazah terlalu besar. Pastikan File tidak lebih dari ' . $ukuran . ' MB']);
                }
                $nama_file_ijazah = $dokumen_ijazah->getClientOriginalName();
                $dokumen_ijazah->storeAs('public/dokumen_pegawai/' . $request->pegawai_id . '/', $nama_file_ijazah);
            }
        
            if ($request->hasFile('dokumen_nilai')) {
                $dokumen_nilai = $request->file('dokumen_nilai');
                if ($dokumen_nilai->getSize() > 2097152) {
                    $ukuran = 2097152 / 1024 / 1024;
                    return redirect()->back()->with(['error' => 'Ukuran File Nilai terlalu besar. Pastikan File tidak lebih dari ' . $ukuran . ' MB']);
                }
                $nama_file_nilai = $dokumen_nilai->getClientOriginalName();
                $dokumen_nilai->storeAs('public/dokumen_pegawai/' . $request->pegawai_id . '/', $nama_file_nilai);
            }
        
            // Insert data riwayat pendidikan
            RiwayatPendidikan::create([
                'nomor_ijazah' => $request->nomor_ijazah,
                'tanggal_lulus' => $request->tanggal_lulus,
                'tahun_lulus' => $request->tahun_lulus,
                'gelar_depan' => $request->gelar_depan,
                'gelar_belakang' => $request->gelar_belakang,
                'nama_sekolah_pt' => $request->nama_sekolah_pt,
                'jurusan' => $request->jurusan,
                'kepala' => $request->kepala,
                'pegawai_id' => $request->pegawai_id,
                'jenjang_pendidikan_id' => $request->jenjang_pendidikan_id,
                'is_pendidikan_terakhir' => $request->is_pendidikan_terakhir,
                'dokumen_ijazah' => $nama_file_ijazah,
                'dokumen_nilai' => $nama_file_nilai
            ]);
        
            return redirect()->back()->with(['success' => 'Data Riwayat Pendidikan Berhasil Disimpan']);
        } else {
            RiwayatPendidikan::create([
                'nomor_ijazah' => $request->nomor_ijazah,
                'tanggal_lulus' => $request->tanggal_lulus,
                'tahun_lulus' => $request->tahun_lulus,
                'gelar_depan' => $request->gelar_depan,
                'gelar_belakang' => $request->gelar_belakang,
                'nama_sekolah_pt' => $request->nama_sekolah_pt,
                'jurusan' => $request->jurusan,
                'kepala' => $request->kepala,
                'pegawai_id' => $request->pegawai_id,
                'jenjang_pendidikan_id' => $request->jenjang_pendidikan_id,
                'is_pendidikan_terakhir' => $request->is_pendidikan_terakhir,
            ]);
        
            return redirect()->back()->with(['success' => 'Data Riwayat Pendidikan Berhasil Disimpan']);
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
        $riwayat_pendidikan = RiwayatPendidikan::findOrFail($id);
        return response()->json($riwayat_pendidikan);
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
            'nomor_ijazah'         => 'required|string|max:255',
            'tanggal_lulus'    => 'required|date',
            'tahun_lulus'   => 'required',
            'nama_sekolah_pt'         => 'required|string|max:255',
        ]);

        $riwayat_pendidikan = RiwayatPendidikan::findOrFail($id);


        if ($request->hasFile('dokumen_ijazah') || $request->hasFile('dokumen_nilai')) {
            $nama_file_ijazah = null;
            $nama_file_nilai = null;
        
            if ($request->hasFile('dokumen_ijazah')) {
                $dokumen_ijazah = $request->file('dokumen_ijazah');
                if ($dokumen_ijazah->getSize() > 2097152) {
                    $ukuran = 2097152 / 1024 / 1024;
                    return redirect()->back()->with(['error' => 'Ukuran File Ijazah terlalu besar. Pastikan File tidak lebih dari ' . $ukuran . ' MB']);
                }
                $nama_file_ijazah = $dokumen_ijazah->getClientOriginalName();
                $dokumen_ijazah->storeAs('public/dokumen_pegawai/' . $request->pegawai_id . '/', $nama_file_ijazah);
            }
        
            if ($request->hasFile('dokumen_nilai')) {
                $dokumen_nilai = $request->file('dokumen_nilai');
                if ($dokumen_nilai->getSize() > 2097152) {
                    $ukuran = 2097152 / 1024 / 1024;
                    return redirect()->back()->with(['error' => 'Ukuran File Nilai terlalu besar. Pastikan File tidak lebih dari ' . $ukuran . ' MB']);
                }
                $nama_file_nilai = $dokumen_nilai->getClientOriginalName();
                $dokumen_nilai->storeAs('public/dokumen_pegawai/' . $request->pegawai_id . '/', $nama_file_nilai);
            }
        
            // Update data pegawai dengan nama file yang baru
            $dataUpdate = [
                'nomor_ijazah' => $request->nomor_ijazah,
                'tanggal_lulus' => $request->tanggal_lulus,
                'tahun_lulus' => $request->tahun_lulus,
                'gelar_depan' => $request->gelar_depan,
                'gelar_belakang' => $request->gelar_belakang,
                'nama_sekolah_pt' => $request->nama_sekolah_pt,
                'jurusan' => $request->jurusan,
                'kepala' => $request->kepala,
                'pegawai_id' => $request->pegawai_id,
                'jenjang_pendidikan_id' => $request->jenjang_pendidikan_id,
                'is_pendidikan_terakhir' => $request->is_pendidikan_terakhir,
            ];
        
            if ($nama_file_ijazah) {
                $dataUpdate['dokumen_ijazah'] = $nama_file_ijazah;
            }
            if ($nama_file_nilai) {
                $dataUpdate['dokumen_nilai'] = $nama_file_nilai;
            }
        
            $riwayat_pendidikan->update($dataUpdate);
        
            return redirect()->back()->with(['success' => 'Data Riwayat Pendidikan Berhasil Disimpan']);
        } else {
            $riwayat_pendidikan->update([
                'nomor_ijazah' => $request->nomor_ijazah,
                'tanggal_lulus' => $request->tanggal_lulus,
                'tahun_lulus' => $request->tahun_lulus,
                'gelar_depan' => $request->gelar_depan,
                'gelar_belakang' => $request->gelar_belakang,
                'nama_sekolah_pt' => $request->nama_sekolah_pt,
                'jurusan' => $request->jurusan,
                'kepala' => $request->kepala,
                'pegawai_id' => $request->pegawai_id,
                'jenjang_pendidikan_id' => $request->jenjang_pendidikan_id,
                'is_pendidikan_terakhir' => $request->is_pendidikan_terakhir,
            ]);
        
            return redirect()->back()->with(['success' => 'Data Riwayat Pendidikan Berhasil Disimpan']);
        }
        
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        $riwayat_pendidikan = RiwayatPendidikan::find($id);
        
        if ($riwayat_pendidikan) {
            $riwayat_pendidikan->delete();

            return redirect()->back()->with('success', 'Data Pendidikan berhasil dihapus.');
        } else {
            return redirect()->back()->with('error', 'Pendidikan tidak ditemukan.');
        }
    }
}
