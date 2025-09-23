<?php

namespace Modules\Kepegawaian\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RiwayatDiklat extends Model
{
    use HasFactory;
    use HasUuids;
    protected $table = 'riwayat_diklat';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $timestamps = true;

    protected $fillable = ['id','nama_diklat','jenis_diklat','institusi_penyelenggara','nomor_sertifikat', 'tahun_diklat','tanggal_mulai', 'tanggal_selesai', 'tempat', 'masa_berlaku', 'durasi', 'dokumen_sertifikat','pegawai_id'];
    
    protected static function newFactory()
    {
        return \Modules\Kepegawaian\Database\factories\RiwayatDiklatFactory::new();
    }

      //////////////////////////////////////////////////////////////
     ///*                  Eloquent Relationship              *////
    //////////////////////////////////////////////////////////////
    public function pegawai() 
    {
        return $this->belongsTo(ProfilPegawai::class, "pegawai_id");
    }
}
