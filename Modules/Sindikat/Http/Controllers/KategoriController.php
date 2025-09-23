<?php

namespace Modules\Sindikat\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Sindikat\Entities\Kategori;
use Modules\Sindikat\Entities\Arsip;

class KategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $categories = Kategori::latest()->get();

        return view('sindikat::kategori.index', compact('categories'));
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
            'nama'     => 'required|string|max:255',
        ]);

        Kategori::create([
            'nama'     => $request->nama,
            'slug'     => $request->slug,
            'keterangan'   => $request->keterangan
        ]);

        return redirect()->back()->with('success', 'Data Kategori Baru berhasil disimpan');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($slug)
    {
        $category = Kategori::where(['slug' => $slug])->first();

        $arsips = Arsip::with(['kategori', 'get_thumbnail'])->where(['kategori_id' => $category->id])->latest()->paginate(15);
        $arsip_count = Arsip::with(['kategori', 'get_thumbnail'])->where(['kategori_id' => $category->id])->count();

        return view('sindikat::kategori.show', compact('category', 'arsips', 'arsip_count'));
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
            'nama' => 'required|string|max:255',
        ]);

        $category = Kategori::findOrFail($id);

        $category->update([
            'nama'     => $request->nama,
            'slug'     => $request->slug,
            'keterangan'   => $request->keterangan
        ]);

        return redirect()->back()->with(['success' => 'Data Berhasil Diubah!']);
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        $category = Kategori::find($id);
        
        if ($category) {
            $category->delete();

            return redirect()->back()->with('success', 'Kategori berhasil dihapus.');
        } else {
            return redirect()->back()->with('error', 'Kategori tidak ditemukan.');
        }
    }
}
