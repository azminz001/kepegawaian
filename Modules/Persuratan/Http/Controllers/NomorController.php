<?php

namespace Modules\Persuratan\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

use Modules\Persuratan\Entities\Nomor;
use Modules\Persuratan\Entities\Klasifikasi;
use Modules\Kepegawaian\Entities\ProfilPegawai;


class NomorController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $cari = request('cari');
        $user = Auth::user();

        if ($user->level == 2) {
            # code...
            $pegawai = ProfilPegawai::with(['awal_kerja', 'unit_jabatan_aktif', 'jabatan_aktif'])->where('nip_nipppk_nrpk_nrpblud', $user->username)->first();

        }else{
            $pegawai ="";
        }

        if ($user->level == 2) {
            if (!empty($cari)) {
                $nomor = Nomor::join('klasifikasi', 'penomoran.id_klasifikasi', '=', 'klasifikasi.id')
                            ->where('penomoran.id_user', $user->id)
                            ->where(function ($query) use ($cari) {
                                $query->where('penomoran.nomor', 'like', "%" . $cari . "%")
                                        ->orWhere('penomoran.nama_surat', 'like', "%" . $cari . "%")
                                        ->orWhere('penomoran.status', 'like', "%" . $cari . "%")
                                        ->orWhere('klasifikasi.kode', 'like', "%" . $cari . "%");
                            })
                            ->select('penomoran.*', 'klasifikasi.kode as kode_klas', 'klasifikasi.id as id_klas', 'klasifikasi.nama as nama_klas')
                            ->orderBy('penomoran.id', 'desc')
                            ->paginate(10);
    
                $nomor_count = Nomor::join('klasifikasi', 'penomoran.id_klasifikasi', '=', 'klasifikasi.id')
                                ->where('penomoran.id_user', $user->id)
                                ->where(function ($query) use ($cari) {
                                    $query->where('penomoran.nomor', 'like', "%" . $cari . "%")
                                            ->orWhere('penomoran.nama_surat', 'like', "%" . $cari . "%")
                                            ->orWhere('penomoran.status', 'like', "%" . $cari . "%")
                                            ->orWhere('klasifikasi.kode', 'like', "%" . $cari . "%");
                                })
                                ->count();
            } else {
                $nomor = Nomor::join('klasifikasi', 'penomoran.id_klasifikasi', '=', 'klasifikasi.id')
                            ->where('penomoran.id_user', $user->id)
                            ->select('penomoran.*', 'klasifikasi.kode as kode_klas', 'klasifikasi.id as id_klas', 'klasifikasi.nama as nama_klas')
                            ->orderBy('penomoran.id', 'desc')
                            ->paginate(10);
    
                $nomor_count = Nomor::join('klasifikasi', 'penomoran.id_klasifikasi', '=', 'klasifikasi.id')
                                ->where('penomoran.id_user', $user->id)
                                ->count();
            }
        } else{
            if (!empty($cari)) {
                $nomor = Nomor::join('db_persuratan.klasifikasi', 'db_persuratan.penomoran.id_klasifikasi', '=', 'db_persuratan.klasifikasi.id')
                            ->join('db_kepegawaian.users', 'db_persuratan.penomoran.id_user', '=', 'db_kepegawaian.users.id')
                            ->where(function ($query) use ($cari) {
                                $query->where('db_persuratan.penomoran.nomor', 'like', "%" . $cari . "%")
                                        ->orWhere('db_persuratan.penomoran.nama_surat', 'like', "%" . $cari . "%")
                                        ->orWhere('db_persuratan.penomoran.status', 'like', "%" . $cari . "%")
                                        ->orWhere('db_persuratan.klasifikasi.kode', 'like', "%" . $cari . "%");
                            })
                            ->select('db_persuratan.penomoran.*', 'db_persuratan.klasifikasi.kode as kode_klas', 'db_persuratan.klasifikasi.id as id_klas', 'db_persuratan.klasifikasi.nama as nama_klas', 'db_kepegawaian.users.name as user_name')
                            ->orderBy('db_persuratan.penomoran.id', 'desc')
                            ->paginate(10);
    
                $nomor_count = Nomor::join('db_persuratan.klasifikasi', 'db_persuratan.penomoran.id_klasifikasi', '=', 'db_persuratan.klasifikasi.id')
                                ->join('db_kepegawaian.users', 'db_persuratan.penomoran.id_user', '=', 'db_kepegawaian.users.id')
                                ->where(function ($query) use ($cari) {
                                    $query->where('db_persuratan.penomoran.nomor', 'like', "%" . $cari . "%")
                                            ->orWhere('db_persuratan.penomoran.nama_surat', 'like', "%" . $cari . "%")
                                            ->orWhere('db_persuratan.penomoran.status', 'like', "%" . $cari . "%")
                                            ->orWhere('db_persuratan.klasifikasi.kode', 'like', "%" . $cari . "%");
                                })
                                ->count();
            } else {
                $nomor = Nomor::join('db_persuratan.klasifikasi', 'db_persuratan.penomoran.id_klasifikasi', '=', 'db_persuratan.klasifikasi.id')
                            ->join('db_kepegawaian.users', 'db_persuratan.penomoran.id_user', '=', 'db_kepegawaian.users.id')
                            ->select('db_persuratan.penomoran.*', 'db_persuratan.klasifikasi.kode as kode_klas', 'db_persuratan.klasifikasi.id as id_klas', 'db_persuratan.klasifikasi.nama as nama_klas', 'db_kepegawaian.users.name as user_name')
                            ->orderBy('db_persuratan.penomoran.id', 'desc')
                            ->paginate(10);
    
                $nomor_count = Nomor::join('db_persuratan.klasifikasi', 'db_persuratan.penomoran.id_klasifikasi', '=', 'db_persuratan.klasifikasi.id')
                                ->join('db_kepegawaian.users', 'db_persuratan.penomoran.id_user', '=', 'db_kepegawaian.users.id')
                                ->count();
            }
        }

        $klasifikasi = Klasifikasi::all();

        return view('Persuratan::nomor.index', compact('nomor', 'nomor_count', 'klasifikasi', 'pegawai'));
    }

    /* Fungsi Konversi Angka Romawi */
    public function angkaKeRomawi($angka)
    {
        $map = [
            'M' => 1000,
            'CM' => 900,
            'D' => 500,
            'CD' => 400,
            'C' => 100,
            'XC' => 90,
            'L' => 50,
            'XL' => 40,
            'X' => 10,
            'IX' => 9,
            'V' => 5,
            'IV' => 4,
            'I' => 1,
        ];

        $romawi = '';

        foreach ($map as $rom => $val) {
            while ($angka >= $val) {
                $romawi .= $rom;
                $angka -= $val;
            }
        }

        return $romawi;
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $tanggal_sekarang = Carbon::now()->toDateString();
        //$tahun_sekarang   = Carbon::now()->format('Y');
        $tahun_input      = Carbon::parse($request->input('tanggal_surat'))->format('Y');
        $bulan_input      = $this->angkaKeRomawi(Carbon::parse($request->input('tanggal_surat'))->format('m'));
        $tanggal_input    = $request->tanggal_surat;
        $user             = Auth::user();
        $tahun_terakhir   = Nomor::max('tahun');

            if($tanggal_input == $tanggal_sekarang){
                if($tahun_input == $tahun_terakhir){
                    //$nomor_terakhir = Nomor::max('nomor');
                    $nomor_terakhir = Nomor::where('tahun', Nomor::max('tahun'))->max('nomor');
                    $nomor_baru     = $nomor_terakhir + 1;
                    $kelompok_baru  = null;
                }
      
            } elseif($tanggal_input < $tanggal_sekarang){
                $nomor_terakhir = Nomor::where('tanggal_surat', $tanggal_input)
                                    ->orderBy('nomor', 'desc')
                                    ->orderBy('kelompok', 'desc')
                                    ->first();
    
                if(is_null($nomor_terakhir)){
                    $nomor_terakhir = Nomor::where('tahun', $tahun_input)
                                    ->where('bulan', $bulan_input)
                                    ->orderBy('nomor', 'desc')
                                    ->orderBy('kelompok', 'desc')
                                    ->first();
                    if(is_null($nomor_terakhir)){
                        return redirect()->back()->with('error', 'Sistem belum digunakan pada tanggal tersebut, silahkan menghubungi admin persuratan untuk penomoran manual');
                    } else{
                        $nomor_baru = $nomor_terakhir->nomor;
    
                        if (is_null($nomor_terakhir->kelompok)) {
                            $kelompok_baru = 'a';
                        } else {
                            $ascii = ord($nomor_terakhir->kelompok);
                            $nextAscii = $ascii + 1;
                            $kelompok_baru = chr($nextAscii);
                        }
                    }
                } else{
                    $nomor_terakhir = Nomor::where('tanggal_surat', $tanggal_input)
                                    ->orderBy('nomor', 'desc')
                                    ->orderBy('kelompok', 'desc')
                                    ->first();
    
                    $nomor_baru = $nomor_terakhir->nomor;
    
                    if (is_null($nomor_terakhir->kelompok)) {
                        $kelompok_baru = 'a';
                    } else {
                        $ascii = ord($nomor_terakhir->kelompok);
                        $nextAscii = $ascii + 1;
                        $kelompok_baru = chr($nextAscii);
                    }
                }
            } else{
                return redirect()->back()->with('error', 'Tanggal surat tidak boleh melebihi tanggal sekarang');
            }

        Nomor::create([
            'id_user'        => $user->id,
            'id_klasifikasi' => $request->klasifikasi,
            'nomor'          => $nomor_baru,
            'kelompok'       => $kelompok_baru,
            'bulan'          => $bulan_input,
            'tahun'          => $tahun_input,
            'nama_surat'     => $request->nama_surat,
            'tanggal_surat'  => $request->tanggal_surat,
            'status'         => "DIAMBIL",
        ]);

        return redirect()->back()->with('success', 'Data berhasil disimpan.');
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
            'nama_surat' => 'required|string|max:255',
        ]);

        $nomor = Nomor::findOrFail($id);

        $nomor->update([
            'id_klasifikasi' => $request->klasifikasi,
            'nama_surat'     => $request->nama_surat,
            'status'         => $request->status,
        ]);

        return redirect()->back()->with(['success' => 'Data Berhasil Diubah!']);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function upload(Request $request, $id)
    {
        $nomor = Nomor::findOrFail($id);

        $request->validate([
            'file' => 'required|file|mimes:pdf|max:2048',  // Maksimal 2MB (2048 KB)
        ], [
            'file.mimes' => 'File yang diunggah harus berupa PDF.',
            'file.max' => 'Ukuran file tidak boleh lebih dari 2MB.',
        ]);

        $file = $request->file('file');

        $filename = str_replace(' ', '_', $file->getClientOriginalName());
        $filename = time() . '_' . $filename;

        $file->storeAs('public/persuratan/penomoran/', $filename);

        $nomor->update([
            'file'   => $filename,
            'status' => "DIGUNAKAN"
        ]);

        return redirect()->back()->with(['success' => 'File berhasil disimpan !']);
    }

    public function getNomors()
    {
        $nomor = Nomor::all();
        return response()->json($nomor);
    }

    public function detailNomor($id)
    {
        $detail_nomor = Nomor::findOrFail($id);
        return response()->json($detail_nomor);

    }
}