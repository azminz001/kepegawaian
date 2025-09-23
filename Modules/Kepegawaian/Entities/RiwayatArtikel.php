<?php

namespace Modules\Kepegawaian\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RiwayatArtikel extends Model
{
    use HasFactory;
    use HasUuids;
    protected $table = 'riwayat_artikel_ilmiah';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $timestamps = true;

    protected $fillable = ['id','judul_artikel', 'doi','nama_jurnal', 'scope','volume','link','pegawai_id'];
    
    protected static function newFactory()
    {
        return \Modules\Kepegawaian\Database\factories\RiwayatArtikelFactory::new();
    }

      //////////////////////////////////////////////////////////////
     ///*                  Eloquent Relationship              *////
    //////////////////////////////////////////////////////////////
    public function pegawai() 
    {
        return $this->belongsTo(ProfilPegawai::class, "pegawai_id");
    }
}
