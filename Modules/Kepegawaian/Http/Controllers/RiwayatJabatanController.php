<?php

namespace Modules\Kepegawaian\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use Modules\Kepegawaian\Entities\RiwayatJabatan;

class RiwayatJabatanController extends Controller
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
            'no_sk'         => 'required|string|max:255',
            'tanggal_sk'    => 'required|date',
            'tmt_jabatan'   => 'required|date',
        ]);
        
        $gaji = (int)str_replace(['Rp', '.', ','], '', $request->gaji);
        $gaji = substr($gaji, 0, -2);
        


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
            RiwayatJabatan::create([
                'no_sk' => $request->no_sk,
                'tanggal_sk' => $request->tanggal_sk,
                'tmt_jabatan' => $request->tmt_jabatan,
                'gaji' => $gaji,
                'kel_jabatan_id' => $request->kel_jabatan_id,
                'jabatan_id' => $request->jabatan_id,
                'pegawai_id' => $request->pegawai_id,
                'eselon_id' => $request->eselon_id,
                'is_jabatan_terakhir' => $request->is_jabatan_terakhir,
                'dokumen_sk' => $nama_file
            ]);
    
            return redirect()->back()->with(['success' => 'Data Riwayat Jabatan Berhasil Disimpan']);
        } else {
            RiwayatJabatan::create([
                'no_sk' => $request->no_sk,
                'tanggal_sk' => $request->tanggal_sk,
                'tmt_jabatan' => $request->tmt_jabatan,
                'gaji' => $gaji,
                'kel_jabatan_id' => $request->kel_jabatan_id,
                'jabatan_id' => $request->jabatan_id,
                'pegawai_id' => $request->pegawai_id,
                'eselon_id' => $request->eselon_id,
                'is_jabatan_terakhir' => $request->is_jabatan_terakhir
            ]);
            return redirect()->back()->with(['success' => 'Data Riwayat Jabatan Berhasil Disimpan']);
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
        $riwayat_jabatan = RiwayatJabatan::findOrFail($id);
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
            'no_sk'         => 'required|string|max:255',
            'tanggal_sk'    => 'required|date',
            'tmt_jabatan'   => 'required|date',
        ]);

        $riwayat_jabatan = RiwayatJabatan::findOrFail($id);

        $gaji = str_replace(['Rp', '.', ','], '', $request->gaji);

        $gaji = substr($gaji, 0, -2);
        
        if ($request->hasFile('dokumen_sk')) {
            
            $dokumen_sk = $request->file('dokumen_sk');
            $nama_file = $dokumen_sk->getClientOriginalName(); // Menggunakan nama file asli untuk menyimpan file
            if ($dokumen_sk->getSize() > 2097152) {
                $ukuran = 2097152 / 1024 / 1024;
                return redirect()->back()->with(['error' =>'Ukuran File terlalu besar. Pastikan File tidak lebih dari '.$ukuran.' MB']);
            }
            \Storage::delete('public/dokumen_pegawai/'.$riwayat_jabatan->pegawai_id . '/' . $riwayat_jabatan->dokumen_sk);
    
            // Simpan file ke direktori
            $dokumen_sk->storeAs('public/dokumen_pegawai/'.$request->pegawai_id.'/', $nama_file);
    
            // Update data pegawai dengan nama file yang baru
            $riwayat_jabatan->update([
                'no_sk' => $request->no_sk,
                'tanggal_sk' => $request->tanggal_sk,
                'tmt_jabatan' => $request->tmt_jabatan,
                'gaji' => $gaji,
                'kel_jabatan_id' => $request->kel_jabatan_id,
                'jabatan_id' => $request->jabatan_id,
                'pegawai_id' => $request->pegawai_id,
                'eselon_id' => $request->eselon_id,
                'is_jabatan_terakhir' => $request->is_jabatan_terakhir,
                'dokumen_sk' => $nama_file
            ]);
    
            return redirect()->back()->with(['success' => 'Data Riwayat Jabatan Berhasil Disimpan']);
        } else {
            $riwayat_jabatan->update([
                'no_sk' => $request->no_sk,
                'tanggal_sk' => $request->tanggal_sk,
                'tmt_jabatan' => $request->tmt_jabatan,
                'gaji' => $gaji,
                'kel_jabatan_id' => $request->kel_jabatan_id,
                'jabatan_id' => $request->jabatan_id,
                'pegawai_id' => $request->pegawai_id,
                'eselon_id' => $request->eselon_id,
                'is_jabatan_terakhir' => $request->is_jabatan_terakhir
            ]);
            return redirect()->back()->with(['success' => 'Data Riwayat Jabatan Berhasil Disimpan']);
        }

        return redirect()->back()->with(['success' => 'Data Riwayat Jabatan Berhasil Disimpan']);
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        $riwayat_jabatan = RiwayatJabatan::find($id);
        
        if ($riwayat_jabatan) {
            \Storage::delete('public/dokumen_pegawai/'.$riwayat_jabatan->pegawai_id . '/' . $riwayat_jabatan->dokumen_sk);
            $riwayat_jabatan->delete();

            return redirect()->back()->with('success', 'Data Riwayat Jabatan Pegawai berhasil dihapus.');
        } else {
            return redirect()->back()->with('error', 'Riwayat Jabatan Pegawai tidak ditemukan.');
        }
    }
}
