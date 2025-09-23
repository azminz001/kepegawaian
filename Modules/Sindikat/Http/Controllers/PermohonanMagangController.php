<?php

namespace Modules\Sindikat\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use Modules\Sindikat\Entities\PermohonanMagang;
use Modules\Sindikat\Entities\Jurusan;
use Modules\Sindikat\Entities\PesertaDidik;
use Modules\WhatsAppAPI\Http\Controllers\WhatsAppController;



class PermohonanMagangController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {

        $permohonan_magangs = PermohonanMagang::with(['institusi', 'peserta_didik'])->latest()->paginate(15);

        // dd($permohonan_magangs);
        return view('sindikat::permohonan_magang.index', compact('permohonan_magangs'));

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
        $request->validate([
            'no_surat'               => 'required|string|max:255',
            'tanggal_surat'              => 'required|date|',
            'tanggal_mulai'          => 'required|date',
            'tanggal_selesai'              => 'required|date',
            'jumlah_peserta'             => 'required|int',
        ]);

        // dd($request);
        
        if ($request->hasFile('dokumen')) {
            $dokumen = $request->file('dokumen');
            $nama_file = $dokumen->getClientOriginalName(); // Menggunakan nama file asli untuk menyimpan file
            if ($dokumen->getSize() > 2097152) {
                $ukuran = 2097152 / 1024 / 1024;
                return redirect()->back()->with(['error' =>'Ukuran File terlalu besar. Pastikan File tidak lebih dari '.$ukuran.' MB']);
            }
    
            // Simpan file ke direktori
            $dokumen->storeAs('public/sindikat/permohonan_magang/'.$request->institusi_id.'/', $nama_file);
    
            // Update data pegawai dengan nama file yang baru
            $magang = PermohonanMagang::create([
                'no_surat' => $request->no_surat,
                'tanggal_surat' => $request->tanggal_surat,
                'tanggal_mulai' => $request->tanggal_mulai,
                'tanggal_selesai' => $request->tanggal_selesai,
                'jumlah_peserta' => (int)$request->jumlah_peserta,
                'institusi_id' => $request->institusi_id,
                'status' => 0,
                'dokumen' => $nama_file
            ]);

            if ($magang) {
            
            $whatsappController = new WhatsAppController();
            $jenis = 'permohonan_litbang';
            $noHp = env('WA_ADMIN_SINDIKAT'); // Ganti dengan nomor tujuan yang sesuai
            $message = "Hi, Salam Sehat \n\nInformasi Sindikat\nIjin mengkonfirmasi bahwa ada Permohonan Magang baru dari Perguruan Tinggi di halaman sindikat.\nTerimakasih\n\n*RSUD Brebes*";
            
            $response = $whatsappController->sendWhatsAppMessage($jenis, $noHp, $message);
        }
    
            return redirect()->back()->with(['success' => 'Data Permohonan Magang berhasil diajukan']);
        } else {
            return redirect()->back()->with(['error' =>'Dokumen Permohonan Magang yang diunggah tidak ada']);
        }
    }

    public function konfirmasi(Request $request, $id){
        $magang = PermohonanMagang::findOrFail($id);

        $magang->update([
            'status' => $request->status,

        ]);
        return redirect()->back()->with(['success' => 'Data Permohonan Magang Berhasil Dikonfirmasi']);

    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        $magang = PermohonanMagang::with('institusi', 'peserta_didik')->findOrFail($id);

        $majors = Jurusan::where('institusi_id', $magang->institusi_id)->latest()->get();

        $students = PesertaDidik::with('jurusan')->where('permohonan_magang_id', $id)->orderBy('nama_lengkap', 'ASC')->get();

        return view('sindikat::permohonan_magang.show', compact('magang', 'majors', 'students'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $magang = PermohonanMagang::findOrFail($id);
        return response()->json($magang);
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
            'tanggal_mulai'          => 'required|date',
            'tanggal_selesai'              => 'required|date',
            'jumlah_peserta'             => 'required|int',
        ]);

        $magang = PermohonanMagang::findOrFail($id);

        if ($request->hasFile('dokumen')) {
            
            $dokumen = $request->file('dokumen');
            $nama_file = $dokumen->getClientOriginalName(); // Menggunakan nama file asli untuk menyimpan file
            if ($dokumen->getSize() > 2097152) {
                $ukuran = 2097152 / 1024 / 1024;
                return redirect()->back()->with(['error' =>'Ukuran File terlalu besar. Pastikan File tidak lebih dari '.$ukuran.' MB']);
            }
            \Storage::delete('public/sindikat/permohonan_magang/'.$magang->institusi_id . '/' . $magang->dokumen);
    
            // Simpan file ke direktori
            $dokumen->storeAs('public/sindikat/permohonan_magang/'.$magang->institusi_id .'/', $nama_file);
    
            // Update data pegawai dengan nama file yang baru
            $magang->update([
                'no_surat' => $request->no_surat,
                'tanggal_surat' => $request->tanggal_surat,
                'tanggal_mulai' => $request->tanggal_mulai,
                'tanggal_selesai' => $request->tanggal_selesai,
                'jumlah_peserta' => (int)$request->jumlah_peserta,
                'dokumen' => $nama_file
            ]);

            return redirect()->back()->with(['success' => 'Data Permohonan Magang Berhasil Disimpan']);
        } else {
            $magang->update([
                'no_surat' => $request->no_surat,
                'tanggal_surat' => $request->tanggal_surat,
                'tanggal_mulai' => $request->tanggal_mulai,
                'tanggal_selesai' => $request->tanggal_selesai,
                'jumlah_peserta' => (int)$request->jumlah_peserta,
            ]);

            return redirect()->back()->with(['success' => 'Data Permohonan Magang Berhasil Disimpan']);
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        $magang = PermohonanMagang::find($id);
        
        if ($magang) {
            $magang->delete();

            return redirect()->back()->with('success', 'Data Permohonan Magang berhasil dihapus.');
        } else {
            return redirect()->back()->with('error', 'Permohonan Magang tidak ditemukan.');
        }
    }
}
