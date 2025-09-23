<?php

namespace App\Observers;

use Modules\Kepegawaian\Entities\RiwayatPendidikan;

class RiwayatPendidikanObserver
{
    /**
     * Handle the RiwayatPendidikan "created" event.
     *
     * @param  \App\Models\RiwayatPendidikan  $riwayatPendidikan
     * @return void
     */
    public function created(RiwayatPendidikan $riwayatPendidikan)
    {
        if ($riwayatPendidikan->is_pendidikan_terakhir == 1) {
            $this->updateStatus($riwayatPendidikan);
        }
    }

    /**
     * Handle the RiwayatPendidikan "updated" event.
     *
     * @param  \App\Models\RiwayatPendidikan  $riwayatPendidikan
     * @return void
     */
    public function updated(RiwayatPendidikan $riwayatPendidikan)
    {
        if ($riwayatPendidikan->is_pendidikan_terakhir == 1) {
            $this->updateStatus($riwayatPendidikan);
        }
    }

    protected function updateStatus(RiwayatPendidikan $riwayatPendidikan)
    {
        RiwayatPendidikan::where('pegawai_id', $riwayatPendidikan->pegawai_id)
            ->where('id', '!=', $riwayatPendidikan->id)
            ->update(['is_pendidikan_terakhir' => 0]);
    }

    /**
     * Handle the RiwayatPendidikan "deleted" event.
     *
     * @param  \App\Models\RiwayatPendidikan  $riwayatPendidikan
     * @return void
     */
    public function deleted(RiwayatPendidikan $riwayatPendidikan)
    {
        //
    }

    /**
     * Handle the RiwayatPendidikan "restored" event.
     *
     * @param  \App\Models\RiwayatPendidikan  $riwayatPendidikan
     * @return void
     */
    public function restored(RiwayatPendidikan $riwayatPendidikan)
    {
        //
    }

    /**
     * Handle the RiwayatPendidikan "force deleted" event.
     *
     * @param  \App\Models\RiwayatPendidikan  $riwayatPendidikan
     * @return void
     */
    public function forceDeleted(RiwayatPendidikan $riwayatPendidikan)
    {
        //
    }
}
