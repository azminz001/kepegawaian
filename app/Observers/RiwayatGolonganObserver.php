<?php

namespace App\Observers;

use Modules\Kepegawaian\Entities\RiwayatGolongan;

class RiwayatGolonganObserver
{
    /**
     * Handle the RiwayatGolongan "created" event.
     *
     * @param  \App\Models\RiwayatGolongan  $riwayatGolongan
     * @return void
     */
    public function created(RiwayatGolongan $riwayatGolongan)
    {
        if ($riwayatGolongan->is_golongan_terakhir == 1) {
            $this->updateStatus($riwayatGolongan);
        }
    }

    /**
     * Handle the RiwayatGolongan "updated" event.
     *
     * @param  \App\Models\RiwayatGolongan  $riwayatGolongan
     * @return void
     */
    public function updated(RiwayatGolongan $riwayatGolongan)
    {
        if ($riwayatGolongan->is_golongan_terakhir == 1) {
            $this->updateStatus($riwayatGolongan);
        }
    }

    protected function updateStatus(RiwayatGolongan $riwayatGolongan)
    {
        RiwayatGolongan::where('pegawai_id', $riwayatGolongan->pegawai_id)
            ->where('id', '!=', $riwayatGolongan->id)
            ->update(['is_golongan_terakhir' => 0]);
    }

    /**
     * Handle the RiwayatGolongan "deleted" event.
     *
     * @param  \App\Models\RiwayatGolongan  $riwayatGolongan
     * @return void
     */
    public function deleted(RiwayatGolongan $riwayatGolongan)
    {
        //
    }

    /**
     * Handle the RiwayatGolongan "restored" event.
     *
     * @param  \App\Models\RiwayatGolongan  $riwayatGolongan
     * @return void
     */
    public function restored(RiwayatGolongan $riwayatGolongan)
    {
        //
    }

    /**
     * Handle the RiwayatGolongan "force deleted" event.
     *
     * @param  \App\Models\RiwayatGolongan  $riwayatGolongan
     * @return void
     */
    public function forceDeleted(RiwayatGolongan $riwayatGolongan)
    {
        //
    }
}
