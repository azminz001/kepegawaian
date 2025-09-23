<?php

namespace Modules\Kepegawaian\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RiwayatKontrakKerja extends Model
{
    use HasFactory;
    use HasUuids;
    protected $table = 'perm_kontrak_kerja';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $timestamps = true;

    protected $fillable = [
        'id', 'nama_berkas', 'tanggal_permohonan', 'file', 'pegawai_id'
    ];
    
    protected static function newFactory()
    {
        return \Modules\Kepegawaian\Database\factories\RiwayatKontrakKerjaFactory::new();
    
    
    }public function pegawai() 
    {
        return $this->belongsTo(ProfilPegawai::class, "pegawai_id");
    }
}
