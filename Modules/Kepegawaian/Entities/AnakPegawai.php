<?php

namespace Modules\Kepegawaian\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AnakPegawai extends Model
{
    use HasFactory;
    use HasUuids;
    protected $table = 'anak_pegawai';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $timestamps = true;

    protected $fillable = ['id','nama','jenis_kelamin','nik', 'no_bpjs','tanggal_lahir', 'pegawai_id'];
    
    protected static function newFactory()
    {
        return \Modules\Kepegawaian\Database\factories\AnakPegawaiFactory::new();
    }

      //////////////////////////////////////////////////////////////
     ///*                  Eloquent Relationship              *////
    //////////////////////////////////////////////////////////////
    public function pegawai() 
    {
        return $this->belongsTo(ProfilPegawai::class, "pegawai_id");
    }
}
