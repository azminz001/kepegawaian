<?php

namespace Modules\Sindikat\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use Illuminate\Support\Facades\Auth;
use Modules\Kepegawaian\Entities\ProfilPegawai;
use Modules\Sindikat\Entities\PermohonanDiklatPegawai;
use Modules\Sindikat\Entities\PesertaPermohonanDiklat;

use Modules\WhatsAppAPI\Http\Controllers\WhatsAppController;

class PermohonanDiklatPegawaiController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $user = Auth::user();

        $pegawai = ProfilPegawai::with(['awal_kerja', 'unit_jabatan_aktif', 'jabatan_aktif'])->where('nip_nipppk_nrpk_nrpblud', $user->username)->first();

        if ($user->level == '0' || $user->level == '4') {
            $diklats = PermohonanDiklatPegawai::with(['pegawai' => function($q){
                return $q->with('unit_jabatan_aktif');
            }])->latest()->paginate(10);
        }else{
            $diklats = PermohonanDiklatPegawai::where('pegawai_id', $pegawai->id)->latest()->paginate(10);
        }

        $employees = ProfilPegawai::orderBy('nama', 'ASC')->get();

        // return view('sindikat::institusi.index', compact('institusis', 'institusi_count'));
        return view('sindikat::pegawai.permohonan_diklat', compact('pegawai', 'diklats', 'employees'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('sindikat::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {

        $user = Auth::user();

        $pegawai = ProfilPegawai::where('nip_nipppk_nrpk_nrpblud', $user->username)->first();

        $id_pegawai = 'f0d81756-12f8-4ce8-b9df-d48260610cf1';
        if ($pegawai) {
            $id_pegawai = $pegawai->id;
        }

        $request->validate([
            'nama_diklat'               => 'required|string|max:255',
            'tanggal_mulai'              => 'required|date|',
            'tanggal_selesai'          => 'required|date',
        ]);

        // dd($request);
        
        if ($request->hasFile('upload')) {
            $dokumen = $request->file('upload');
            $nama_file = $dokumen->getClientOriginalName(); // Menggunakan nama file asli untuk menyimpan file
            if ($dokumen->getSize() > 2097152) {
                $ukuran = 2097152 / 1024 / 1024;
                return redirect()->back()->with(['error' =>'Ukuran File terlalu besar. Pastikan File tidak lebih dari '.$ukuran.' MB']);
            }
    
            // Simpan file ke direktori
            $dokumen->storeAs('public/sindikat/permohonan_diklat/', $nama_file);
    
            // Update data pegawai dengan nama file yang baru
            $diklat = PermohonanDiklatPegawai::create([
                'nama_diklat' => $request->nama_diklat,
                'penyelenggara' => $request->penyelenggara,
                'tempat' => $request->tempat,
                'tipe' => (int)$request->tipe,
                'jenis' => (int)$request->jenis,
                'tanggal_mulai' => $request->tanggal_mulai,
                'tanggal_selesai' => $request->tanggal_selesai,
                'link' => $request->link,
                'catatan' => $request->catatan,
                'status' => 0,
                'upload' => $nama_file,
                'pegawai_id' => $id_pegawai
            ]);
            
            $pegawai_ids = $request->input('pegawai_id'); // Array of pegawai IDs
            if ($diklat) {
                $whatsappController = new WhatsAppController();
                $jenis = 'permohonan_diklat';
                // $noHp = '085707749997'; // Ganti dengan nomor tujuan yang sesuai
                $noHp = '081902323330'; // Ganti dengan nomor tujuan yang sesuai
                $message = "Hi, Salam Sehat \nInformasi Sindikat\nAda permohonan diklat baru dari pegawai a.n ".$user->name." dengan tema: ".$diklat->nama_diklat;
                
                $response = $whatsappController->sendWhatsAppMessage($jenis, $noHp, $message);

                foreach ($pegawai_ids as $pegawai_id) {
                    // Buat instance baru untuk tabel `pegawai_ci`
        
                    // dd($pegawai_id);
                    $pesertaDiklat = new PesertaPermohonanDiklat();
                    $pesertaDiklat->pegawai_id = $pegawai_id;
                    $pesertaDiklat->permohonan_diklat_id = $diklat->id;
                    $pesertaDiklat->save();
                }
            }
    
            return redirect()->back()->with(['success' => 'Data Permohonan Diklat berhasil diajukan']);
        } else {
            return redirect()->back()->with(['error' =>'Dokumen Permohonan Diklat yang diunggah tidak ada']);
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        $diklat = PermohonanDiklatPegawai::with('pegawai')->findOrFail($id);
        $employees = PesertaPermohonanDiklat::with(['pegawai' => function($q){
            return $q->with('unit_jabatan_aktif');
        }])->where('permohonan_diklat_id', $id)->get();

        return view('sindikat::pegawai.detail_permohonan_diklat', compact('diklat', 'employees'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $diklat = PermohonanDiklatPegawai::findOrFail($id);
        return response()->json($diklat);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {

        $user = Auth::user();

        $pegawai = ProfilPegawai::where('nip_nipppk_nrpk_nrpblud', $user->username)->first();

        $request->validate([
            'nama_diklat'               => 'required|string|max:255',
            'tanggal_mulai'              => 'required|date|',
            'tanggal_selesai'          => 'required|date',
        ]);

        $diklat = PermohonanDiklatPegawai::findOrFail($id);

        if ($request->hasFile('upload')) {
            
            $dokumen = $request->file('upload');
            $nama_file = $dokumen->getClientOriginalName(); // Menggunakan nama file asli untuk menyimpan file
            if ($dokumen->getSize() > 2097152) {
                $ukuran = 2097152 / 1024 / 1024;
                return redirect()->back()->with(['error' =>'Ukuran File terlalu besar. Pastikan File tidak lebih dari '.$ukuran.' MB']);
            }
            \Storage::delete('public/dokumen_pegawai/'.$pegawai->id.'/' . $diklat->upload);
    
            // Simpan file ke direktori
            $dokumen->storeAs('public/dokumen_pegawai/'.$pegawai->id.'/', $nama_file);
    
            // Update data pegawai dengan nama file yang baru
            $diklat->update([
                'nama_diklat' => $request->nama_diklat,
                'penyelenggara' => $request->penyelenggara,
                'tempat' => $request->tempat,
                'tipe' => (int)$request->tipe,
                'jenis' => (int)$request->jenis,
                'paid_status' => (int)$request->paid_status,
                'tanggal_mulai' => $request->tanggal_mulai,
                'tanggal_selesai' => $request->tanggal_selesai,
                'link' => $request->link,
                'catatan' => $request->catatan,
                'upload' => $nama_file,
                'pegawai_id' => $request->pegawai_id
            ]);

            return redirect()->back()->with(['success' => 'Data Permohonan Diklat Berhasil Disimpan']);
        } else {
            $diklat->update([
                'nama_diklat' => $request->nama_diklat,
                'penyelenggara' => $request->penyelenggara,
                'tempat' => $request->tempat,
                'tipe' => (int)$request->tipe,
                'jenis' => (int)$request->jenis,
                'paid_status' => (int)$request->paid_status,
                'tanggal_mulai' => $request->tanggal_mulai,
                'tanggal_selesai' => $request->tanggal_selesai,
                'link' => $request->link,
                'status' => $request->status,
                'catatan' => $request->catatan,
                'pegawai_id' => $request->pegawai_id
            ]);

            return redirect()->back()->with(['success' => 'Data Permohonan Diklat Berhasil Disimpan']);
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        $diklat = PermohonanDiklatPegawai::find($id);
        
        if ($diklat) {
            \Storage::delete('public/dokumen_pegawai/'.$diklat->pegawai_id.'/' . $diklat->upload);

            $diklat->delete();

            return redirect()->back()->with('success', 'Data Permohonan Magang berhasil dihapus.');
        } else {
            return redirect()->back()->with('error', 'Permohonan Magang tidak ditemukan.');
        }
    }
}
