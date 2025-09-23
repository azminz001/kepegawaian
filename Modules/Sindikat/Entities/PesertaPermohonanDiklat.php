<?php

namespace Modules\Sindikat\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Kepegawaian\Entities\ProfilPegawai;


class PesertaPermohonanDiklat extends Model
{
    use HasFactory;

    protected $table = 'peserta_permohonan_diklat';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $timestamps = true;

    protected $connection = 'sindikat';

    protected $fillable = ['permohonan_diklat_id', 'pegawai_id'];
    
    protected static function newFactory()
    {
        return \Modules\Sindikat\Database\factories\PesertaPermohonanDiklatFactory::new();
    }
    public function permohonan_diklat() 
    {
        return $this->belongsTo(PermohonanDiklatPegawai::class, "permohonan_diklat_id");
    }

    public function pegawai() 
    {
        return $this->belongsTo(ProfilPegawai::class, "pegawai_id");
    }
    
}
