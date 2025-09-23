<?php

namespace Modules\Sindikat\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Kepegawaian\Entities\ProfilPegawai;
use Modules\Kepegawaian\Entities\PegawaiCI;

class LandingController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('sindikat::index');
    }

    public function profil_diklat(){
        return view('sindikat::landing.about_diklat');
    }
    public function profil_litbang(){
        return view('sindikat::landing.about_litbang');
    }

    public function so(){
        return view('sindikat::landing.so');
    }

    public function clinical_instructure()
    {
        $pegawais = ProfilPegawai::with(['instruktur_klinik'=>function($q){
            $q->where('status', 1);
        },'jabatan_aktif', 'unit_jabatan_aktif'])
        ->whereHas('instruktur_klinik', function ($query) {
            $query->where('status', 1);
        })->whereHas('jabatan_aktif')->whereHas('unit_jabatan_aktif')
        ->orderBy('nama', 'ASC')->get();

        return view('sindikat::landing.clinical_instructure', compact('pegawais'));
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
        //
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
        //
    }
}
