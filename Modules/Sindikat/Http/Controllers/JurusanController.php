<?php

namespace Modules\Sindikat\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Sindikat\Entities\Jurusan;


class JurusanController extends Controller
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
        
        $request->validate([
            'nama'     => 'required|string|max:255',
        ]);

        Jurusan::create([
            'nama'     => $request->nama,
            'institusi_id' => $request->institusi_id,
            'jenjang_id' => $request->jenjang_id
        ]);

        return redirect()->back()->with('success', 'Data Jurusan Baru berhasil disimpan');

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
        $jurusan = Jurusan::findOrFail($id);
        return response()->json($jurusan);
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

        $jurusan = Jurusan::findOrFail($id);

        $jurusan->update([
            'nama'     => $request->nama,
            'jenjang_id'     => $request->jenjang_id,
        ]);

        return redirect()->back()->with('success', 'Data Jurusan berhasil disimpan');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }
}
