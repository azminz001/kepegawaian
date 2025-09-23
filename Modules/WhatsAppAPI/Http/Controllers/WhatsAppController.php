<?php

namespace Modules\WhatsAppAPI\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use Modules\Kepegawaian\Entities\ProfilPegawai;
use Modules\Kepegawaian\Entities\AnakPegawai;

use Modules\WhatsAppAPI\Entities\SampleAPI;
use Modules\WhatsAppAPI\Entities\Devices;
use Modules\WhatsAppAPI\Entities\LogWhatsAppSent;
use Carbon\Carbon; // Library untuk menangani tanggal


class WhatsAppController extends Controller
{

    public function sendBirthdayMessages()
    {
        $today = Carbon::today()->format('m-d');
        $getDate = Carbon::now()->format('Y-m-d H:i:s');;

        $pegawais = ProfilPegawai::whereRaw('DATE_FORMAT(tanggal_lahir, "%m-%d") = ?', [$today])->get();
        $anaks = AnakPegawai::with('pegawai')->whereRaw('DATE_FORMAT(tanggal_lahir, "%m-%d") = ?', [$today])->get();

        $response = [
            'pegawai' => [],
            'anak' => [],
        ];

        $currentSchedule = Carbon::now(); // jadwal awal sekarang

        // Kirim pesan ke anak pegawai
        foreach ($anaks as $anak) {
            if (empty($anak->pegawai->no_hp)) continue;
            $message = "Kami RSUD Brebes \nMengucapkan *Selamat Ulang Tahun* Kepada Putra/Putri Bapak/Ibu {$anak->pegawai->nama} yang bernama {$anak->nama}! 🎉\nSemoga Ananda sehat dan sukses selalu 🙏.";
            $schedule = $currentSchedule->copy()->toDateTimeString();

            $messageStatus = $this->sendWhatsAppMessageSchedule('HBD',$anak->pegawai->no_hp,$message, $schedule);

            $response['anak'][] = [
                'nama' => $anak->nama,
                'pegawai' => $anak->pegawai->nama,
                'no_hp' => $anak->pegawai->no_hp,
                'status' => $messageStatus ? 'Kirim' : 'Gagal',
            ];
            $delayInSeconds = rand(20, 35);
            $currentSchedule->addSeconds($delayInSeconds);
        }

        // Kirim pesan ke pegawai
        foreach ($pegawais as $pegawai) {
            if (empty($pegawai->no_hp)) continue;
            $message = "*Kami RSUD Brebes* \nMengucapkan *Selamat Ulang Tahun* kepada {$pegawai->nama}! 🎉\nSemoga sehat dan sukses selalu 🙏";
            $schedule = $currentSchedule->copy()->toDateTimeString();
            $messageStatus = $this->sendWhatsAppMessageSchedule('HBD',$pegawai->no_hp,$message, $schedule);


            $response['pegawai'][] = [
                'nama' => $pegawai->nama,
                'no_hp' => $pegawai->no_hp,
                'status' => $messageStatus ? 'Kirim' : 'Gagal',
            ];

            $delayInSeconds = rand(20, 35);
            $currentSchedule->addSeconds($delayInSeconds);

        }

        if (empty($response['pegawai']) && empty($response['anak'])) {
            return response()->json([
                'status' => 'info',
                'message' => 'Tidak ada pegawai atau anak pegawai yang berulang tahun hari ini.',
            ]);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Pesan ucapan ulang tahun diproses.',
            'details' => $response,
        ]);
    }


    public function sendBroadCast(Request $request)
    {
        if ($request->tujuan == "semua") {
            # code...
            $pegawais = ProfilPegawai::whereNotNull('no_hp')->get();

            foreach ($pegawais as $pegawai) {
                $this->sendWhatsAppMessage('Broadcast',$pegawai->no_hp, "Yth. Bapak/Ibu ".$pegawai->nama."\n".$request->pesan."\n\nSalam, \nRSUD Brebes");
            }
        }else {
            $pegawai_ids = $request->input('pegawai_id');
            foreach ($pegawai_ids as $pegawai_id) {
                $pegawai = ProfilPegawai::findOrFail($pegawai_id);
    
                $success = $this->sendWhatsAppMessage(
                    'Broadcast',
                    $pegawai->no_hp,
                    "Yth. Bapak/Ibu " . $pegawai->nama . "\n" . $request->pesan . "\n\nSalam, \nRSUD Brebes"
                );
    
                if ($success) {
                    sleep(30);
                }
            }
        }
        

        return redirect()->back()->with('success', 'Pesan broadcast telah dikirim.');
    }

    public function sendWhatsAppMessage($jenis, $noHp, $message)
    {
        $perangkat_aktif = Devices::where('status', '1')->first();
        $id_perangkat = $perangkat_aktif->device_id;
        
        $url = 'https://dash.whacenter.id/api/send'; // URL API WhatsApp
        $device_id = $id_perangkat; // Ganti dengan device_id Anda

        $data = [
            'device_id' => $device_id,
            'number' => $noHp,
            'message' => $message,
        ];

        // Inisialisasi cURL
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);

        // Decode JSON response untuk memeriksa status
        $response = json_decode($result, true);
        $mytime = Carbon::now();
        // Simpan log ke database
        LogWhatsAppSent::create([
            'jenis' => $jenis,
            'catatan' => "Pesan ke {$noHp}",
            'status' => isset($response['status']) && $response['status'] === true ? '1' : '0',
            'created_at' => $mytime->toDateTimeString()
        ]);

        return $result;
    }

    public function sendWhatsAppBroadcastMessage($jenis, $noHp, $message, $schedule)
    {
        $perangkat_aktif = Devices::where('status', '1')->first();
        $id_perangkat = $perangkat_aktif->device_id;
        
        $url = 'https://dash.whacenter.id/api/send'; // URL API WhatsApp
        $device_id = $id_perangkat; // Ganti dengan device_id Anda

        $data = [
            'device_id' => $device_id,
            'number' => $noHp,
            'message' => $message,
            'schedule' => $message,
        ];

        dd($data);

        // Inisialisasi cURL
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);

        // Decode JSON response untuk memeriksa status
        $response = json_decode($result, true);
        $mytime = Carbon::now();
        // Simpan log ke database
        LogWhatsAppSent::create([
            'jenis' => $jenis,
            'catatan' => "Pesan ke {$noHp}",
            'status' => isset($response['status']) && $response['status'] === true ? '1' : '0',
            'created_at' => $mytime->toDateTimeString()
        ]);

        return $result;
    }

    public function sendWhatsAppMessageSchedule($jenis, $noHp, $message, $schedule)
    {
        $perangkat_aktif = Devices::where('status', '1')->first();
        $id_perangkat = $perangkat_aktif->device_id;
        
        $url = 'https://dash.whacenter.id/api/send'; // URL API WhatsApp
        $device_id = $id_perangkat; // Ganti dengan device_id Anda

        $data = [
            'device_id' => $device_id,
            'number' => $noHp,
            'message' => $message,
            'schedule' => $schedule,
        ];

        // Inisialisasi cURL
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);

        // Decode JSON response untuk memeriksa status
        $response = json_decode($result, true);
        $mytime = Carbon::now();
        // Simpan log ke database
        LogWhatsAppSent::create([
            'jenis' => $jenis,
            'catatan' => "Pesan ke {$noHp}",
            'status' => isset($response['status']) && $response['status'] === true ? '1' : '0',
            'created_at' => $mytime->toDateTimeString()
        ]);

        return $result;
    }
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('whatsappapi::index');
    }

    public function log(){
        $logs = LogWhatsAppSent::orderBy('created_at', 'DESC')->limit(100)->get();
        
        return view('whatsappapi::log', compact('logs'));

    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('whatsappapi::create');
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
        return view('whatsappapi::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('whatsappapi::edit');
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
