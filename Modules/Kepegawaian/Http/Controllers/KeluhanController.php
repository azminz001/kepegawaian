<?php

namespace Modules\Kepegawaian\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use Modules\Kepegawaian\Entities\Keluhan;
use Modules\Kepegawaian\Entities\KeluhanBalasan;
use Illuminate\Support\Facades\Auth;
use Modules\Kepegawaian\Entities\ProfilPegawai;


class KeluhanController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        if(Auth::user()->level == 0 || Auth::user()->level == 1){
            $pegawai = null;
        }else{
            $username = Auth::user()->username;
            // dd($username);
            $pegawai = ProfilPegawai::with('awal_kerja')
                    ->where('nip_nipppk_nrpk_nrpblud', $username)
                    ->firstOrFail();

            // dd($pegawai);

            if($pegawai->status_pegawai == 1){
                return redirect(route('data_pegawai.profil'));
            }
        }
        
        $cari = request('cari');

        if ($cari) {
            $complaints = Keluhan::with('pengguna', 'balasan')->where('judul', 'like',"%".$cari."%")->latest()->paginate(15);
        }else{
            $complaints = Keluhan::with('pengguna', 'balasan')->latest()->paginate(15);
        }
        $complaint_count = Keluhan::count();

        $user_id = Auth::user()->id;

        $user_complaints = Keluhan::with('pengguna', 'balasan')->where('user_id', $user_id)->latest()->paginate(15);



        return view('kepegawaian.keluhan.index', compact('complaints', 'complaint_count', 'user_complaints', 'pegawai'));
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
            'judul'               => 'required|string|max:255',
            'catatan'              => 'required',
        ]);
        $user_id = Auth::user()->id;

        // dd($request);
        if ($request->hasFile('gambar')) {
            $gambar = $request->file('gambar');
            $nama_file = $gambar->getClientOriginalName(); // Menggunakan nama file asli untuk menyimpan file
            if ($gambar->getSize() > 2097152) {
                $ukuran = 2097152 / 1024 / 1024;
                return redirect()->back()->with(['error' =>'Ukuran File terlalu besar. Pastikan File tidak lebih dari '.$ukuran.' MB']);
            }
    
            // Simpan file ke direktori
            $gambar->storeAs('public/kepegawaian/keluhan/', $nama_file);
    
            // Update data pegawai dengan nama file yang baru
            $keluhan = Keluhan::create([
                'judul' => $request->judul,
                'catatan' => $request->catatan,
                'status' => 0,
                'user_id' => $user_id,
                'gambar' => $nama_file
            ]);
    
            return redirect()->back()->with(['success' => 'Data Keluhan atau Diskusi Berhasil Disimpan']);
        } else {
            Keluhan::create([
                'judul' => $request->judul,
                'catatan' => $request->catatan,
                'status' => 0,
                'user_id' => $user_id,
            ]);
    
            return redirect()->back()->with(['success' => 'Data Keluhan atau Diskusi Berhasil Disimpan']);
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {

        if(Auth::user()->level == 0 || Auth::user()->level == 1){
            $pegawai = null;
        }else{
            $username = Auth::user()->username;
            // dd($username);
            $pegawai = ProfilPegawai::with('awal_kerja')
                    ->where('nip_nipppk_nrpk_nrpblud', $username)
                    ->firstOrFail();

            // dd($pegawai);

            if($pegawai->status_pegawai == 1){
                return redirect(route('data_pegawai.profil'));
            }
        }
        
        $complaint = Keluhan::with('pengguna')->findOrFail($id);

        $replies = KeluhanBalasan::with('pengguna')->where('keluhan_id', $id)->latest()->get();
        return view('kepegawaian.keluhan.show', compact('complaint', 'replies', 'pegawai'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('kepegawaian::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        $keluhan = Keluhan::find($id);
        
        if ($keluhan) {

            \Storage::delete('public/kepegawaian/keluhan/' . $keluhan->gambar);

            $keluhan->delete();

            return redirect()->back()->with('success', 'Keluhan berhasil dihapus');
        } else {
            return redirect()->back()->with('error', 'Keluhan tidak ditemukan');
        }
    }
}
