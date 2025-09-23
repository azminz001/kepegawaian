<?php

namespace Modules\Sindikat\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PermohonanMagang extends Model
{
    use HasFactory;
    use HasUuids;
    protected $table = 'permohonan_magang';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $timestamps = true;

    protected $connection = 'sindikat';

    protected $fillable = ['id', 'no_surat', 'tanggal_surat', 'tanggal_mulai', 'tanggal_selesai', 'jumlah_peserta', 'dokumen', 'status', 'institusi_id'];
    
    protected static function newFactory()
    {
        return \Modules\Sindikat\Database\factories\PermohonanMagangFactory::new();
    }
    public function institusi() 
    {
        return $this->belongsTo(Institusi::class, "institusi_id");
    }

    public function peserta_didik() 
    {
        return $this->hasMany(PesertaDidik::class, "permohonan_magang_id");
    }
}
