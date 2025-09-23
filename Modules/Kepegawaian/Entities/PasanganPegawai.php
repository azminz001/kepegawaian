<?php

namespace Modules\Kepegawaian\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PasanganPegawai extends Model
{
    use HasFactory;
    use HasUuids;
    protected $table = 'pasangan_pegawai';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $timestamps = true;

    protected $fillable = ['id','jenis','nik', 'no_bpjs', 'nama', 'tanggal_lahir', 'tanggal_nikah', 'pekerjaan', 'status', 'pegawai_id'];
    
    protected static function newFactory()
    {
        return \Modules\Kepegawaian\Database\factories\PasanganPegawaiFactory::new();
    }

    public function pegawai() 
    {
        return $this->belongsTo(ProfilPegawai::class, "pegawai_id");
    }
}
