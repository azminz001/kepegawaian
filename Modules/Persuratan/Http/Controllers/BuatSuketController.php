<?php

namespace Modules\Persuratan\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

use Modules\Persuratan\Entities\Nomor;
use Modules\Persuratan\Entities\Suket;
use Modules\Persuratan\Entities\BuatSuket;
use Modules\Kepegawaian\Entities\ProfilPegawai;

class BuatSuketController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $user = Auth::user();

        if ($user->level == 2) {
            $pegawai = ProfilPegawai::where('nip_nipppk_nrpk_nrpblud', $user->username)->first();

            if (!$pegawai) {
                // Jika tidak ditemukan, kamu bisa redirect atau berikan pesan error
                return redirect()->back()->with('error', 'Data pegawai tidak ditemukan.');
            }
            $idPegawai = $pegawai->id;

            $keyword = request('cari'); // Ambil keyword dari input "cari"

            // Ambil data pengajuan dengan join dan filter jika ada pencarian
            $pengajuanQuery = BuatSuket::join('surat_keterangan', 'buat_suket.id_suket', '=', 'surat_keterangan.id_suket')
                ->join('db_kepegawaian.profil_pegawai', 'buat_suket.pegawai_id', '=', 'profil_pegawai.id')
                ->leftJoin('penomoran', 'buat_suket.id_penomoran', '=', 'penomoran.id')
                ->leftJoin('klasifikasi', 'surat_keterangan.id_klasifikasi', '=', 'klasifikasi.id') // join klasifikasi
                ->where('buat_suket.pegawai_id', $idPegawai)
                ->select(
                    'surat_keterangan.*',
                    'buat_suket.*',
                    'buat_suket.id as id_pengajuan',
                    'db_kepegawaian.profil_pegawai.*',
                    'penomoran.nomor',
                    'penomoran.bulan',
                    'penomoran.tahun',
                    'klasifikasi.kode'
                )
                ->orderBy('buat_suket.tanggal_pengajuan', 'desc');

            if ($keyword) {
                $pengajuanQuery->where('surat_keterangan.nama_suket', 'like', '%' . $keyword . '%')->orderBy('buat_suket.tanggal_pengajuan', 'desc');;
            }

            $pengajuan = $pengajuanQuery->paginate(10);

            // Ambil daftar surat keterangan
            $surat_keterangan_list = Suket::orderBy('id_suket', 'asc')->get();

            // Ambil pendidikan terakhir
            $pendidikan = DB::table('riwayat_pendidikan')
                ->join('jenjang_pendidikan', 'riwayat_pendidikan.jenjang_pendidikan_id', '=', 'jenjang_pendidikan.id')
                ->where('riwayat_pendidikan.pegawai_id', $pegawai->id)
                ->where('riwayat_pendidikan.is_pendidikan_terakhir', 1)
                ->select('riwayat_pendidikan.*', 'jenjang_pendidikan.nama')
                ->first();

            // Ambil jabatan terakhir
            $jabatan = DB::table('riwayat_jabatan')
                ->join('jabatan', 'riwayat_jabatan.jabatan_id', '=', 'jabatan.id')
                ->where('riwayat_jabatan.pegawai_id', $pegawai->id)
                ->where('riwayat_jabatan.is_jabatan_terakhir', 1)
                ->select('riwayat_jabatan.*', 'jabatan.nama')
                ->first();

            // Siapkan array isi surat dengan placeholder yang diganti
            $daftar_isi = [];

            foreach ($surat_keterangan_list as $suket) {
                // Cek tmt_rsud
                if (empty($pegawai->tmt_rsud)) {
                    $tmt_rsud = new HtmlString('<span style="background-color: #ffcccc; color: red; font-weight: bold; padding: 2px 4px; border-radius: 4px;">ANDA BELUM MELENGKAPI DATA !</span>');
                } else {
                    $tmt_rsud = Carbon::parse($pegawai->tmt_rsud)->translatedFormat('d F Y');
                }

                // Cek jabatan
                if (empty($jabatan) || empty($jabatan->nama)) {
                    $nama_jabatan = new HtmlString('<span style="background-color: #ffcccc; color: red; font-weight: bold; padding: 2px 4px; border-radius: 4px;">ANDA BELUM MELENGKAPI DATA !</span>');
                } else {
                    $nama_jabatan = $jabatan->nama;
                }

                // Lakukan replace dengan nilai yang sudah diperiksa
                $isi = str_replace(
                    ['[tmt_rsud]', '[jabatan]'],
                    [$tmt_rsud, $nama_jabatan],
                    $suket->isi
                );

                $daftar_isi[] = [
                    'suket' => $suket,
                    'isi' => $isi,
                ];
            }

            $isLengkap = true;

            if (
                empty($pegawai->nama) ||
                empty($pegawai->nip_nipppk_nrpk_nrpblud) ||
                empty($pegawai->tempat_lahir) ||
                empty($pegawai->tanggal_lahir) ||
                empty($pegawai->tmt_rsud) ||
                empty($pendidikan->nama) ||
                empty($pendidikan->jurusan) ||
                empty($pegawai->tmt_rsud) ||
                empty($jabatan->nama)
            ) {
                $isLengkap = false;
            }

            return view('Persuratan::buat_suket.index', compact(
                'daftar_isi',
                'pegawai',
                'pendidikan',
                'jabatan',
                'isLengkap',
                'pengajuan'
            ));
        } else {
            $keyword = request('cari'); // Ambil keyword dari input "cari"

            // Ambil data pengajuan dengan join dan filter jika ada pencarian
            $pengajuanQuery = BuatSuket::join('surat_keterangan', 'buat_suket.id_suket', '=', 'surat_keterangan.id_suket')
                ->join('db_kepegawaian.profil_pegawai', 'buat_suket.pegawai_id', '=', 'profil_pegawai.id')
                ->leftJoin('penomoran', 'buat_suket.id_penomoran', '=', 'penomoran.id')
                ->leftJoin('klasifikasi', 'surat_keterangan.id_klasifikasi', '=', 'klasifikasi.id') // join klasifikasi
                ->select(
                    'surat_keterangan.*',
                    'buat_suket.*',
                    'buat_suket.id as id_pengajuan',
                    'db_kepegawaian.profil_pegawai.*',
                    'penomoran.nomor',
                    'penomoran.bulan',
                    'penomoran.tahun',
                    'klasifikasi.kode'
                )
                ->orderBy('buat_suket.tanggal_pengajuan', 'desc');

            if ($keyword) {
                $pengajuanQuery->where('db_kepegawaian.profil_pegawai.nama', 'like', '%' . $keyword . '%')->orderBy('buat_suket.tanggal_pengajuan', 'desc');
            }

            $pengajuan = $pengajuanQuery->paginate(10);

            return view('Persuratan::buat_suket.index', compact(
                'pengajuan'
            ));
        }
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $tanggalHariIni = now()->toDateString();

        // Cek apakah sudah ada pengajuan dengan kombinasi yang sama
        $sudahAda = BuatSuket::where('pegawai_id', $request->pegawai_id)
            ->where('id_suket', $request->id_suket)
            ->whereDate('tanggal_pengajuan', $tanggalHariIni)
            ->exists();

        if ($sudahAda) {
            return redirect()->back()->with('error', 'Surat yang sama sudah diajukan hari ini, silahkan pantau kolom status');
        }

        BuatSuket::create([
            'id_suket'            => $request->id_suket,
            'pegawai_id'          => $request->pegawai_id,
            'tanggal_pengajuan'   => now()
        ]);

        return redirect()->back()->with('success', 'Surat Berhasil Diajukan.');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        $suket = BuatSuket::find($id);

        if ($suket) {
            $suket->delete();

            return redirect()->back()->with('success', 'Surat berhasil dihapus.');
        } else {
            return redirect()->back()->with('error', 'Surat tidak ditemukan.');
        }
    }

    public function preview($id)
    {
        //$suket = BuatSuket::with([])->where('id_suket', $id)->firstOrFail();

        $suket = BuatSuket::join('surat_keterangan', 'buat_suket.id_suket', '=', 'surat_keterangan.id_suket')
            ->where('buat_suket.id', $id)->firstOrFail();

        $pegawai = ProfilPegawai::join('db_persuratan.buat_suket', 'profil_pegawai.id', '=', 'db_persuratan.buat_suket.pegawai_id')
            ->where('db_persuratan.buat_suket.id', $id)
            ->first();

        $pendidikan = DB::table('riwayat_pendidikan')
            ->join('jenjang_pendidikan', 'riwayat_pendidikan.jenjang_pendidikan_id', '=', 'jenjang_pendidikan.id')
            ->where('riwayat_pendidikan.pegawai_id', $pegawai->pegawai_id)
            ->where('riwayat_pendidikan.is_pendidikan_terakhir', 1)
            ->select('riwayat_pendidikan.*', 'jenjang_pendidikan.nama')
            ->first();

        $jabatan = DB::table('riwayat_jabatan')
            ->join('jabatan', 'riwayat_jabatan.jabatan_id', '=', 'jabatan.id')
            ->where('riwayat_jabatan.pegawai_id', $pegawai->pegawai_id)
            ->where('riwayat_jabatan.is_jabatan_terakhir', 1)
            ->select('riwayat_jabatan.*', 'jabatan.nama')
            ->first();

        $isiSurat = $suket->isi;
        $isiSurat = str_replace('[jabatan]', $jabatan->nama ?? '', $isiSurat);
        $isiSurat = str_replace('[tmt_rsud]', Carbon::parse($pegawai->tmt_rsud ?? now())->translatedFormat('d F Y'), $isiSurat);

        // Gunakan output buffering
        ob_start();
?>
        <table width="100%">
            <tbody>
                <tr>
                    <td width="12%"><img src="<?= url('assets/images/LogoKabupatenBrebes.png') ?>" width="100%"></td>
                    <td>
                        <p
                            style="font-family: 'Bookman Old Style', serif; font-size: 14pt; text-align: center; font-weight: bold;">
                            PEMERINTAH KABUPATEN BREBES<br>
                            DINAS KESEHATAN DAERAH<br>
                            UNIT ORGANISASI BERSIFAT KHUSUS RSUD BREBES<br>
                        </p>
                        <p
                            style="font-family: 'Bookman Old Style', serif; font-size: 7pt; text-align: center;">
                            Jalan Jenderal Sudirman Nomor 181 Brebes Telepon (0283) 671431 Faksimile
                            (0283) 671095
                        </p>
                        <p
                            style="font-family: 'Bookman Old Style', serif; font-size: 7pt; text-align: center;">
                            Pos-el rsudbrebes@gmail.com
                        </p>
                    </td>
                </tr>
            </tbody>
        </table>
        <hr style="border: none; border-top: 4px solid black; margin: 0;">
        <br>
        <p style="text-align:center; font-weight:bold; font-family:'Bookman Old Style', serif; font-size:11pt;">
            <?= $suket->nama_suket ?><br>
            Nomor : XXX/XXX/XXX/XXXX
        </p>
        <br>
        <p style="font-family:'Bookman Old Style', serif; font-size:11pt;">Yang bertanda tangan di bawah ini:</p>
        <table style="width:100%; font-size:11pt; font-family:'Bookman Old Style', serif;">
            <tr>
                <td width="30%">Nama</td>
                <td>:</td>
                <td>Dr. dr. Rasipin, M.Kes, MARS</td>
            </tr>
            <tr>
                <td>NIP</td>
                <td>:</td>
                <td>19681125 200212 1 002</td>
            </tr>
            <tr>
                <td>Jabatan</td>
                <td>:</td>
                <td>Direktur</td>
            </tr>
            <tr>
                <td>Unit Kerja</td>
                <td>:</td>
                <td>RSUD Brebes</td>
            </tr>
        </table>
        <br>
        <p style="font-family:'Bookman Old Style', serif; font-size:11pt;">Dengan ini menerangkan bahwa Saudara/i:</p>
        <table style="width:100%; font-size:11pt; font-family:'Bookman Old Style', serif;">
            <tr>
                <td width="30%">Nama</td>
                <td>:</td>
                <td><?= $pegawai?->gelar_depan ? $pegawai->gelar_depan . '. ' : '' ?><?= Str::title(strtolower($pegawai?->nama)) ?><?= $pegawai?->gelar_belakang ? ', ' . $pegawai->gelar_belakang : '' ?></td>
            </tr>
            <tr>
                <td>NIP/NRP</td>
                <td>:</td>
                <td><?= $pegawai->nip_nipppk_nrpk_nrpblud ?></td>
            </tr>
            <tr>
                <td>Tempat, Tanggal Lahir</td>
                <td>:</td>
                <td><?= Str::title(strtolower($pegawai->tempat_lahir)) ?>, <?= Carbon::parse($pegawai->tanggal_lahir)->translatedFormat('d F Y') ?></td>
            </tr>
            <tr>
                <td>Pendidikan</td>
                <td>:</td>
                <td><?= $pendidikan?->nama ?> <?= $pendidikan?->jurusan ?></td>
            </tr>
            <tr>
                <td>Jabatan</td>
                <td>:</td>
                <td><?= $jabatan?->nama ?></td>
            </tr>
        </table>
        <br>
        <p style="text-align:justify; font-family:'Bookman Old Style', serif; font-size:11pt;">
            <?= nl2br($isiSurat) ?>
        </p>
        <br>
        <p style="text-align:justify; font-family:'Bookman Old Style', serif; font-size:11pt;">
            Demikian surat ini dibuat untuk digunakan sebagaimana mestinya.
        </p>
        <br>
        <table width="100%" style="text-align:center; font-family:'Bookman Old Style', serif; font-size:11pt;">
            <tr>
                <td width="50%"></td>
                <td>Brebes, XX XX XXXX</td>
            </tr>
            <tr>
                <td></td>
                <td>Direktur RSUD Brebes<br><br><br><br>Dr. dr. Rasipin, M.Kes, MARS<br>NIP. 19681125 200212 1 002</td>
            </tr>
        </table>
        <br>
        <form action="<?= route('persuratan.buat_suket.setujui', ['id' => $suket->id]) ?>" method="POST">
            <?= csrf_field() ?>
            <button style="width: 100%;" type="submit" class="btn btn-success">
                SETUJUI DAN CETAK
            </button>
        </form>
<?php

        $html = ob_get_clean();

        return response($html);
    }

    public function update(Request $request, $id)
    {
        $suket = BuatSuket::where('id', $id)->firstOrFail();

        $suket->status = 'ditolak';
        $suket->keterangan = $request->keterangan;
        $suket->save();

        return redirect()->back()->with('success', 'Surat berhasil ditolak.');
    }

    public function upload(Request $request, $id)
    {
        $request->validate([
            'file' => 'required|mimes:pdf|max:2048',
        ]);

        $surat = BuatSuket::where('id', $id)->firstOrFail();
        $pegawai = ProfilPegawai::where('id', $surat->pegawai_id)->first();

        $file = $request->file('file');
        $nama_pegawai = Str::slug($pegawai->nama);
        $fileName = 'suket_' . $nama_pegawai . '_' . Str::uuid() . '.' . $file->getClientOriginalExtension();
        $file->storeAs('public/persuratan/penomoran', $fileName);

        $surat->update([
            'file' => $fileName,
            'status' => 'selesai',
        ]);

        return redirect()->back()->with('success', 'File berhasil diunggah.');
    }

    public function download($id)
    {
        $surat = BuatSuket::where('id', $id)->firstOrFail();

        if (!$surat->file) {
            return redirect()->back()->with('error', 'File belum tersedia.');
        }

        $filePath = 'public/persuratan/penomoran/' . $surat->file;

        if (!Storage::exists($filePath)) {
            return redirect()->back()->with('error', 'File tidak ditemukan di server.');
        }

        return Storage::download($filePath, $surat->file, [
            'Content-Type' => 'application/pdf'
        ]);
    }

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

    public function setujui(Request $request, $id)
    {
        $surat = BuatSuket::findOrFail($id);
        // Cek apakah surat sudah memiliki tanggal_terbit
        if (!is_null($surat->tanggal_terbit)) {
            return redirect()->route('buat_suket.cetak', ['id' => $id])
                ->with('info', 'Surat sudah pernah diterbitkan, langsung diarahkan ke cetak.');
        }

        $bulan = $this->angkaKeRomawi(Carbon::now()->format('m'));

        $nomor_terakhir = Nomor::where('tahun', Nomor::max('tahun'))->max('nomor');
        $nomor_baru = $nomor_terakhir + 1;

        $data = BuatSuket::join('db_kepegawaian.profil_pegawai', 'buat_suket.pegawai_id', '=', 'profil_pegawai.id')
            ->join('surat_keterangan', 'buat_suket.id_suket', '=', 'surat_keterangan.id_suket')
            ->join('db_kepegawaian.users', 'profil_pegawai.nip_nipppk_nrpk_nrpblud', '=', 'users.username')
            ->where('buat_suket.id', $id)
            ->select('buat_suket.*', 'profil_pegawai.*', 'surat_keterangan.*', 'users.id as id_user')
            ->firstOrFail();

        Nomor::create([
            'id_user'        => $data->id_user,
            'id_klasifikasi' => $data->id_klasifikasi,
            'nomor'          => $nomor_baru,
            'bulan'          => $bulan,
            'tahun'          => now()->year,
            'nama_surat'     => $data->nama_suket . ' ' . $data->nama,
            'tanggal_surat'  => now(),
            'status'         => "DIAMBIL",
        ]);

        $id_nomor = Nomor::max('id');

        $surat->update([
            'id_penomoran' => $id_nomor,
            'status'       => 'diproses',
            'tanggal_terbit' => now(),
        ]);

        // Redirect ke cetak dan tandai bahwa ini dari persetujuan
        return redirect()->route('buat_suket.cetak', ['id' => $id])
            ->with('from_setujui', true)
            ->with('success', 'Surat berhasil disetujui dan dicetak.');
    }

    public function cetak($id)
    {
        $surat = BuatSuket::join('surat_keterangan', 'buat_suket.id_suket', '=', 'surat_keterangan.id_suket')
            ->join('db_kepegawaian.profil_pegawai', 'buat_suket.pegawai_id', '=', 'profil_pegawai.id')
            ->leftJoin('penomoran', 'buat_suket.id_penomoran', '=', 'penomoran.id')
            ->leftJoin('klasifikasi', 'surat_keterangan.id_klasifikasi', '=', 'klasifikasi.id') // join klasifikasi
            ->where('buat_suket.id', $id)
            ->select(
                'surat_keterangan.*',
                'buat_suket.*',
                'buat_suket.id as id_pengajuan',
                'db_kepegawaian.profil_pegawai.*',
                'penomoran.nomor',
                'penomoran.bulan',
                'penomoran.tahun',
                'klasifikasi.kode'
            )->first();

        if (!$surat) {
            return redirect()->back()->with('error', 'Belum ada pengajuan surat.');
        }

        $pegawai = BuatSuket::join('db_kepegawaian.profil_pegawai', 'db_kepegawaian.profil_pegawai.id', '=', 'buat_suket.pegawai_id')
            ->where('buat_suket.pegawai_id', $surat->pegawai_id)
            ->select('buat_suket.*', 'db_kepegawaian.profil_pegawai.*')
            ->first();

        if (!$pegawai) {
            return redirect()->back()->with('error', 'Data pegawai tidak ditemukan.');
        }

        // Pendidikan terakhir
        $pendidikan = DB::table('riwayat_pendidikan')
            ->join('jenjang_pendidikan', 'riwayat_pendidikan.jenjang_pendidikan_id', '=', 'jenjang_pendidikan.id')
            ->where('riwayat_pendidikan.pegawai_id', $pegawai->pegawai_id)
            ->where('riwayat_pendidikan.is_pendidikan_terakhir', 1)
            ->select('riwayat_pendidikan.*', 'jenjang_pendidikan.nama')
            ->first();

        // Jabatan terakhir
        $jabatan = DB::table('riwayat_jabatan')
            ->join('jabatan', 'riwayat_jabatan.jabatan_id', '=', 'jabatan.id')
            ->where('riwayat_jabatan.pegawai_id', $pegawai->pegawai_id)
            ->where('riwayat_jabatan.is_jabatan_terakhir', 1)
            ->select('riwayat_jabatan.*', 'jabatan.nama')
            ->first();

        // Ganti placeholder
        $tmt_rsud = $pegawai->tmt_rsud
            ? Carbon::parse($pegawai->tmt_rsud)->translatedFormat('d F Y')
            : '[TMT Tidak tersedia]';

        $nama_jabatan = $jabatan?->nama ?? '[Jabatan Tidak tersedia]';

        $isiSurat = str_replace(
            ['[tmt_rsud]', '[jabatan]'],
            [$tmt_rsud, $nama_jabatan],
            $surat->isi
        );

        return view('Persuratan::buat_suket.cetak', compact(
            'pegawai',
            'pendidikan',
            'jabatan',
            'isiSurat',
            'surat'
        ));
    }
}
