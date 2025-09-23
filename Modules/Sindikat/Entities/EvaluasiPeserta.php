<?php

namespace Modules\Sindikat\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Modules\Kepegawaian\Entities\ProfilPegawai;

class EvaluasiPeserta extends Model
{
    use HasFactory;
    use HasUuids;
    protected $table = 'evaluasi_peserta';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $timestamps = true;

    protected $connection = 'sindikat';

    protected $fillable = ['dokumen', 'catatan', 'permohonan_magang_id', 'peserta_didik_id', 'pegawai_id'];

    protected static function newFactory()
    {
        return \Modules\Sindikat\Database\factories\EvaluasiPesertaFactory::new();
    }
    public function peserta_didik() 
    {
        return $this->belongsTo(PesertaDidik::class, "peserta_didik_id");
    }
    public function pegawai() 
    {
        return $this->belongsTo(ProfilPegawai::class, "pegawai_id");
    }
}
