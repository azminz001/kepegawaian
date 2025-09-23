<?php

namespace Modules\Kepegawaian\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RiwayatInovasi extends Model
{
    use HasFactory;
    use HasUuids;
    protected $table = 'riwayat_inovasi';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $timestamps = true;

    protected $fillable = ['id','judul','tahun','jenis','keterangan','pegawai_id'];
    
    protected static function newFactory()
    {
        return \Modules\Kepegawaian\Database\factories\RiwayatInovasiFactory::new();
    }

      //////////////////////////////////////////////////////////////
     ///*                  Eloquent Relationship              *////
    //////////////////////////////////////////////////////////////
    public function pegawai() 
    {
        return $this->belongsTo(ProfilPegawai::class, "pegawai_id");
    }
}
