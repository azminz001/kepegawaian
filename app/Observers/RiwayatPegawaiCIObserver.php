<?php

namespace App\Observers;

use Modules\Kepegawaian\Entities\PegawaiCI;


class RiwayatPegawaiCIObserver
{
    /**
     * Handle the PegawaiCI "created" event.
     *
     * @param  \App\Models\PegawaiCI  $pegawaiCI
     * @return void
     */
    public function created(PegawaiCI $pegawaiCI)
    {
        if ($pegawaiCI->status == 1) {
            $this->updateStatus($pegawaiCI);
        }
    }

    /**
     * Handle the PegawaiCI "updated" event.
     *
     * @param  \App\Models\PegawaiCI  $pegawaiCI
     * @return void
     */
    public function updated(PegawaiCI $pegawaiCI)
    {
        if ($pegawaiCI->status == 1) {
            $this->updateStatus($pegawaiCI);
        }
    }

    protected function updateStatus(PegawaiCI $pegawaiCI)
    {
        PegawaiCI::where('pegawai_id', $pegawaiCI->pegawai_id)
            ->where('id', '!=', $pegawaiCI->id)
            ->update(['status' => 0]);
    }

    /**
     * Handle the PegawaiCI "deleted" event.
     *
     * @param  \App\Models\PegawaiCI  $pegawaiCI
     * @return void
     */
    public function deleted(PegawaiCI $pegawaiCI)
    {
        //
    }

    /**
     * Handle the PegawaiCI "restored" event.
     *
     * @param  \App\Models\PegawaiCI  $pegawaiCI
     * @return void
     */
    public function restored(PegawaiCI $pegawaiCI)
    {
        //
    }

    /**
     * Handle the PegawaiCI "force deleted" event.
     *
     * @param  \App\Models\PegawaiCI  $pegawaiCI
     * @return void
     */
    public function forceDeleted(PegawaiCI $pegawaiCI)
    {
        //
    }
}
