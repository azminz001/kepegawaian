<?php

namespace Modules\Sindikat\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class PermohonanLitbangDetail extends Model
{
    use HasFactory;
    use HasUuids;

    protected $table = 'permohonan_litbang_detail';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $timestamps = true;

    protected $connection = 'sindikat';
    protected $fillable = ['judul_penelitian', 'deskripsi_penelitian', 'bidang_penelitian', 'tanggal_mulai', 'tanggal_selesai', 'berkas_pendukung', 'nama_pembimbing', 'kontak_pembimbing', 'status_permohonan', 'permohonan_litbang_id'];
    
    protected static function newFactory()
    {
        return \Modules\Sindikat\Database\factories\PermohonanLitbangDetailFactory::new();
    }

    public function pemohon()
    {
        return $this->belongsTo(PermohonanLitbang::class, 'permohonan_litbang_id');
    }
}
