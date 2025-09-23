<?php

namespace Modules\Rapat\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use Modules\Rapat\Entities\RuangRapat;
use Modules\Rapat\Entities\JadwalRapat;

class DisplayRapatController extends Controller
{
    public function index(Request $request)
    {
        $ruang_rapat = RuangRapat::all();
        $jadwal_rapat = collect(); // Untuk tabel di bawah
        $jadwal_saat_ini = null;   // Untuk kotak ungu

        if ($request->id_ruang) {
            $now = now(); // atau Carbon::now()

            // Jadwal yang sedang berlangsung
            $jadwal_saat_ini = JadwalRapat::join('profil_pegawai', 'jadwal_rapat.pegawai_id', '=', 'profil_pegawai.id')
                ->where('jadwal_rapat.status', '!=', 'selesai')
                ->where('jadwal_rapat.id_ruang', $request->id_ruang)
                ->whereDate('jadwal_rapat.tanggal', $now->toDateString())
                ->whereTime('jadwal_rapat.jam_mulai', '<=', $now->format('H:i:s'))
                ->whereTime('jadwal_rapat.jam_selesai', '>=', $now->format('H:i:s'))
                ->select('jadwal_rapat.*', 'jadwal_rapat.id as id_rapat', 'profil_pegawai.*')
                ->first();

            // Jadwal berikutnya: hari ini, jam mulai setelah sekarang
            $jadwal_rapat = JadwalRapat::join('profil_pegawai', 'jadwal_rapat.pegawai_id', '=', 'profil_pegawai.id')
                ->where('jadwal_rapat.status', '!=', 'selesai')
                ->where('jadwal_rapat.id_ruang', $request->id_ruang)
                ->whereDate('jadwal_rapat.tanggal', $now->toDateString())
                ->whereTime('jadwal_rapat.jam_mulai', '>', $now->format('H:i:s'))
                ->select('jadwal_rapat.*', 'jadwal_rapat.id as id_rapat', 'profil_pegawai.*')
                ->orderBy('jadwal_rapat.tanggal', 'asc')
                ->orderBy('jadwal_rapat.jam_mulai', 'asc')
                ->get();
        }

        return view('rapat::display.index', compact('jadwal_rapat', 'ruang_rapat', 'jadwal_saat_ini'));
    }

    public function displayGabungan(Request $request)
    {
        $now = now();
        $today = $now->toDateString();

        // Jadwal Hari Ini
        $jadwal_hari_ini = JadwalRapat::join('profil_pegawai', 'jadwal_rapat.pegawai_id', '=', 'profil_pegawai.id')
            ->join('ruang_pertemuan', 'jadwal_rapat.id_ruang', '=', 'ruang_pertemuan.id')
            ->where('jadwal_rapat.status', '!=', 'selesai')
            ->whereDate('jadwal_rapat.tanggal', $today)
            ->whereTime('jadwal_rapat.jam_selesai', '>', $now->format('H:i:s'))
            ->select(
                'jadwal_rapat.*',
                'jadwal_rapat.id as id_rapat',
                'profil_pegawai.*',
                'ruang_pertemuan.nama as nama_ruangan'
            )
            ->orderBy('jadwal_rapat.jam_mulai', 'asc')
            ->get();

        // Jadwal Hari Berikutnya
        $jadwal_berikutnya = JadwalRapat::join('profil_pegawai', 'jadwal_rapat.pegawai_id', '=', 'profil_pegawai.id')
            ->join('ruang_pertemuan', 'jadwal_rapat.id_ruang', '=', 'ruang_pertemuan.id')
            ->where('jadwal_rapat.status', '!=', 'selesai')
            ->whereDate('jadwal_rapat.tanggal', '>', $today)
            ->select(
                'jadwal_rapat.*',
                'jadwal_rapat.id as id_rapat',
                'profil_pegawai.*',
                'ruang_pertemuan.nama as nama_ruangan'
            )
            ->orderBy('jadwal_rapat.tanggal', 'asc')
            ->orderBy('jadwal_rapat.jam_mulai', 'asc')
            ->get();

        return view('rapat::display.gabungan', compact('jadwal_hari_ini', 'jadwal_berikutnya'));
    }
}
