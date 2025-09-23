<?php

namespace Modules\Sindikat\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Sindikat\Entities\Kategori;
use Modules\Sindikat\Entities\Arsip;
use Modules\Sindikat\Entities\ArsipFile;
use Illuminate\Support\Str;

class ArsipController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index($param = null)
    {
        $cari = request('cari');
        $jenis = 0;
        $nama = "";
        if($param == "materi"){
            $jenis = 1;
            $nama = "Materi";
        }else if($param == "dokumentasi"){
            $jenis = 2;
            $nama = "Dokumentasi";
        }else{
            $nama = "Materi / Dokumentasi";
        }
        if(!empty($cari)){
            $arsips = Arsip::with(['kategori', 'get_thumbnail'])->where('judul', 'like',"%".$cari."%")->latest()->paginate(15);
            $arsip_count = Arsip::with(['kategori', 'get_thumbnail'])->where('judul', 'like',"%".$cari."%")->count();
        }else{
            $arsips = Arsip::with(['kategori', 'get_thumbnail'])->where(['jenis' => $jenis])->latest()->paginate(15);
            $arsip_count = Arsip::with(['kategori', 'get_thumbnail'])->where(['jenis' => $jenis])->count();
        }

        // dd($arsips);
        return view('sindikat::arsip.index', compact('arsips', 'arsip_count','nama'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $categories = Kategori::latest()->get();
        return view('sindikat::arsip.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'content' => 'required|string',
            'file_deskripsi.*' => 'required|string|max:255',
        ]);

        $arsip = new Arsip();
        $arsip->judul = $request->judul;
        $arsip->slug = rand(10,100)."-".Str::slug($request->judul, '-');
        $arsip->content = $request->content;
        $arsip->kategori_id = $request->kategori_id;
        $arsip->jenis = $request->jenis;

        $arsip->save();

        $arsip = Arsip::latest()->first();

        if ($request->hasFile('file')) {
            foreach ($request->file('file') as $key => $file) {
                $fileArsip = new ArsipFile();
                $fileArsip->deskripsi = $request->file_deskripsi[$key];
                $fileName = time() . '_' . $key . '.' . $file->getClientOriginalExtension();
                $file->storeAs('public/sindikat/file_arsip', $fileName);
                $fileArsip->file = $fileName;
                $fileArsip->arsip_id = $arsip->id;
                $fileArsip->save();
            }
        }

        return redirect()->route('sindikat.arsip.create')->with(['success' => 'Data Arsip Berhasil disimpan']);
 
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($slug)
    {
        $arsip = Arsip::with(['arsip_file'])->where(['slug' => $slug])->first();

        // dd($arsip);
        return view('sindikat::arsip.show', compact('arsip'));
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
        $arsip = Arsip::findOrFail($id);


        $arsip->update([
            'judul' => $request->judul,
            'slug' => rand(10,100)."-".Str::slug($request->judul, '-'),
            'content' => $request->content,
        ]);

        return redirect()->route('sindikat.arsip.show',$arsip->slug)->with(['success' => 'Data Arsip Berhasil Disimpan']);
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        $arsip = Arsip::find($id);
        
        if ($arsip) {
            $arsip->delete();

            return redirect()->back()->with('success', 'Data Arsip berhasil dihapus');
        } else {
            return redirect()->back()->with('error', 'Data Arsip tidak ditemukan');
        } 
    }
}
