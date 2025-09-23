<?php

namespace Modules\Kepegawaian\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;

use Modules\Kepegawaian\Entities\ProfilPegawai;
use Modules\Kepegawaian\Entities\RiwayatJabatan;
use Modules\Kepegawaian\Entities\RiwayatJabatanUnit;
use Modules\Kepegawaian\Entities\RiwayatPendidikan;
use Modules\Kepegawaian\Entities\RiwayatGolongan;
use Modules\Kepegawaian\Entities\RiwayatGajiBerkala;
use Modules\Kepegawaian\Entities\RiwayatDiklat;
use Modules\Kepegawaian\Entities\RiwayatArtikel;
use Modules\Kepegawaian\Entities\RiwayatInovasi;
use Modules\Kepegawaian\Entities\RiwayatKaryaBuku;
use Modules\Kepegawaian\Entities\RiwayatPekerjaan;
use Modules\Kepegawaian\Entities\RiwayatOrganisasi;
use Modules\Kepegawaian\Entities\PegawaiCI;
use Modules\Kepegawaian\Entities\PasanganPegawai;
use Modules\Kepegawaian\Entities\AnakPegawai;
use Modules\Kepegawaian\Entities\Users;
use Modules\Kepegawaian\Entities\KelJabatan;
use Modules\Kepegawaian\Entities\Jabatan;
use Modules\Kepegawaian\Entities\Golongan;
use Modules\Kepegawaian\Entities\Eselon;
use Modules\Kepegawaian\Entities\Unit;
use Modules\Kepegawaian\Entities\JabatanUnit;
use Modules\Kepegawaian\Entities\JenjangPendidikan;
use Modules\Kepegawaian\Entities\DokumenPegawai;
use Modules\Kepegawaian\Entities\RiwayatKontrakKerja;

use Illuminate\Support\Facades\Auth;

class ProfilPegawaiController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index($tipe = null)
    {
        $cari = request('cari');
        $status_pegawai = $tipe;

        // dd($status_pegawai);
        if($status_pegawai == 'aktif'){
            $status_pegawai = '0';
        }elseif ($status_pegawai == 'tidak_aktif') {
            $status_pegawai = '1';
        }elseif ($status_pegawai == 'mutasi') {
            $status_pegawai = '2';
        }elseif ($status_pegawai == 'pensiun') {
            $status_pegawai = '3';
        }elseif ($status_pegawai == 'diberhentikan') {
            $status_pegawai = '4';
        }
        if(!empty($cari)){
            $pegawais = ProfilPegawai::with(['jabatan_aktif', 'unit_jabatan_aktif'])->where('nama', 'like',"%".$cari."%")->orWhere('nip_nipppk_nrpk_nrpblud', 'like', "%".$cari."%")->latest()->paginate(100);
            $pegawai_count = ProfilPegawai::where('nama', 'like',"%".$cari."%")->orWhere('nip_nipppk_nrpk_nrpblud', 'like', "%".$cari."%")->count();
        }elseif($status_pegawai != ''){
            $pegawais = ProfilPegawai::with(['jabatan_aktif', 'unit_jabatan_aktif'])->where('status_pegawai', $status_pegawai)->latest()->paginate(15);
            $pegawai_count = ProfilPegawai::count();
        }else{
            $pegawais = ProfilPegawai::with(['jabatan_aktif', 'unit_jabatan_aktif'])->orderBy('nama', 'ASC')->paginate(15);
            $pegawai_count = ProfilPegawai::count();
        }

        $jml_pns = ProfilPegawai::where('status_kepegawaian', 'PNS')->count();
        $jml_pppk = ProfilPegawai::where('status_kepegawaian', 'PPPK')->count();
        $jml_blud = ProfilPegawai::where('status_kepegawaian', 'BLUD')->count();
        $jml_mitra = ProfilPegawai::where('status_kepegawaian', 'MITRA')->count();
        $jml_kontrak = ProfilPegawai::where('status_kepegawaian', 'KONTRAK')->count();

        return view('kepegawaian.datapegawai.index', compact('pegawais', 'pegawai_count', 'jml_pns', 'jml_pppk', 'jml_blud', 'jml_mitra', 'jml_kontrak'));
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
            'nip_nipppk_nrpk_nrpblud'     => 'required|string|max:255|unique:profil_pegawai,nip_nipppk_nrpk_nrpblud',
            'nama'                        => 'required|string|max:255',
        ]);

        ProfilPegawai::create([
            'nip_nipppk_nrpk_nrpblud' => $request->nip_nipppk_nrpk_nrpblud,
            'nama'                    => strtoupper($request->nama),
            'nip_lama'                => $request->nip_lama, 
            'nip_baru'                => $request->nip_baru, 
            'gelar_depan'             => $request->gelar_depan, 
            'gelar_belakang'          => $request->gelar_belakang,       
            'nik'                     => $request->nik, 
            'no_kk'                   => $request->no_kk,
            'npwp'                    => $request->npwp, 
            'no_str'                  => $request->no_str, 
            'agama'                   => $request->agama, 
            'tempat_lahir'            => strtoupper($request->tempat_lahir), 
            'tanggal_lahir'           => $request->tanggal_lahir, 
            'jenis_kelamin'           => $request->jenis_kelamin, 
            'status_kepegawaian'      => $request->status_kepegawaian,
            'tmt_rsud'                => $request->tmt_rsud, 
            'no_bpjs_kis'             => $request->no_bpjs_kis, 
            'kelas_bpjs'              => $request->kelas_bpjs, 
            'status_kawin'            => $request->status_kawin, 
            'alamat'                  => strtoupper($request->alamat), 
            'rt'                      => $request->rt, 
            'rw'                      => $request->rw, 
            'kelurahan_desa'          => strtoupper($request->kelurahan_desa), 
            'kecamatan'               => strtoupper($request->kecamatan), 
            'kota'                    => strtoupper($request->kota), 
            'kode_pos'                => $request->kode_pos, 
            'telp'                    => $request->telp, 
            'no_hp'                   => $request->no_hp, 
            'email'                   => $request->email, 
            'gol_darah'               => $request->gol_darah, 
            'taspen'                  => $request->taspen, 
            'angka_kredit'            => $request->angka_kredit, 
            'kebangsaan'              => $request->kebangsaan, 
            'tunjangan'               => $request->tunjangan
        ]);

        $email = ($request->email != null) ? $request->email : $request->nip_nipppk_nrpk_nrpblud."@rsudbrebes.go.id";
        Users::create([
            'name'  => strtoupper($request->nama),
            'email' => $email,
            'username' => $request->nip_nipppk_nrpk_nrpblud,
            'password' => Hash::make(123456),
            'level' => '2'
        ]);

        return redirect()->back()->with('success', 'Data berhasil disimpan.');

    }

    public function ganti_foto(Request $request, $id){

        $pegawai = ProfilPegawai::findOrFail($id);

        if ($request->hasFile('foto')) {
            $image = $request->file('foto');
            $nama_file = $image->getClientOriginalName(); // Menggunakan nama file asli untuk menyimpan file

            if ($image->getSize() > 2097152) {
                $ukuran = 2097152 / 1024 / 1024;
                return redirect()->back()->with(['error' =>'Ukuran File terlalu besar. Pastikan File tidak lebih dari '.$ukuran.' MB']);
            }
    
            // Simpan file ke direktori
            $image->storeAs('public/foto_pegawai/'.$pegawai->nip_nipppk_nrpk_nrpblud.'/', $nama_file);
    
            // Update data pegawai dengan nama file yang baru
            $pegawai->update([
                'foto' => $nama_file,
            ]);
    
            return redirect()->back()->with(['success' => 'Foto Berhasil Diubah!']);
        } else {
            return redirect()->back()->with(['error' => 'Gagal mengupload foto. Silakan coba lagi atau Gunakan Foto format lain!']);
        }
    }
    

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        $pegawai = ProfilPegawai::with(['awal_kerja'])->findOrFail($id);
        return view('kepegawaian.datapegawai.show', compact('pegawai'));
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
        $request->validate([
            'nip_nipppk_nrpk_nrpblud'     => 'required|string|max:255',
            'nama'                        => 'required|string|max:255',
        ]);
        $pegawai = ProfilPegawai::findOrFail($id);

        // dd($request);

        $pegawai->update([
            'nip_nipppk_nrpk_nrpblud' => $request->nip_nipppk_nrpk_nrpblud,
            'nama'                    => strtoupper($request->nama),
            'nip_lama'                => $request->nip_lama, 
            'nip_baru'                => $request->nip_baru, 
            'gelar_depan'             => $request->gelar_depan, 
            'gelar_belakang'          => $request->gelar_belakang,    
            'motto'                   => $request->motto,   
            'nik'                     => $request->nik, 
            'no_kk'                   => $request->no_kk,
            'npwp'                    => $request->npwp, 
            'no_str'                  => $request->no_str, 
            'agama'                   => $request->agama, 
            'tempat_lahir'            => strtoupper($request->tempat_lahir), 
            'tanggal_lahir'           => $request->tanggal_lahir, 
            'jenis_kelamin'           => $request->jenis_kelamin, 
            'status_kepegawaian'      => $request->status_kepegawaian,
            'status_pegawai'          => ($request->status_pegawai != null) ? $request->status_pegawai : '0',
            'tmt_rsud'                => $request->tmt_rsud,
            'no_bpjs_kis'             => $request->no_bpjs_kis, 
            'kelas_bpjs'              => $request->kelas_bpjs, 
            'status_kawin'            => $request->status_kawin, 
            'alamat'                  => strtoupper($request->alamat), 
            'rt'                      => $request->rt, 
            'rw'                      => $request->rw, 
            'kelurahan_desa'          => strtoupper($request->kelurahan_desa), 
            'kecamatan'               => strtoupper($request->kecamatan), 
            'kota'                    => strtoupper($request->kota), 
            'kode_pos'                => $request->kode_pos, 
            'telp'                    => $request->telp, 
            'no_hp'                   => $request->no_hp, 
            'email'                   => $request->email, 
            'gol_darah'               => $request->gol_darah, 
            'taspen'                  => $request->taspen, 
            'angka_kredit'            => $request->angka_kredit, 
            'kebangsaan'              => $request->kebangsaan, 
            'tunjangan'               => $request->tunjangan
        ]);
        return redirect()->back()->with('success', 'Data berhasil disimpan.');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        $pegawai = ProfilPegawai::find($id);
        $username = $pegawai->nip_nipppk_nrpk_nrpblud;

        $user = Users::where('username', $username)->first();
        
        if ($pegawai) {
            $pegawai->delete();
            $user->delete();

            return redirect()->route('data_pegawai.index')->with('success', 'Data Pegawai berhasil dihapus.');
        } else {
            return redirect()->back()->with('error', 'Unit tidak ditemukan.');
        }
    }

    public function lihat_riwayat_jabatan($id = null){
        if(isset($id)){
            $pegawai = ProfilPegawai::with(['awal_kerja', 'unit_jabatan_aktif', 'jabatan_aktif'])->findOrFail($id);

            $riwayat_jabatans = RiwayatJabatan::with(['eselon', 'jabatan', 'kelompok_jabatan'])
            ->where('pegawai_id', $id)
            ->orderBy('tmt_jabatan', 'DESC')
            ->get();
        }else{
            $pegawai = ProfilPegawai::with(['awal_kerja', 'unit_jabatan_aktif', 'jabatan_aktif'])->where('nip_nipppk_nrpk_nrpblud', Auth::user()->username)->first();

            $riwayat_jabatans = RiwayatJabatan::with(['eselon', 'jabatan', 'kelompok_jabatan'])
            ->where('nip_nipppk_nrpk_nrpblud', Auth::user()->username)
            ->orderBy('tmt_jabatan', 'DESC')
            ->get();
        }


        $kel_jabatans = KelJabatan::get();
        $jabatans = Jabatan::get();
        $eselons = Eselon::get();

        return view('kepegawaian.datapegawai.riwayatjabatan', compact('riwayat_jabatans', 'pegawai', 'kel_jabatans', 'jabatans', 'eselons'));
    }

    public function lihat_riwayat_jabatan_unit($id){
        $pegawai = ProfilPegawai::with(['awal_kerja', 'unit_jabatan_aktif', 'jabatan_aktif'])->findOrFail($id);

        $riwayat_jabatan_units = RiwayatJabatanUnit::with(['jabatan_unit' => function($q){
            return $q->with(['jenis_jabatan']);
        }, 'unit'])
        ->where('pegawai_id', $id)
        ->orderBy('tmt_jabatan_unit', 'DESC')
        ->get();

        $units = Unit::get();
        $jabatan_units = JabatanUnit::get();

        return view('kepegawaian.datapegawai.riwayatjabatanunit', compact('riwayat_jabatan_units', 'units', 'jabatan_units', 'pegawai'));
    }

    public function lihat_riwayat_golongan($id){
        $pegawai = ProfilPegawai::with(['awal_kerja', 'unit_jabatan_aktif', 'jabatan_aktif'])->findOrFail($id);

        $riwayat_golongans = RiwayatGolongan::with(['golongan'])
        ->where('pegawai_id', $id)
        ->orderBy('tmt', 'DESC')
        ->get();

        $golongans = Golongan::get();

        return view('kepegawaian.datapegawai.riwayatgolongan', compact('riwayat_golongans', 'golongans', 'pegawai'));
    }

    public function lihat_riwayat_gaji_berkala($id){
        $pegawai = ProfilPegawai::with(['awal_kerja', 'unit_jabatan_aktif', 'jabatan_aktif'])->findOrFail($id);

        $riwayat_gajis = RiwayatGajiBerkala::where('pegawai_id', $id)
        ->orderBy('tanggal_surat', 'DESC')
        ->get();

        return view('kepegawaian.datapegawai.riwayatgajiberkala', compact('riwayat_gajis', 'pegawai'));
    }

    public function lihat_riwayat_pendidikan($id){
        $pegawai = ProfilPegawai::with(['awal_kerja', 'unit_jabatan_aktif', 'jabatan_aktif'])->findOrFail($id);

        $riwayat_pendidikans = RiwayatPendidikan::with(['jenjang_pendidikan'])
        ->where('pegawai_id', $id)
        ->orderBy('tanggal_lulus', 'DESC')
        ->get();

        $jenjang_umum_pendidikans = JenjangPendidikan::where(['level' => 1])->get();
        $jenjang_tinggi_pendidikans = JenjangPendidikan::where(['level' => 2])->get();

        return view('kepegawaian.datapegawai.riwayatpendidikan', compact('riwayat_pendidikans', 'jenjang_umum_pendidikans', 'jenjang_tinggi_pendidikans', 'pegawai'));
    }

    public function lihat_riwayat_diklat($id){
        $pegawai = ProfilPegawai::with(['awal_kerja', 'unit_jabatan_aktif', 'jabatan_aktif'])->findOrFail($id);

        $riwayat_diklats = RiwayatDiklat::where('pegawai_id', $id)
                                    ->orderBy('tanggal_mulai', 'DESC')
                                    ->get();

        return view('kepegawaian.datapegawai.riwayatdiklat', compact('riwayat_diklats', 'pegawai'));
    }

    public function lihat_riwayat_karya_ilmiah($id){
        $pegawai = ProfilPegawai::with(['awal_kerja', 'unit_jabatan_aktif', 'jabatan_aktif'])->findOrFail($id);

        $riwayat_artikels = RiwayatArtikel::where('pegawai_id', $id)
                                    ->orderBy('created_at', 'DESC')
                                    ->get();

        $riwayat_inovasis = RiwayatInovasi::where('pegawai_id', $id)
                                    ->orderBy('created_at', 'DESC')
                                    ->get();
                                    
        $riwayat_karyabukus = RiwayatKaryaBuku::where('pegawai_id', $id)
                                    ->orderBy('created_at', 'DESC')
                                    ->get();

        return view('kepegawaian.datapegawai.riwayatkaryailmiah', compact('riwayat_artikels', 'riwayat_inovasis', 'riwayat_karyabukus', 'pegawai'));
    }
    
    public function lihat_riwayat_pekerjaan($id){
        $pegawai = ProfilPegawai::with(['awal_kerja', 'unit_jabatan_aktif', 'jabatan_aktif'])->findOrFail($id);

        $riwayat_pekerjaans = RiwayatPekerjaan::where('pegawai_id', $id)
                                    ->orderBy('tahun_mulai', 'DESC')
                                    ->get();

        return view('kepegawaian.datapegawai.riwayatpekerjaan', compact('riwayat_pekerjaans', 'pegawai'));
    }

    public function lihat_riwayat_organisasi($id){
        $pegawai = ProfilPegawai::with(['awal_kerja', 'unit_jabatan_aktif', 'jabatan_aktif'])->findOrFail($id);

        $riwayat_organisasis = RiwayatOrganisasi::where('pegawai_id', $id)
                                    ->orderBy('tahun_mulai', 'DESC')
                                    ->get();

        return view('kepegawaian.datapegawai.riwayatorganisasi', compact('riwayat_organisasis', 'pegawai'));
    }

    public function lihat_riwayat_pegawai_ci($id){
        $pegawai = ProfilPegawai::with(['awal_kerja', 'unit_jabatan_aktif', 'jabatan_aktif'])->findOrFail($id);

        $pegawai_cis = PegawaiCI::where('pegawai_id', $id)
                                    ->orderBy('tanggal_sk', 'DESC')
                                    ->get();

        return view('kepegawaian.datapegawai.riwayatpegawaici', compact('pegawai_cis', 'pegawai'));
    }

    public function lihat_dokumen($id){
        $pegawai = ProfilPegawai::with(['awal_kerja', 'unit_jabatan_aktif', 'jabatan_aktif'])->findOrFail($id);

        $dokumens = DokumenPegawai::where('pegawai_id', $id)
                                    ->latest()
                                    ->get();

        return view('kepegawaian.datapegawai.dokumen', compact('dokumens', 'pegawai'));
    }

    public function lihat_permohonan_kontrak($id){
        $pegawai = ProfilPegawai::with(['awal_kerja', 'unit_jabatan_aktif', 'jabatan_aktif'])->findOrFail($id);

        $dokumens = RiwayatKontrakKerja::where('pegawai_id', $id)
                                    ->latest()
                                    ->get();

        return view('kepegawaian.datapegawai.kontrakkerja', compact('dokumens', 'pegawai'));
    }

    public function lihat_pasangan($id){
        $pegawai = ProfilPegawai::with(['awal_kerja', 'unit_jabatan_aktif', 'jabatan_aktif'])->findOrFail($id);

        $pasangans = PasanganPegawai::where('pegawai_id', $id)
                                    ->orderBy('tanggal_nikah', 'DESC')
                                    ->get();

        return view('kepegawaian.datapegawai.pasangan', compact('pasangans', 'pegawai'));
    }

    public function lihat_anak($id){
        $pegawai = ProfilPegawai::with(['awal_kerja', 'unit_jabatan_aktif', 'jabatan_aktif'])->findOrFail($id);

        $anaks = AnakPegawai::where('pegawai_id', $id)
                                    ->orderBy('tanggal_lahir', 'ASC')
                                    ->get();

        return view('kepegawaian.datapegawai.anak', compact('anaks', 'pegawai'));
    }

    public function getProfilPegawai($id)
    {
        $pegawai = ProfilPegawai::with(['jabatan_aktif', 'riwayat_jabatan', 'unit_jabatan_aktif', 'riwayat_jabatan_unit', 'pendidikan_terakhir', 'riwayat_pendidikan'])->where(['nip_nipppk_nrpk_nrpblud' => $id])->get();
        return response()->json($pegawai);

    }

    public function profil()
    {
        $username = Auth::user()->username;
        // dd($username);
        $pegawai = ProfilPegawai::with('awal_kerja')
                ->where('nip_nipppk_nrpk_nrpblud', $username)
                ->firstOrFail();

        return view('kepegawaian.datapegawai.profil', compact('pegawai'));
    }

    public function get_all_pegawai(){
        $pegawais = ProfilPegawai::with(['jabatan_aktif', 'unit_jabatan_aktif'])->orderBy('nama', 'ASC')->get();

        return response()->json($pegawais);
    }
}
