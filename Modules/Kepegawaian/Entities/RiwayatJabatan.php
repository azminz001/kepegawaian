<?php

namespace Modules\Kepegawaian\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RiwayatJabatan extends Model
{
    use HasFactory;
    use HasUuids;

    protected $table = 'riwayat_jabatan';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $timestamps = true;

    protected $fillable = ['id', 'tmt_jabatan', 'no_sk', 'tanggal_sk', 'gaji', 'diklat', 'dokumen_sk', 'is_jabatan_terakhir', 'kel_jabatan_id', 'jabatan_id', 'eselon_id', 'pegawai_id'];

    protected static function newFactory()
    {
        return \Modules\Kepegawaian\Database\factories\RiwayatJabatanFactory::new();
    }

    public function pegawai() 
    {
        return $this->belongsTo(ProfilPegawai::class, "pegawai_id");
    }

    public function eselon() 
    {
        return $this->belongsTo(Eselon::class, "eselon_id");
    }
    public function jabatan() 
    {
        return $this->belongsTo(Jabatan::class, "jabatan_id");
    }

    public function kelompok_jabatan() 
    {
        return $this->belongsTo(KelJabatan::class, "kel_jabatan_id");
    }
}
