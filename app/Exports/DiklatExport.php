<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Modules\Kepegawaian\Entities\RiwayatDiklat;

class DiklatExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function headings(): array
    {
        return [
            'No',
            'Nama Pegawai',
            'NIP/NIPPPK/NRP',
            'Unit',
            'Pendidikan Terakhir',
            'Diklat yang Diikuti',
            'Tanggal Pelatihan',
            'Penyelenggara Pelatihan',
            'Tempat',
            'Masa Berlaku',
            'Link',
        ];
    }

    public function collection()
    {
        $diklatData = RiwayatDiklat::with(['pegawai' => function($query) {
                        $query->with('pendidikan_terakhir', 'unit_jabatan_aktif');
                    }])->orderBy('tanggal_selesai', 'DESC')->get();

        // Format the data to include the specified columns
        $formattedData = $diklatData->map(function ($item, $index) {
            return [
                'No' => $index + 1, // Incrementing number starting from 1
                'Nama Pegawai' => $item->pegawai->nama ?? '-',
                'NIP/NIPPPK/NRP' => "'".$item->pegawai->nip_nipppk_nrpk_nrpblud ?? '-',
                'Unit' => $item->pegawai->unit_jabatan_aktif->nama_unit ?? '-',
                'Pendidikan Terakhir' => isset($item->pegawai->pendidikan_terakhir->jenjang_pendidikan->nama) ? $item->pegawai->pendidikan_terakhir->jenjang_pendidikan->nama." ".$item->pegawai->pendidikan_terakhir->jurusan : '-',
                'Diklat yang Diikuti' => $item->nama_diklat ?? '-',
                'Tanggal Pelatihan' => date('d-M-Y', strtotime($item->tanggal_mulai)). " s.d " .date('d-M-Y', strtotime($item->tanggal_selesai)),
                'Penyelenggara Pelatihan' => $item->institusi_penyelenggara ?? '-',
                'Tempat' => $item->tempat ?? '-',
                'Masa Berlaku' => $item->masa_berlaku ?? '-',
                'Link' => url('storage/dokumen_pegawai/'.$item->pegawai->id.'/'.$item->dokumen_sertifikat) ?? '-',
            ];
        });

        return collect($formattedData);
    }
}
