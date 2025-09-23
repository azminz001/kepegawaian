<?php

namespace Modules\Sindikat\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Sindikat\Entities\PermohonanLitbang;
use Modules\Sindikat\Entities\PermohonanLitbangDetail;
use Modules\WhatsAppAPI\Http\Controllers\WhatsAppController;

class PermohonanLitbangController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('sindikat::index');
    }

    public function login()
    {
        return view('sindikat::litbang.login');
    }
    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('sindikat::litbang.register');
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
            'nim'     => 'required|string|max:255',
            'perguruan_tinggi'     => 'required|string|max:255',
            'no_hp'     => 'required|string|max:255',
            'email'     => 'required|string|max:255',
        ]);

        $passcode = rand(100000, 999999);

        $store = PermohonanLitbang::create([
            'nama'     => strtoupper($request->nama),
            'nim'     => $request->nim,
            'perguruan_tinggi'   => $request->perguruan_tinggi,
            'fakultas'   => $request->fakultas,
            'program_studi'   => $request->program_studi,
            'no_hp'   => $request->no_hp,
            'email'   => $request->email,
            'is_terms_agreed'   => $request->terms_agree,
            'passcode'   => $passcode
        ]);
        if ($store) {
            
            $whatsappController = new WhatsAppController();
            $jenis = 'permohonan_litbang';
            // $noHp = '085707749997'; // Ganti dengan nomor tujuan yang sesuai
            $message = "Hi, Salam Sehat \n\nInformasi Sindikat\nKonfirmasi Pendaftaran Akun Permohonan Litbang a.n *".strtoupper($request->nama)."* \nBerikut Passcode untuk login\nPasscode: *".$passcode."*\nJaga dan Simpan Passcode Anda.\nTerimakasih\n\n*RSUD Brebes*";
            
            $response = $whatsappController->sendWhatsAppMessage($jenis, $request->no_hp, $message);
        }

        return redirect()->route('sindikat.litbang.login')->with('success', 'Periksa Pesan WA untuk melihat Passcode Anda, Silahkan Login');
    }

    public function login_process(Request $request)
    {
        $pemohon = PermohonanLitbang::where('email', $request->email)->where('passcode', $request->passcode)->first();

        return redirect()->route('sindikat.litbang.permohonan_litbang', $pemohon->id);
    }
    public function permohonan_litbang($id)
    {
        $pemohon = PermohonanLitbang::find($id);

        $data_permohonan_litbang = PermohonanLitbangDetail::where('permohonan_litbang_id', $id)->get();

        return view('sindikat::litbang.permohonan_litbang_pemohon', compact('pemohon', 'data_permohonan_litbang'));
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
        $pemohon = PermohonanLitbang::find($id);

        $pemohon->update([
            'nama'     => strtoupper($request->nama),
            'nim'     => $request->nim,
            'perguruan_tinggi'   => $request->perguruan_tinggi,
            'fakultas'   => $request->fakultas,
            'program_studi'   => $request->program_studi,
            'no_hp'   => $request->no_hp,
            'email'   => $request->email,
        ]);

        return redirect()->back()->with('success', 'Update Data Biodata Berhasil');

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
