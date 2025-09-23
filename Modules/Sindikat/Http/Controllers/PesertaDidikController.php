<?php

namespace Modules\Sindikat\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

use Modules\Sindikat\Entities\PesertaDidik;
use Modules\Kepegawaian\Entities\ProfilPegawai;
use Modules\Kepegawaian\Entities\PegawaiCI;
use Modules\Kepegawaian\Entities\Unit;
use Modules\Sindikat\Entities\EvaluasiPeserta;
use Modules\Sindikat\Entities\JadwalPesertaDidik;


class PesertaDidikController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
   public function index()
    {
        $cari = request('cari');
        $user = Auth::user();

        $pegawai = null;
        $pegawai_ci = false;

        // Cek user level 2
        if ($user->level == 2) {
            $pegawai = ProfilPegawai::with(['instruktur_klinik' => function ($q) {
                $q->where('pegawai_ci.status', 1);
            }])->where('nip_nipppk_nrpk_nrpblud', $user->username)->first();

            $pegawai_ci = $pegawai && $pegawai->instruktur_klinik->isNotEmpty();
        }

        // Query awal
        $studentsQuery = PesertaDidik::with(['jurusan', 'permohonan_magang']);

        if (!empty($cari)) {
            $studentsQuery->where(function ($query) use ($cari) {
                $query->where('nama_lengkap', 'like', "%$cari%")
                    ->orWhere('no_induk', 'like', "%$cari%");
            });
        } else {
            $studentsQuery->latest();
        }

        $students = $studentsQuery->paginate(25);

        return view('sindikat::peserta_didik.index', compact('students', 'pegawai_ci', 'pegawai'));
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
            'no_induk'     => 'required|string|max:255',
            'nama_lengkap'     => 'required|string|max:255',
            'jenis_kelamin'     => 'required|int',
        ]);

        PesertaDidik::create([
            'no_induk'     => $request->no_induk,
            'nama_lengkap' => strtoupper($request->nama_lengkap),
            'jenis_kelamin' => (int)$request->jenis_kelamin,
            'permohonan_magang_id' => $request->permohonan_magang_id,
            'jurusan_id' => $request->jurusan_id,
            'institusi_id' => $request->institusi_id
        ]);

        return redirect()->back()->with('success', 'Data Peserta didik berhasil disimpan');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        $user = Auth::user();
        $pegawai = "";
        $units = Unit::get();
        
        $student = PesertaDidik::with('jurusan', 'permohonan_magang', 'evaluasi.pegawai')->findOrFail($id);
        $schedules = JadwalPesertaDidik::where('peserta_didik_id', $id)->get();

        foreach ($schedules as $item) {
            $item->unit = \Modules\Kepegawaian\Entities\Unit::on('mysql')->find($item->unit_id);
        }

        // dd($item);
        if ($user->level == '2') {
            $pegawai = ProfilPegawai::with(['awal_kerja', 'unit_jabatan_aktif', 'jabatan_aktif'])->where('nip_nipppk_nrpk_nrpblud', $user->username)->first();

        }else{
            $pegawai = "";
        }

        return view('sindikat::peserta_didik.show', compact('student', 'pegawai', 'units', 'schedules'));
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
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        
        $student = PesertaDidik::find($id);
        
        if ($student) {
            $student->delete();

            return redirect()->back()->with('success', 'Peserta didik berhasil dihapus.');
        } else {
            return redirect()->back()->with('error', 'Peserta didik tidak ditemukan.');
        }
    }
}
