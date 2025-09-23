<?php

namespace Modules\Kepegawaian\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RiwayatGolongan extends Model
{
    use HasFactory;
    use HasUuids;

    protected $table = 'riwayat_golongan';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $timestamps = true;

    protected $fillable = ['id', 'tmt', 'no_surat_bkn', 'sk_nomor', 'sk_tanggal', 'dokumen_sk','is_golongan_terakhir', 'golongan_id', 'pegawai_id'];

    
    protected static function newFactory()
    {
        return \Modules\Kepegawaian\Database\factories\RiwayatGolonganFactory::new();
    }

    public function pegawai() 
    {
        return $this->belongsTo(ProfilPegawai::class, "pegawai_id");
    }

    public function golongan() 
    {
        return $this->belongsTo(Golongan::class, "golongan_id");
    }
}
