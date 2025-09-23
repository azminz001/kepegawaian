<?php

namespace Modules\KuotaPoli\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\KuotaPoli\Entities\NotifikasiTTE;
use Illuminate\Support\Facades\DB;

use Modules\WhatsAppAPI\Http\Controllers\WhatsAppController;
use Carbon\Carbon;

class NotifikasiTTEController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('kuotapoli::index');
    }

    public function suratsehat_list()
    {
        $data_surat = NotifikasiTTE::whereNull('SYNC')->orderBy('DITTD_TANGGAL', 'DESC')->paginate(15);

        return view('kuotapoli::notifikasitte.suratsehat', compact('data_surat'));
    }

    public function send_wa($id)
    {
        $data_surat = NotifikasiTTE::find($id);

        $whatsappController = new WhatsAppController();
        $jenis = 'simgos_surat_sehat';
        $noHp = env('WA_SURAT_SEHAT'); // Ganti dengan nomor tujuan yang sesuai
        // $noHp = '0818458859'; // Ganti dengan nomor tujuan yang sesuai
        // dd($noHp);
        $message = "Hi, Salam Sehat \nInformasi Permohonan Cetak ".$data_surat->KETERANGAN."\n\nDPJP: ".$data_surat->DITTD_OLEH."\nTanggal TTD: ".$data_surat->DITTD_TANGGAL."\nKunjungan: ".$data_surat->KUNJUNGAN."\nNama Pasien: ".$data_surat->NAMA_PASIEN."\nNO. RM: ".$data_surat->NORM."\n\nTerimakasih\nRSUD Brebes";

        // dd($message);
        $results = []; // Menyimpan hasil status kirim


        // return  redirect()->back();

        $response = $whatsappController->sendWhatsAppMessage($jenis, $noHp, $message);

        if ($response) {
            
            $data_surat->update([
                'SYNC' => 1,
                'SYNC_DATE' =>  Carbon::now(),
            ]);

            $results[] = [
                'status' => 'success',
                'message' => 'Surat berhasil terkirim.',
            ];
        }else{
            $results[] = [
                'status' => 'failed',
                'message' => 'Surat gagal terkirim.',
            ];
        }
        

        return response()->json($results);
    }

    public function send_all_wa()
    {
        $data_surat = NotifikasiTTE::whereNull('SYNC')->orderBy('DITTD_TANGGAL', 'DESC')->get();

        $whatsappController = new WhatsAppController();
        $jenis = 'simgos_surat_sehat';
        $noHp = env('WA_SURAT_SEHAT'); // Ganti jika dinamis

        $results = [];
        $currentSchedule = Carbon::now(); // jadwal awal sekarang

        foreach ($data_surat as $key => $data) {
            $message = "Hi, Salam Sehat \nInformasi Permohonan Cetak {$data->KETERANGAN}\n\nDPJP: {$data->DITTD_OLEH}\nTanggal TTD: {$data->DITTD_TANGGAL}\nKunjungan: {$data->KUNJUNGAN}\nNama Pasien: {$data->NAMA_PASIEN}\nNO. RM: {$data->NORM}\n\nTerimakasih\nRSUD Brebes";

            $schedule = $currentSchedule->copy()->toDateTimeString();

            $response = $whatsappController->sendWhatsAppMessageSchedule($jenis, $noHp, $message, $schedule);

            if ($response) {
                $data->update([
                    'SYNC' => 1,
                    'SYNC_DATE' => Carbon::now(),
                ]);

                $results[] = [
                    'status' => 'success',
                    'message' => "{$data->KETERANGAN} dengan ID {$data->ID} berhasil terkirim  ke nomor {$noHp} dengan jadwal {$schedule}.",
                ];
            } else {
                $results[] = [
                    'status' => 'failed',
                    'message' => "{$data->KETERANGAN}denga  ID {$data->ID} gagal terkirim ke nomor {$noHp} dengan jadwal {$schedule}.",
                ];
            }

            // Tambahkan delay acak antara 20-35 detik untuk jadwal berikutnya
            $delayInSeconds = rand(20, 35);
            $currentSchedule->addSeconds($delayInSeconds);
        }

        return response()->json($results);
    }
    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('kuotapoli::create');
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
        return view('kuotapoli::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('kuotapoli::edit');
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
