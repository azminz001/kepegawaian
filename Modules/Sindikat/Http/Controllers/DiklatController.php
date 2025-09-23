<?php

namespace Modules\Sindikat\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;


use Maatwebsite\Excel\Concerns\FromCollection;

use Modules\Kepegawaian\Entities\RiwayatDiklat;
use Modules\Kepegawaian\Entities\ProfilPegawai;

use App\Exports\DiklatExport;
use Maatwebsite\Excel\Facades\Excel;


class DiklatController extends Controller 
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $cari = request('cari');
        if (!empty($cari)) {
            $diklats = RiwayatDiklat::whereHas('pegawai', function ($q) use ($cari) {
                $q->where('nama', 'like', "%" . $cari . "%");
            })
            ->with(['pegawai' => function ($q) {
                $q->with('pendidikan_terakhir', 'unit_jabatan_aktif');
            }])
            ->orderBy('tanggal_selesai', 'DESC')
            ->paginate(25);

            // dd($diklats);
        }else {
            $diklats = RiwayatDiklat::with(['pegawai' => function ($q) {
                $q->with('pendidikan_terakhir', 'unit_jabatan_aktif');
            }])
            ->orderBy('tanggal_selesai', 'DESC')
            ->paginate(25);
        }

        $total_arsip_diklat = RiwayatDiklat::count();
        $currentYear = date('Y');
        $diklat_count = RiwayatDiklat::selectRaw('
                            COUNT(CASE WHEN YEAR(tanggal_selesai) = ? THEN 1 END) as year_current,
                            COUNT(CASE WHEN YEAR(tanggal_selesai) = ? THEN 1 END) as year_previous,
                            COUNT(CASE WHEN YEAR(tanggal_selesai) = ? THEN 1 END) as year_two_years_ago
                        ', [
                            $currentYear,
                            $currentYear - 1,
                            $currentYear - 2,
                        ])->first();

        // dd($diklat_count);

        return view('sindikat::arsip_internal.diklat', compact('diklats', 'total_arsip_diklat', 'diklat_count'));
    }

    public function export() 
    {
        return Excel::download(new DiklatExport, 'diklat_pegawai.xlsx');
    }

    public function permohonan_diklat($id){
        
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
