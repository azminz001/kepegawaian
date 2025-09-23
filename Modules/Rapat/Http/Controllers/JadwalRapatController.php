<?php

namespace Modules\Rapat\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Str;
use Illuminate\Database\QueryException;

use Modules\Rapat\Entities\RuangRapat;
use Modules\Rapat\Entities\JadwalRapat;
use Modules\Kepegawaian\Entities\ProfilPegawai;

class JadwalRapatController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {
        $ruang_rapat  = RuangRapat::all();
        $jadwal_rapat = [];

        if (auth()->user()->level == 2) {
            if ($request->id_ruang) {
                $jadwal_query = JadwalRapat::join('profil_pegawai', 'jadwal_rapat.pegawai_id', '=', 'profil_pegawai.id')
                    ->where('jadwal_rapat.id_ruang', $request->id_ruang)
                    ->where('jadwal_rapat.status', '!=', 'selesai')
                    ->select('jadwal_rapat.*', 'jadwal_rapat.id as id_rapat', 'profil_pegawai.*')
                    ->orderBy('jadwal_rapat.tanggal', 'asc')
                    ->orderBy('jadwal_rapat.jam_mulai', 'asc');

                if ($request->filled('cari')) {
                    $jadwal_query->where('jadwal_rapat.nama_rapat', 'like', '%' . $request->cari . '%');
                }

                $jadwal_rapat = $jadwal_query->paginate(10);
            }
        } else {
            if ($request->id_ruang) {
                $jadwal_query = JadwalRapat::join('profil_pegawai', 'jadwal_rapat.pegawai_id', '=', 'profil_pegawai.id')
                    ->where('jadwal_rapat.id_ruang', $request->id_ruang)
                    ->select('jadwal_rapat.*', 'jadwal_rapat.id as id_rapat', 'profil_pegawai.*')
                    ->orderBy('jadwal_rapat.tanggal', 'asc')
                    ->orderBy('jadwal_rapat.jam_mulai', 'asc');

                if ($request->filled('cari')) {
                    $jadwal_query->where('jadwal_rapat.nama_rapat', 'like', '%' . $request->cari . '%');
                }

                $jadwal_rapat = $jadwal_query->paginate(10);
            }
        }

        return view('rapat::jadwal_rapat.index', compact('ruang_rapat', 'jadwal_rapat'));
    }

    public function update(Request $request, $id)
    {
        $jadwal_rapat = JadwalRapat::findOrFail($id);

        // Cek apakah tanggal, jam, atau ruangan berubah
        $jadwalBerubah = (
            $request->tanggal !== $jadwal_rapat->tanggal ||
            $request->jam_mulai !== $jadwal_rapat->jam_mulai ||
            $request->jam_selesai !== $jadwal_rapat->jam_selesai ||
            $request->id_ruang != $jadwal_rapat->id_ruang
        );

        // Jalankan validasi bentrok hanya jika jadwal berubah
        if ($jadwalBerubah) {
            $sudahAda = JadwalRapat::where('tanggal', $request->tanggal)
                ->where('id_ruang', $request->id_ruang)
                ->where('id', '!=', $id) // Hindari membentrokkan dengan dirinya sendiri
                ->where(function ($query) use ($request) {
                    $query->where('jam_mulai', '<', $request->jam_selesai)
                        ->where('jam_selesai', '>', $request->jam_mulai);
                })
                ->where('status', '!=', 'selesai')
                ->first();

            if ($sudahAda) {
                return redirect()->back()
                    ->with('error', 'Jadwal bertabrakan dengan agenda: "' . $sudahAda->nama_rapat . '"');
            }
        }

        // Update data tetap dijalankan
        $jadwal_rapat->update([
            'nama_rapat'     => strtoupper($request->nama_rapat),
            'jumlah_peserta' => $request->jumlah_peserta,
            'tanggal'        => $request->tanggal,
            'jam_mulai'      => $request->jam_mulai,
            'jam_selesai'    => $request->jam_selesai,
            'jumlah_snack'   => $request->jumlah_snack,
            'jumlah_makan'   => $request->jumlah_makan,
            'status'         => $request->status,
        ]);

        return redirect()
            ->route('rapat.jadwal_rapat.index', ['id_ruang' => $jadwal_rapat->id_ruang])
            ->with('success', 'Data berhasil diubah!');
    }

    public function destroy($id)
    {
        try {
            $jadwal_rapat = JadwalRapat::find($id);
            $jadwal_rapat->delete();

            return redirect()->back()->with('success', 'Jadwal rapat berhasil dihapus.');
        } catch (QueryException $e) {
            if ($e->getCode() === '23000') {
                return redirect()->back()->with('error', 'Data sedang digunakan.');
            }

            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus data.');
        }
    }

    public function store(Request $request)
    {
        $sudahAda = JadwalRapat::where('tanggal', $request->tanggal)
            ->where('id_ruang', $request->id_ruang)
            ->where(function ($query) use ($request) {
                $query->where('jam_mulai', '<', $request->jam_selesai)
                    ->where('jam_selesai', '>', $request->jam_mulai);
            })
            ->where('status', '!=', 'selesai')
            ->first();

        if ($sudahAda) {
            return redirect()->back()
                ->with('error', 'Jadwal bertabrakan dengan agenda: "' . $sudahAda->nama_rapat . '"');
        }

        $jadwal = ProfilPegawai::join('users', 'profil_pegawai.nip_nipppk_nrpk_nrpblud', '=', 'users.username')
            ->select('profil_pegawai.id as pic')
            ->where('users.username', $request->pic)
            ->first();

        JadwalRapat::create([
            'uuid'           => Str::uuid(),
            'id_ruang'       => $request->id_ruang,
            'pegawai_id'     => $jadwal->pic,
            'nama_rapat'     => $request->nama_rapat,
            'tanggal'        => $request->tanggal,
            'jam_mulai'      => $request->jam_mulai,
            'jam_selesai'    => $request->jam_selesai,
            'jumlah_peserta' => $request->jumlah_peserta,
            'jumlah_snack'   => $request->jumlah_snack,
            'jumlah_makan'   => $request->jumlah_makan,
            'status'         => $request->status
        ]);

        return redirect()->back()->with('success', 'Rapat sudah dijadwalkan');
    }
}
