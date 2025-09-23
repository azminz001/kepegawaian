<?php

namespace Modules\Sindikat\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Sindikat\Entities\ArsipFile;

class ArsipFileController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('sindikat::index');
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
        // dd($request);
        $fileArsip = new ArsipFile();
        $fileArsip->deskripsi = $request->deskripsi;
        $file = $request->file;
        $fileName = time() . '_' . $request->deskripsi.'.' . $file->getClientOriginalExtension();
        $file->storeAs('public/sindikat/file_arsip', $fileName);
        $fileArsip->file = $fileName;
        $fileArsip->arsip_id = $request->arsip_id;
        $fileArsip->save();

        return redirect()->back()->with(['success' => 'Data File Arsip Media Berhasil disimpan']);

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
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        $file_arsip = ArsipFile::find($id);
        
        if ($file_arsip) {
            \Storage::delete('public/sindikat/file_arsip/'.$file_arsip->file);
            $file_arsip->delete();

            return redirect()->back()->with('success', 'Data Media berhasil dihapus');
        } else {
            return redirect()->back()->with('error', 'Data Media tidak ditemukan');
        } 
    }
}
