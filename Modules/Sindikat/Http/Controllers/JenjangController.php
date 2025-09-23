<?php

namespace Modules\Sindikat\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Sindikat\Entities\Jenjang;

class JenjangController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        
        $jenjangs = Jenjang::latest()->get();

        return view('sindikat::jenjang.index', compact('jenjangs'));
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

    public function store_api(Request $request)
    {
        // Validasi data
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
        ]);

        // Simpan data atau lakukan sesuatu (contoh menyimpan ke database diabaikan untuk sederhana)
        try {
            Jenjang::create([
                'nama' => $request->nama,
            ]);
        
            return response()->json([
                'success' => true,
                'message' => 'Data saved successfully',
            ], 201); // Status 201 untuk data berhasil dibuat
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to save data',
                'error' => $e->getMessage(),
            ], 500); // Status 500 untuk kesalahan server
        }
    }
    public function store(Request $request)
    {
        
        $request->validate([
            'nama'     => 'required|string|max:255',
        ]);

        Jenjang::create([
            'nama'     => $request->nama,
        ]);

        return redirect()->back()->with('success', 'Data Jenjang Baru berhasil disimpan');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('sindikat::show');
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
        
        $request->validate([
            'nama'     => 'required|string|max:255',
        ]);

        $jenjang = Jenjang::findOrFail($id);

        $jenjang->update([
            'nama'     => $request->nama,
        ]);

        return redirect()->back()->with('success', 'Data Jenjang berhasil disimpan');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        
        $jenjang = Jenjang::find($id);
        
        if ($jenjang) {
            $jenjang->delete();

            return redirect()->back()->with('success', 'Jenjang berhasil dihapus.');
        } else {
            return redirect()->back()->with('error', 'Jenjang tidak ditemukan.');
        }
    }
    public function getJenjangs()
    {
        $jenjang = Jenjang::all();
        return response()->json($jenjang);
    }
}
