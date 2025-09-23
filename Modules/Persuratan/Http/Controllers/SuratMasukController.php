<?php

namespace Modules\Persuratan\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

use Modules\Persuratan\Entities\SuratMasuk;


class SuratMasukController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {

        $cari = request('cari');
        $user = Auth::user();

        if (!empty($cari)) {
            $surats = SuratMasuk::where('nomor', 'like', "%" . $cari . "%")
                ->orWhere('perihal', 'like', "%" . $cari . "%")
                ->orWhere('dari', 'like', "%" . $cari . "%")
                ->orWhere('sifat', 'like', "%" . $cari . "%")
                ->orWhere('tanggal_surat', 'like', "%" . $cari . "%")
                ->orWhere('tanggal_terima', 'like', "%" . $cari . "%")
                ->latest()
                ->paginate(20);

            $surat_count = SuratMasuk::where('nomor', 'like', "%" . $cari . "%")
                ->orWhere('perihal', 'like', "%" . $cari . "%")
                ->orWhere('dari', 'like', "%" . $cari . "%")
                ->orWhere('sifat', 'like', "%" . $cari . "%")
                ->orWhere('tanggal_surat', 'like', "%" . $cari . "%")
                ->orWhere('tanggal_terima', 'like', "%" . $cari . "%")
                ->count();
        } else {
            $surats = SuratMasuk::latest()->paginate(20);
            $surat_count = SuratMasuk::all()->count();
        }

        return view('Persuratan::surat_masuk.index', compact('surats', 'surat_count'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $sudahAda = SuratMasuk::where('nomor', $request->nomor)
            ->exists();

        if ($sudahAda) {
            return redirect()->back()->with('error', 'Surat yang sama sudah diinput');
        }

        // Validasi file
        $request->validate([
            'file' => 'required|file|mimes:pdf|max:2048',  // Maksimal 2MB (2048 KB)
        ], [
            'file.mimes' => 'File yang diunggah harus berupa PDF.',
            'file.max' => 'Ukuran file tidak boleh lebih dari 2MB.',
        ]);

        $file = $request->file('file');

        $filename = str_replace(' ', '_', $file->getClientOriginalName());
        $filename = time() . '_' . $filename;

        $file->storeAs('public/persuratan/surat_masuk/', $filename);

        SuratMasuk::create([
            'id_user'        => $request->id_user,
            'nomor'          => $request->nomor,
            'perihal'        => $request->perihal,
            'dari'           => $request->dari,
            'sifat'          => $request->sifat,
            'tanggal_surat'  => $request->tanggal_surat,
            'tanggal_terima' => now(),
            'file'           => $filename
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
        $surat = SuratMasuk::findOrFail($id);

        if ($request->hasFile('file')) {
            $request->validate([
                'file' => 'required|file|mimes:pdf|max:2048',  // Maksimal 2MB (2048 KB)
            ], [
                'file.mimes' => 'File yang diunggah harus berupa PDF.',
                'file.max' => 'Ukuran file tidak boleh lebih dari 2MB.',
            ]);

            $filePath = storage_path('app/public/persuratan/surat_masuk/' . $surat->file);

            if (file_exists($filePath)) {
                unlink($filePath);
            }

            $file = $request->file('file');

            $filename = str_replace(' ', '_', $file->getClientOriginalName());
            $filename = time() . '_' . $filename;

            $file->storeAs('public/persuratan/surat_masuk/', $filename);

            $surat->update([
                'id_user'        => $request->id_user,
                'nomor'          => $request->nomor,
                'perihal'        => $request->perihal,
                'dari'           => $request->dari,
                'sifat'          => $request->sifat,
                'tanggal_surat'  => $request->tanggal_surat,
                'tanggal_terima' => $surat->tanggal_terima,
                'file'           => $filename,
                'disposisi'      => $request->disposisi
            ]);
        } else {
            $surat->update([
                'id_user'        => $request->id_user,
                'nomor'          => $request->nomor,
                'perihal'        => $request->perihal,
                'dari'           => $request->dari,
                'sifat'          => $request->sifat,
                'tanggal_surat'  => $request->tanggal_surat,
                'tanggal_terima' => $surat->tanggal_terima,
                'disposisi'      => $request->disposisi
            ]);
        }

        return redirect()->back()->with(['success' => 'Data Berhasil Diubah!']);
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        // Temukan entri SuratMasuk berdasarkan ID
        $surat_masuk = SuratMasuk::find($id);

        if ($surat_masuk) {
            // Dapatkan nama file dari entri SuratMasuk
            $filePath = storage_path('app/public/persuratan/surat_masuk/' . $surat_masuk->file);

            // Hapus file jika ada
            if (file_exists($filePath)) {
                unlink($filePath);
            }

            // Hapus entri dari database
            $surat_masuk->delete();

            return redirect()->back()->with('success', 'Surat berhasil dihapus.');
        } else {
            return redirect()->back()->with('error', 'Surat tidak ditemukan.');
        }
    }
}
