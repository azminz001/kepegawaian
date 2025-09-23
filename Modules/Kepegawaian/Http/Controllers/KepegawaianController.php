<?php

namespace Modules\Kepegawaian\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

use Carbon\Carbon;
use DB;

use Modules\Kepegawaian\Entities\ProfilPegawai;
use Modules\Kepegawaian\Entities\Unit;
use Modules\Kepegawaian\Entities\JabatanUnit;
use Modules\Kepegawaian\Entities\JenisJabatan;
use Modules\Kepegawaian\Entities\Jabatan;
use Modules\Kepegawaian\Entities\KelJabatan;
use Modules\Kepegawaian\Entities\AnakPegawai;
use Modules\Kepegawaian\Entities\RiwayatGajiBerkala;
use Modules\Kepegawaian\Entities\Berita;



class KepegawaianController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {

        if(Auth::user()->level == 0 || Auth::user()->level == 1){
            $pegawai = null;

                // Mendapatkan data dengan tanggal SK 2 tahun sebelum tahun sekarang dan status pegawai 'PNS'
                $gaji_berkala_year_now = RiwayatGajiBerkala::whereYear('tanggal_mulai_berlaku', Carbon::now()->year - 2)
                ->whereHas('pegawai', function($q) {
                    $q->where('status_kepegawaian', 'PNS');
                })
                ->get();
            
            // Mendapatkan data dengan tanggal SK 1 tahun sebelum tahun sekarang dan status pegawai 'PNS'
            $gaji_berkala_next_year = RiwayatGajiBerkala::whereYear('tanggal_mulai_berlaku', Carbon::now()->year - 1)
                ->whereHas('pegawai', function($q) {
                    $q->where('status_kepegawaian', 'PNS');
                })
                ->get();
        }else {
            $username = trim(Auth::user()->username);

            $pegawai = ProfilPegawai::with('awal_kerja')
                ->where('nip_nipppk_nrpk_nrpblud', $username)
                ->first();


            // Mendapatkan data dengan tanggal SK 2 tahun sebelum tahun sekarang dan status pegawai 'PNS'
            $gaji_berkala_year_now = RiwayatGajiBerkala::whereYear('tanggal_mulai_berlaku', Carbon::now()->year - 2)
                ->whereHas('pegawai', function($q) use($pegawai) {
                    $q->where('id', $pegawai->id);
                })
                ->get();
            
            // Mendapatkan data dengan tanggal SK 1 tahun sebelum tahun sekarang dan status pegawai 'PNS'
            $gaji_berkala_next_year = RiwayatGajiBerkala::whereYear('tanggal_mulai_berlaku', Carbon::now()->year - 1)
                ->whereHas('pegawai', function($q) use($pegawai) {
                    $q->where('id', $pegawai->id);
                })
                ->get();

            if($pegawai->status_pegawai == 1){
                return redirect(route('pegawai.profil'));
            }
        }
        //Jumlah Pegawau
        $pegawai_active = ProfilPegawai::where('status_pegawai', '0')->count();
        $pegawai_inactive = ProfilPegawai::where('status_pegawai', '!=', '0')->count();

        //Jumlah Unit
        $unit = Unit::count();

        //Jumlah Jabatan Unit
        $jabatan_unit = JabatanUnit::count();
        //Jumlah Jenis Jabatan Unit
        $jenis_jabatan = JenisJabatan::with('jabatan_unit')->get();

        //Jumlah Jabatan Kepegawaian
        $jabatan_pegawai = Jabatan::count();

        $kel_jabatans = KelJabatan::withCount('pegawai_aktif_dashboard')->get();

        $kel_jabatan = $kel_jabatans->pluck('nama'); // Mengambil nama jabatan sebagai label
        $jumlah_kel_jabatan = $kel_jabatans->pluck('pegawai_aktif_dashboard_count'); // Mengambil jumlah pegawai aktif

        $laki_laki = ProfilPegawai::where('jenis_kelamin', 'L')->count();
        $perempuan = ProfilPegawai::where('jenis_kelamin', 'P')->count();

        $persentase_laki_laki = ($laki_laki / $pegawai_active) * 100;
        $persentase_perempuan = ($perempuan / $pegawai_active) * 100;


        $pegawai_birthday_now = ProfilPegawai::whereDay('tanggal_lahir', Carbon::now()->day)
            ->whereMonth('tanggal_lahir', Carbon::now()->month)
            ->get();
        
        $anak_birthday_now = AnakPegawai::with('pegawai')->whereDay('tanggal_lahir', Carbon::now()->day)
            ->whereMonth('tanggal_lahir', Carbon::now()->month)
            ->get();

        $pegawai_birthday_sevendays = ProfilPegawai::whereBetween(
            DB::raw('DATE_FORMAT(tanggal_lahir, "%m-%d")'),
            [
                Carbon::now()->addDay(1)->format('m-d'),
                Carbon::now()->addDays(7)->format('m-d')
            ]
        )->orderBy('tanggal_lahir', 'DESC')->get();

        $pegawai_over = ProfilPegawai::whereDate('tanggal_lahir', '<=', Carbon::now()->subYears(55)->format('Y-m-d'))
                        ->whereDate('tanggal_lahir', '>', Carbon::now()->subYears(60)->format('Y-m-d')) 
                        ->orderBy('tanggal_lahir', 'asc') 
                        ->get();


        $beritas = Berita::latest()->limit(15)->get();

        // Periksa apakah bulan sekarang adalah Desember
        if (Carbon::now()->format('m') == '12') {
            $tahunSekarang = Carbon::now()->year;
        
            // Filter untuk status kepegawaian
            $statusKepegawaian = ['BLUD', 'MITRA'];
        
            // Pegawai yang telah mengisi kontrak kerja di tahun ini
            $pegawaiDenganKontrakTahunIni = ProfilPegawai::whereIn('status_kepegawaian', $statusKepegawaian)
                ->whereHas('kontrak_kerja', function ($query) use ($tahunSekarang) {
                    $query->whereYear('tanggal_permohonan', $tahunSekarang);
                })
                ->get();
        
            // Pegawai yang belum mengisi kontrak kerja di tahun ini
            $pegawaiBelumKontrakTahunIni = ProfilPegawai::whereIn('status_kepegawaian', $statusKepegawaian)->where('status_pegawai', '0')
                ->where(function ($query) use ($tahunSekarang) {
                    $query->doesntHave('kontrak_kerja')
                        ->orWhereDoesntHave('kontrak_kerja', function ($subQuery) use ($tahunSekarang) {
                            $subQuery->whereYear('tanggal_permohonan', $tahunSekarang);
                        });
                })
                ->get();
        } else {
            $pegawaiDenganKontrakTahunIni = collect(); // Kosongkan jika bukan bulan Desember
            $pegawaiBelumKontrakTahunIni = collect(); // Kosongkan jika bukan bulan Desember
        }

        return view('kepegawaian.dashboard', compact(
                                                    'pegawai','pegawai_active', 'pegawai_inactive', 'unit', 'jabatan_unit', 'jenis_jabatan', 'jabatan_pegawai', 'kel_jabatan', 'jumlah_kel_jabatan', 
                                                    'laki_laki', 'perempuan','persentase_laki_laki', 'persentase_perempuan','pegawai_birthday_now', 
                                                    'anak_birthday_now', 'pegawai_birthday_sevendays', 'pegawai_over', 'beritas', 'gaji_berkala_year_now', 'gaji_berkala_next_year', 
                                                    'pegawaiDenganKontrakTahunIni', 'pegawaiBelumKontrakTahunIni'
                                                ));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('kepegawaian::create');
    }

    public function broadcast()
    {
        $pegawai = ProfilPegawai::whereNotNull('no_hp')->get();
        return view('kepegawaian.wa-broadcast.form', compact('pegawai'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store_berita(Request $request)
    {
        $request->validate([
            'jenis'     => 'required',
            'perihal'     => 'required|string|max:100',
            'deskripsi'   => 'required'
        ]);

        // dd($request);

        Berita::create([
            'perihal'     => $request->perihal,
            'deskripsi'     => $request->deskripsi,
            'jenis'     => $request->jenis,
        ]);

        return redirect()->back()->with('success', 'Berita Baru berhasil disimpan.');
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
    public function destroy_berita($id)
    {
        $berita = Berita::find($id);

        if ($berita) {
            $berita->delete();

            return redirect()->back()->with('success', 'Berita berhasil dihapus.');
        } else {
            return redirect()->back()->with('error', 'Berita tidak ditemukan.');
        }
    }
}
