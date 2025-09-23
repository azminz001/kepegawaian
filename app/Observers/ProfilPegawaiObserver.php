<?php

namespace App\Observers;
use Modules\Kepegawaian\Entities\ProfilPegawai;
use Modules\Kepegawaian\Entities\Users;

class ProfilPegawaiObserver
{
    public function updated(ProfilPegawai $pegawai)
    {
        if ($pegawai->isDirty('nip_nipppk_nrpk_nrpblud')) {
            // Cari user yang terkait dengan nomor_induk lama
            $user = Users::where('username', $pegawai->getOriginal('nip_nipppk_nrpk_nrpblud'))->first();
            if ($user) {
                // Update username di tabel users
                $user->username = $pegawai->nip_nipppk_nrpk_nrpblud;
                $user->save();
            }
        }
    }
}
