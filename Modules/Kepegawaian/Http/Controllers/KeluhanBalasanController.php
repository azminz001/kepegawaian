<?php

namespace Modules\Kepegawaian\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

use Modules\Kepegawaian\Entities\KeluhanBalasan;

class KeluhanBalasanController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('kepegawaian::index');
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
            'balasan'              => 'required',
        ]);
        $user_id = Auth::user()->id;

        // dd($request);
        if ($request->hasFile('gambar')) {
            $gambar = $request->file('gambar');
            $nama_file = $gambar->getClientOriginalName(); // Menggunakan nama file asli untuk menyimpan file
            if ($gambar->getSize() > 2097152) {
                $ukuran = 2097152 / 1024 / 1024;
                return redirect()->back()->with(['error' =>'Ukuran File terlalu besar. Pastikan File tidak lebih dari '.$ukuran.' MB']);
            }
    
            // Simpan file ke direktori
            $gambar->storeAs('public/kepegawaian/keluhan/', $nama_file);
    
            // Update data pegawai dengan nama file yang baru
            $keluhan = KeluhanBalasan::create([
                'balasan' => $request->balasan,
                'user_id' => $user_id,
                'keluhan_id' => $request->keluhan_id,
                'gambar' => $nama_file
            ]);
    
            return redirect()->back()->with(['success' => 'Data Tanggapan Anda Berhasil Disimpan']);
        } else {
            KeluhanBalasan::create([
                'balasan' => $request->balasan,
                'keluhan_id' => $request->keluhan_id,
                'user_id' => $user_id,
            ]);
    
            return redirect()->back()->with(['success' => 'Data Tanggapan Anda Berhasil Disimpan']);
        }
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
    public function destroy($id)
    {
        $reply = KeluhanBalasan::find($id);
        
        if ($reply) {

            \Storage::delete('public/kepegawaian/keluhan/' . $reply->gambar);

            $reply->delete();

            return redirect()->back()->with('success', 'Tanggapan berhasil dihapus');
        } else {
            return redirect()->back()->with('error', 'Tanggapan tidak ditemukan');
        }
        
    }
}
