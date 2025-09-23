<?php

namespace Modules\Sindikat\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PermohonanStudiBanding extends Model
{
    use HasFactory;
    use HasUuids;
    protected $table = 'permohonan_magang';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $timestamps = true;

    protected $fillable = ['id', 'nama_instansi', 'tanggal_pelaksanaan', 'jumlah_peserta', 'jenis', 'tema', 'lokasi', 'narasumber', 'keterangan', 'dokumen', 'status', 'institusi_id'];
    
    protected static function newFactory()
    {
        return \Modules\Sindikat\Database\factories\PermohonanStudiBandingFactory::new();
    }
    
    public function institusi() 
    {
        return $this->belongsTo(Institusi::class, "institusi_id");
    }

}
