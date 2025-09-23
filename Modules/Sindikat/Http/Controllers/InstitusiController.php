<?php

namespace Modules\Sindikat\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use Modules\Sindikat\Entities\Institusi;
use Modules\Sindikat\Entities\User;
use Modules\Sindikat\Entities\Jurusan;
use Modules\Sindikat\Entities\Jenjang;
use Modules\Sindikat\Entities\PermohonanMagang;
use Modules\Sindikat\Entities\PesertaDidik;
use Modules\Kepegawaian\Entities\Users;

class InstitusiController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $cari = request('cari');

        if(!empty($cari)){
            $institusis = Institusi::where('nama', 'like',"%".$cari."%")->latest()->paginate(15);
            $institusi_count = Institusi::where('nama', 'like',"%".$cari."%")->count();
        }else{
            $institusis = Institusi::latest()->paginate(15);
            $institusi_count = Institusi::count();
        }

        // dd($arsips);
        return view('sindikat::institusi.index', compact('institusis', 'institusi_count'));
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

    public function pengguna(){
        $cari = request('cari');
        if(!empty($cari)){
            $users = Users::where(function($query) use ($cari) {
                $query->where('username', 'like', "%".$cari."%")
                    ->orWhere('name', 'like', "%".$cari."%");
            })
            ->latest()
            ->paginate(100);
            $user_count = Users::where('username', 'like',"%".$cari."%")->count();
        }else{
            $users = Users::where(['level' => '5'])->latest()->paginate(15);
            $user_count = Users::count();
        }

        return view('sindikat::institusi.pengguna', compact('users', 'user_count'));
    }

    public function store(Request $request)
    {
        // dd($request);
        $request->validate([
            'nama'     => 'required|string|max:255',
            'email' => 'required|string|max:255|unique:users,username',
        ], [
            'email.unique' => 'Email sudah terdaftar, silahkan hubungi admin',
        ]);

        try{
            

            $store = Institusi::create([
                'nama'                    => strtoupper($request->nama),
                'level'                   => $request->level, 
                'akreditasi'              => $request->akreditasi,   
                'nama_pimpinan'           => $request->nama_pimpinan,
                'telp'                    => $request->telp,
                'no_wa'                   => $request->no_wa,
                'email'                   => $request->email,
                'alamat'                  => $request->alamat,
                'kota'                    => $request->kota,
                'provinsi'                => $request->provinsi,
                'status'                  => 1
            ]);

            if ($store) {
                Users::create([
                'name'  => strtoupper($request->nama),
                'email' => $request->email,
                'username' => $request->email,
                'password' => Hash::make(123456),
                'level' => '5',
                'status' => '0'
            ]);
            }
    
            return redirect()->back()->with('success', 'Pendaftaran Berhasil, Silahkan Login.');
            // dd($request);
            
        }catch (QueryException $e) {
            return redirect()->back()->withErrors('Proses pendaftaran gagal, hubungi admin.');
        
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {

        $institusi = Institusi::findOrFail($id);
        return view('sindikat::institusi.show', compact('institusi'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('sindikat::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        $institusi = Institusi::findOrFail($id);

        $update_institusi = $institusi->update([
            'nama'                    => strtoupper($request->nama),
            'level'                   => $request->level, 
            'akreditasi'              => $request->akreditasi,   
            'nama_pimpinan'           => $request->nama_pimpinan,
            'telp'                    => $request->telp,
            'no_wa'                    => $request->no_wa,
            'email'                   => $request->email,
            'alamat'                  => $request->alamat,
            'kota'                    => $request->kota,
            'provinsi'                => $request->provinsi,
            'status'                  => $request->status
        ]);
        if ($update_institusi) {
            # code...
        }

        return redirect()->back()->with('success', 'Proses Update data Institusi berhasil');


    }

    public function ganti_logo(Request $request, $id){

        $institusi = Institusi::findOrFail($id);

        if ($request->hasFile('logo')) {
            $image = $request->file('logo');
            $nama_file = time()."-".$image->getClientOriginalName(); // Menggunakan nama file asli untuk menyimpan file

            if ($image->getSize() > 2097152) {
                $ukuran = 2097152 / 1024 / 1024;
                return redirect()->back()->with(['error' =>'Ukuran File terlalu besar. Pastikan File tidak lebih dari '.$ukuran.' MB']);
            }
    
            // Simpan file ke direktori
            $image->storeAs('public/sindikat/institusi/logo/', $nama_file);
    
            // Update data pegawai dengan nama file yang baru
            $institusi->update([
                'logo' => $nama_file,
            ]);
    
            return redirect()->back()->with(['success' => 'Logo Berhasil Diubah!']);
        } else {
            return redirect()->back()->with(['error' => 'Gagal mengupload foto. Silakan coba lagi atau Gunakan Foto format lain!']);
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        $institusi = Institusi::find($id);
        
        if ($institusi) {
            $institusi->delete();

            return redirect()->route('sindikat.institusi.index')->with('success', 'Institusi berhasil dihapus.');
        } else {
            return redirect()->back()->with('error', 'Institusi tidak ditemukan.');
        }
    }

    public function lihat_jurusan($id){
        $institusi = Institusi::find($id);

        $jenjangs = Jenjang::get();

        $majors = Jurusan::with('jenjang', 'peserta_didik')->where('institusi_id', $id)->get();
        
        return view('sindikat::jurusan.index', compact('institusi','majors', 'jenjangs'));

    }

    public function lihat_riwayat_permohonan_magang($id){
        $institusi = Institusi::find($id);

        $magangs = PermohonanMagang::with('peserta_didik')->where('institusi_id', $id)->latest()->get();
        
        return view('sindikat::institusi.riwayatpermohonanmagang', compact('institusi','magangs'));

    }

    public function lihat_peserta_didik($id){
        $institusi = Institusi::find($id);

        $students = Institusi::join('jurusan', 'institusi.id', '=', 'jurusan.institusi_id')
                                ->join('peserta_didik', 'jurusan.id', '=', 'peserta_didik.jurusan_id')
                                ->join('permohonan_magang', 'peserta_didik.permohonan_magang_id', '=', 'permohonan_magang.id')
                                ->where('institusi.id', $id)
                                ->select(
                                    'peserta_didik.id',
                                    'peserta_didik.no_induk',
                                    'peserta_didik.jenis_kelamin',
                                    'peserta_didik.nama_lengkap',
                                    'jurusan.nama as nama_jurusan',
                                    'permohonan_magang.tanggal_mulai',
                                    'permohonan_magang.tanggal_selesai'
                                )
                                ->paginate(15);

        return view('sindikat::institusi.datapesertadidik', compact('institusi','students'));
        
    }

    public function lihat_studi_banding($id){
        $institusi = Institusi::find($id);

        $visitings = PermohonanStudiBanding::where('institusi_id', $id)->latest()->get();

        return view('sindikat::institusi.riwayatstudibanding', compact('institusi','visitings'));
    }
}


