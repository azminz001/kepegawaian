<?php

namespace Modules\Sindikat\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Modules\Kepegawaian\Entities\ProfilPegawai;


class PermohonanDiklatPegawai extends Model
{
    use HasFactory;
    use HasUuids;
    protected $table = 'permohonan_diklat_pegawai';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $timestamps = true;

    protected $connection = 'sindikat';

    protected $fillable = ['id', 'nama_diklat', 'penyelenggara', 'tempat', 'tipe', 'jenis', 'tanggal_mulai', 'tanggal_selesai', 'link', 'upload', 'catatan', 'status', 'peserta_diklat', 'pegawai_id'];
    
    protected static function newFactory()
    {
        return \Modules\Sindikat\Database\factories\PermohonanDiklatPegawaiFactory::new();
    }
    public function peserta_diklat() 
    {
        return $this->hasMany(PesertaPermohonanDiklat::class, "permohonan_diklat_id");
    }
    public function pegawai() 
    {
        return $this->belongsTo(ProfilPegawai::class, "pegawai_id");
    }

}
