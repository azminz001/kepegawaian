<?php

namespace Modules\Sindikat\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PesertaDidik extends Model
{
    use HasFactory;
    use HasUuids;
    protected $table = 'peserta_didik';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $timestamps = true;

    protected $connection = 'sindikat';

    protected $fillable = ['id', 'no_induk', 'nama_lengkap', 'jenis_kelamin', 'permohonan_magang_id', 'jurusan_id', 'institusi_id'];
    
    protected static function newFactory()
    {
        return \Modules\Sindikat\Database\factories\PesertaDidikFactory::new();
    }
    public function jurusan() 
    {
        return $this->belongsTo(Jurusan::class, "jurusan_id")->with('institusi');
    }
    public function permohonan_magang() 
    {
        return $this->belongsTo(PermohonanMagang::class, "permohonan_magang_id");
    }

    public function evaluasi() 
    {
        return $this->hasMany(EvaluasiPeserta::class, "peserta_didik_id");
    }

    public function jadwal_pesertadidik()
    {
        return $this->hasMany(JadwalPesertaDidik::class, 'peserta_didik_id');
    }

    public function institusi()
    {
        return $this->belongsTo(Institusi::class, 'institusi_id');
    }
}
