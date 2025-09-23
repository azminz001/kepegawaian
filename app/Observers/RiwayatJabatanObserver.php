<?php

namespace App\Observers;

use Modules\Kepegawaian\Entities\RiwayatJabatan;

class RiwayatJabatanObserver
{
    /**
     * Handle the RiwayatJabatan "created" event.
     *
     * @param  \App\Models\RiwayatJabatan  $riwayatJabatan
     * @return void
     */
    public function created(RiwayatJabatan $riwayatJabatan)
    {
        if ($riwayatJabatan->is_jabatan_terakhir == 1) {
            $this->updateStatus($riwayatJabatan);
        }
    }

    /**
     * Handle the RiwayatJabatan "updated" event.
     *
     * @param  \App\Models\RiwayatJabatan  $riwayatJabatan
     * @return void
     */
    public function updated(RiwayatJabatan $riwayatJabatan)
    {
        if ($riwayatJabatan->is_jabatan_terakhir == 1) {
            $this->updateStatus($riwayatJabatan);
        }
    }

    protected function updateStatus(RiwayatJabatan $riwayatJabatan)
    {
        RiwayatJabatan::where('pegawai_id', $riwayatJabatan->pegawai_id)
            ->where('id', '!=', $riwayatJabatan->id)
            ->update(['is_jabatan_terakhir' => 0]);
    }

    /**
     * Handle the RiwayatJabatan "deleted" event.
     *
     * @param  \App\Models\RiwayatJabatan  $riwayatJabatan
     * @return void
     */
    public function deleted(RiwayatJabatan $riwayatJabatan)
    {
        //
    }

    /**
     * Handle the RiwayatJabatan "restored" event.
     *
     * @param  \App\Models\RiwayatJabatan  $riwayatJabatan
     * @return void
     */
    public function restored(RiwayatJabatan $riwayatJabatan)
    {
        //
    }

    /**
     * Handle the RiwayatJabatan "force deleted" event.
     *
     * @param  \App\Models\RiwayatJabatan  $riwayatJabatan
     * @return void
     */
    public function forceDeleted(RiwayatJabatan $riwayatJabatan)
    {
        //
    }
}
