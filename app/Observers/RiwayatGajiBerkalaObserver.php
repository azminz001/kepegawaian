<?php

namespace App\Observers;
use Modules\Kepegawaian\Entities\RiwayatGajiBerkala;


class RiwayatGajiBerkalaObserver
{
    /**
     * Handle the RiwayatGajiBerkala "created" event.
     *
     * @param  \App\Models\RiwayatGajiBerkala  $RiwayatGajiBerkala
     * @return void
     */
    public function created(RiwayatGajiBerkala $RiwayatGajiBerkala)
    {
        if ($RiwayatGajiBerkala->is_gaji_terakhir == 1) {
            $this->updateStatus($RiwayatGajiBerkala);
        }
    }

    /**
     * Handle the RiwayatGajiBerkala "updated" event.
     *
     * @param  \App\Models\RiwayatGajiBerkala  $RiwayatGajiBerkala
     * @return void
     */
    public function updated(RiwayatGajiBerkala $RiwayatGajiBerkala)
    {
        if ($RiwayatGajiBerkala->is_gaji_terakhir == 1) {
            $this->updateStatus($RiwayatGajiBerkala);
        }
    }

    protected function updateStatus(RiwayatGajiBerkala $RiwayatGajiBerkala)
    {
        RiwayatGajiBerkala::where('pegawai_id', $RiwayatGajiBerkala->pegawai_id)
            ->where('id', '!=', $RiwayatGajiBerkala->id)
            ->update(['is_gaji_terakhir' => 0]);
    }

    /**
     * Handle the RiwayatGajiBerkala "deleted" event.
     *
     * @param  \App\Models\RiwayatGajiBerkala  $RiwayatGajiBerkala
     * @return void
     */
    public function deleted(RiwayatGajiBerkala $RiwayatGajiBerkala)
    {
        //
    }

    /**
     * Handle the RiwayatGajiBerkala "restored" event.
     *
     * @param  \App\Models\RiwayatGajiBerkala  $RiwayatGajiBerkala
     * @return void
     */
    public function restored(RiwayatGajiBerkala $RiwayatGajiBerkala)
    {
        //
    }

    /**
     * Handle the RiwayatGajiBerkala "force deleted" event.
     *
     * @param  \App\Models\RiwayatGajiBerkala  $RiwayatGajiBerkala
     * @return void
     */
    public function forceDeleted(RiwayatGajiBerkala $RiwayatGajiBerkala)
    {
        //
    }
}
