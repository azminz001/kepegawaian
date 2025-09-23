<?php

namespace Modules\Sindikat\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Sindikat\Entities\PermohonanLitbang;
use Modules\Sindikat\Entities\PermohonanLitbangDetail;
use Modules\WhatsAppAPI\Http\Controllers\WhatsAppController;
use Illuminate\Support\Facades\Auth;

class PermohonanLitbangDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $data_permohonan_litbang = PermohonanLitbangDetail::with('pemohon')->latest()->paginate(10);

        return view('sindikat::litbang.index', compact('data_permohonan_litbang'));
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
        $id_pemohon = $request->permohonan_litbang_id;

        $pemohon = PermohonanLitbang::find($id_pemohon);
        // dd($request);
        if ($request->hasFile('file')) {
            $dokumen = $request->file('file');
            $nama_file = $dokumen->getClientOriginalName(); // Menggunakan nama file asli untuk menyimpan file
            if ($dokumen->getSize() > 5242880) {
                $ukuran = 5242880 / 1024 / 1024;
                return redirect()->back()->with(['error' =>'Ukuran File terlalu besar. Pastikan File tidak lebih dari '.$ukuran.' MB']);
            }
    
            // Simpan file ke direktori
            $dokumen->storeAs('public/sindikat/permohonan_litbang/'.$request->permohonan_litbang_id.'/', $nama_file);
    
            // Update data pegawai dengan nama file yang baru
            
            $store = PermohonanLitbangDetail::create([
                'judul_penelitian'     => strtoupper($request->judul_penelitian),
                'bidang_penelitian'     => $request->bidang_penelitian,
                'deskripsi_penelitian'   => $request->deskripsi_penelitian,
                'tanggal_mulai'   => $request->tanggal_mulai,
                'tanggal_selesai'   => $request->tanggal_selesai,
                'nama_pembimbing'   => $request->nama_pembimbing,
                'kontak_pembimbing'   => $request->kontak_pembimbing,
                'permohonan_litbang_id'   => $request->permohonan_litbang_id,
                'berkas_pendukung'   => $nama_file,
                'status_permohonan'   => 0
            ]);
            if ($store) {
            
                $whatsappController = new WhatsAppController();
                $jenis = 'permohonan_litbang';
                $noHp = '081902323330'; // Ganti dengan nomor tujuan yang sesuai
                $message = "Hi, Salam Sehat \n\nInformasi Sindikat\nKonfirmasi Pendaftaran Akun Permohonan Litbang a.n *".$pemohon->nama."* \nJudul Penelitian: *".strtoupper($request->judul_penelitian)."*.\nTerimakasih\n\n*RSUD Brebes*";
                
                $response = $whatsappController->sendWhatsAppMessage($jenis, $noHp, $message);
            }
    
            return redirect()->back()->with(['success' => 'Data Permohonan Penelitian atau Pengembangan berhasil diajukan']);
        } else {
            return redirect()->back()->with(['error' =>'Dokumen Permohonan Penelitian atau Pengembangan yang diunggah tidak ada']);
        }

    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('sindikat::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $proposal_penelitian = PermohonanLitbangDetail::with('pemohon')->findOrFail($id);
        return response()->json($proposal_penelitian);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        $proposal_penelitian = PermohonanLitbangDetail::with('pemohon')->findOrFail($id);

        if ($request->hasFile('file')) {
            $dokumen = $request->file('file');
            $nama_file = $dokumen->getClientOriginalName(); // Menggunakan nama file asli untuk menyimpan file
            if ($dokumen->getSize() > 5242880) {
                $ukuran = 5242880 / 1024 / 1024;
                return redirect()->back()->with(['error' =>'Ukuran File terlalu besar. Pastikan File tidak lebih dari '.$ukuran.' MB']);
            }
            \Storage::delete('public/sindikat/permohonan_litbang/'.$proposal_penelitian->permohonan_litbang_id. '/' . $proposal_penelitian->berkas_pendukung);
    
            // Simpan file ke direktori
            $dokumen->storeAs('public/sindikat/permohonan_litbang/'.$proposal_penelitian->permohonan_litbang_id.'/', $nama_file);
    
            // Update data pegawai dengan nama file yang baru
            
            $proposal_penelitian->update([
                'judul_penelitian'     => strtoupper($request->judul_penelitian),
                'bidang_penelitian'     => $request->bidang_penelitian,
                'deskripsi_penelitian'   => $request->deskripsi_penelitian,
                'tanggal_mulai'   => $request->tanggal_mulai,
                'tanggal_selesai'   => $request->tanggal_selesai,
                'nama_pembimbing'   => $request->nama_pembimbing,
                'kontak_pembimbing'   => $request->kontak_pembimbing,
                'berkas_pendukung'   => $nama_file,
            ]);
    
            return redirect()->back()->with(['success' => 'Data Permohonan Penelitian atau Pengembangan berhasil diperbaiki']);
        } else {
            if (Auth::user()->level == 0 || Auth::user()->level==4) {
                # code...
                // if ($request->status_permohonan == 1) {
                //     $status_permohonan = "Berkas Diterima";
                // }elseif ($request->status_permohonan == 2) {
                //     $status_permohonan = "Permohonan Dikoordinasikan";
                // }elseif ($request->status_permohonan == 3) {
                //     $status_permohonan = "Dalam Proses";
                // }elseif ($request->status_permohonan == 4) {
                //     $status_permohonan = "Permohonan Disetujui";
                // }elseif ($request->status_permohonan == 5) {
                //     $status_permohonan = "Permohonan Ditolak";
                // }
                
                $update = $proposal_penelitian->update([
                    'judul_penelitian'     => strtoupper($request->judul_penelitian),
                    'bidang_penelitian'     => $request->bidang_penelitian,
                    'deskripsi_penelitian'   => $request->deskripsi_penelitian,
                    'tanggal_mulai'   => $request->tanggal_mulai,
                    'tanggal_selesai'   => $request->tanggal_selesai,
                    'nama_pembimbing'   => $request->nama_pembimbing,
                    'kontak_pembimbing'   => $request->kontak_pembimbing,
                    'status_permohonan'   => $request->status_permohonan,
                ]);
                if ($update) {
                    $whatsappController = new WhatsAppController();
                    $jenis = 'permohonan_litbang';
                    $message = "Hi, Salam Sehat \n\nInformasi Sindikat\nKonfirmasi Perubahan Data Permohonan Pemohon a.n *".$proposal_penelitian->pemohon->nama."* \nJudul Penelitian: *".$proposal_penelitian->judul_penelitian."*. Periksa Status Penelitian Anda melalui aplikasi SINDIKAT.\nTerimakasih\n\n*RSUD Brebes*";
                    
                    $response = $whatsappController->sendWhatsAppMessage($jenis, $proposal_penelitian->pemohon->no_hp, $message);
                }

            }else{
                $proposal_penelitian->update([
                    'judul_penelitian'     => strtoupper($request->judul_penelitian),
                    'bidang_penelitian'     => $request->bidang_penelitian,
                    'deskripsi_penelitian'   => $request->deskripsi_penelitian,
                    'tanggal_mulai'   => $request->tanggal_mulai,
                    'tanggal_selesai'   => $request->tanggal_selesai,
                    'nama_pembimbing'   => $request->nama_pembimbing,
                    'kontak_pembimbing'   => $request->kontak_pembimbing,
                ]);
            }
    
            return redirect()->back()->with(['success' => 'Data Permohonan Penelitian atau Pengembangan berhasil diperbaiki']);
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        $proposal_penelitian = PermohonanLitbangDetail::find($id);
        
        if ($proposal_penelitian) {
            \Storage::delete('public/sindikat/permohonan_litbang/'.$proposal_penelitian->permohonan_litbang_id. '/' . $proposal_penelitian->berkas_pendukung);
            $proposal_penelitian->delete();

            return redirect()->back()->with('success', 'Data Permohonan Penelitan / Pengembangan berhasil dihapus.');
        } else {
            return redirect()->back()->with('error', 'Permohonan Penelitan / Pengembangan tidak ditemukan.');
        }
    }
}

