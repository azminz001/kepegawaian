<?php

namespace Modules\Rapat\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Database\QueryException;

use Modules\Kepegawaian\Entities\ProfilPegawai;
use Modules\Rapat\Entities\JadwalRapat;
use Modules\Rapat\Entities\KehadiranRapat;

class KehadiranRapatController extends Controller
{
    public function index(Request $request)
    {
        $pegawais = ProfilPegawai::all();

        // Ambil data rapat 1 baris berdasarkan UUID
        $rapat = JadwalRapat::join('ruang_pertemuan', 'jadwal_rapat.id_ruang', '=', 'ruang_pertemuan.id')
            ->where('jadwal_rapat.uuid', $request->uuid_jadwal_rapat)
            ->select('jadwal_rapat.*', 'ruang_pertemuan.*')
            ->firstOrFail();

        // Ambil data peserta berdasarkan UUID + filter jika ada pencarian
        $kehadirans = KehadiranRapat::where('uuid_jadwal_rapat', $request->uuid_jadwal_rapat)
            ->when($request->filled('cari'), function ($query) use ($request) {
                $query->where('nama_peserta', 'like', '%' . $request->cari . '%');
            })
            ->orderBy('id', 'asc')
            ->paginate(25)
            ->withQueryString(); // agar query "cari" tetap terbawa saat pagination

        return view('rapat::kehadiran.index', compact('rapat', 'kehadirans', 'pegawais'));
    }

    public function form(Request $request)
    {
        $pegawais = ProfilPegawai::all();

        $rapat = JadwalRapat::join('ruang_pertemuan', 'jadwal_rapat.id_ruang', '=', 'ruang_pertemuan.id')
            ->where('jadwal_rapat.uuid', $request->uuid)
            ->select('jadwal_rapat.*', 'ruang_pertemuan.*')
            ->first();

        return view('rapat::kehadiran.form', compact('rapat', 'pegawais'));
    }

    public function store(Request $request)
    {
        if ($request->instansi == "RSUD Brebes") {

            $pegawai = ProfilPegawai::where('id', $request->pegawai_id)->first();

            $nama_peserta = '';

            if ($pegawai->gelar_depan) {
                $nama_peserta .= $pegawai->gelar_depan . '. ';
            }

            $nama_peserta .= $pegawai->nama;

            if ($pegawai->gelar_belakang) {
                $nama_peserta .= ', ' . $pegawai->gelar_belakang;
            }

            KehadiranRapat::create([
                'uuid_jadwal_rapat' => $request->uuid_jadwal_rapat,
                'nama_peserta'      => $nama_peserta,
                'nip_nrp'           => $pegawai->nip_nipppk_nrpk_nrpblud,
                'instansi'          => $request->instansi
            ]);
        } else {

            KehadiranRapat::create([
                'uuid_jadwal_rapat' => $request->uuid_jadwal_rapat,
                'nama_peserta'      => $request->nama_peserta,
                'nip_nrp'           => $request->nip_nrp,
                'instansi'          => $request->instansi
            ]);
        }

        return redirect()->back()->with('success', 'Berhasil ! Kehadiran sudah dicatat');
    }

    public function destroy($id)
    {
        try {
            $kehadiran_rapat = KehadiranRapat::find($id);
            $kehadiran_rapat->delete();

            return redirect()->back()->with('success', 'Jadwal rapat berhasil dihapus.');
        } catch (QueryException $e) {
            if ($e->getCode() === '23000') {
                return redirect()->back()->with('error', 'Data sedang digunakan.');
            }

            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus data.');
        }
    }

    public function cetak($uuid)
    {
        $rapat = JadwalRapat::join('ruang_pertemuan', 'jadwal_rapat.id_ruang', '=', 'ruang_pertemuan.id')
            ->where('jadwal_rapat.uuid', $uuid)
            ->select('jadwal_rapat.*', 'ruang_pertemuan.*')
            ->firstOrFail();

        $kehadirans = KehadiranRapat::where('uuid_jadwal_rapat', $uuid)->orderBy('id', 'asc')->get();

        return view('rapat::kehadiran.cetak', compact('rapat', 'kehadirans'));
    }
}
