<?php

namespace Modules\Kepegawaian\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RiwayatKaryaBuku extends Model
{
    use HasFactory;
    use HasUuids;
    protected $table = 'riwayat_karya_buku';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $timestamps = true;

    protected $fillable = ['id','judul', 'isbn','halaman','penerbit','link','pegawai_id'];
    
    protected static function newFactory()
    {
        return \Modules\Kepegawaian\Database\factories\RiwayatKaryaBukuFactory::new();
    }

      //////////////////////////////////////////////////////////////
     ///*                  Eloquent Relationship              *////
    //////////////////////////////////////////////////////////////
    public function pegawai() 
    {
        return $this->belongsTo(ProfilPegawai::class, "pegawai_id");
    }
}
