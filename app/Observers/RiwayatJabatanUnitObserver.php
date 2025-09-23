<?php

namespace App\Observers;

use Modules\Kepegawaian\Entities\RiwayatJabatanUnit;

class RiwayatJabatanUnitObserver
{
    /**
     * Handle the RiwayatJabatanUnit "created" event.
     *
     * @param  \App\Models\RiwayatJabatanUnit  $riwayatJabatanUnit
     * @return void
     */
    public function created(RiwayatJabatanUnit $riwayatJabatanUnit)
    {
        if ($riwayatJabatanUnit->is_jabatan_terakhir == 1) {
            $this->updateStatus($riwayatJabatanUnit);
        }
    }

    /**
     * Handle the RiwayatJabatanUnit "updated" event.
     *
     * @param  \App\Models\RiwayatJabatanUnit  $riwayatJabatanUnit
     * @return void
     */
    public function updated(RiwayatJabatanUnit $riwayatJabatanUnit)
    {
        if ($riwayatJabatanUnit->is_jabatan_terakhir == 1) {
            $this->updateStatus($riwayatJabatanUnit);
        }
    }

    protected function updateStatus(RiwayatJabatanUnit $riwayatJabatanUnit)
    {
        RiwayatJabatanUnit::where('pegawai_id', $riwayatJabatanUnit->pegawai_id)
            ->where('id', '!=', $riwayatJabatanUnit->id)
            ->update(['is_jabatan_terakhir' => 0]);
    }

    /**
     * Handle the RiwayatJabatanUnit "deleted" event.
     *
     * @param  \App\Models\RiwayatJabatanUnit  $riwayatJabatanUnit
     * @return void
     */
    public function deleted(RiwayatJabatanUnit $riwayatJabatanUnit)
    {
        //
    }

    /**
     * Handle the RiwayatJabatanUnit "restored" event.
     *
     * @param  \App\Models\RiwayatJabatanUnit  $riwayatJabatanUnit
     * @return void
     */
    public function restored(RiwayatJabatanUnit $riwayatJabatanUnit)
    {
        //
    }

    /**
     * Handle the RiwayatJabatanUnit "force deleted" event.
     *
     * @param  \App\Models\RiwayatJabatanUnit  $riwayatJabatanUnit
     * @return void
     */
    public function forceDeleted(RiwayatJabatanUnit $riwayatJabatanUnit)
    {
        //
    }
}
