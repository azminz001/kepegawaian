<?php

namespace Modules\Kepegawaian\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;


class RiwayatJabatanUnit extends Model
{
    use HasFactory;
    use HasUuids;

    protected $table = 'unit_jabatan_pegawai';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $timestamps = true;

    protected $fillable = ['id','tmt_jabatan_unit', 'is_jabatan_terakhir','unit_id','jabatan_unit_id', 'pegawai_id'];
    
    protected static function newFactory()
    {
        return \Modules\Kepegawaian\Database\factories\UnitJabatanPegawaiFactory::new();
    }

    public function pegawai() 
    {
        return $this->belongsTo(ProfilPegawai::class, "pegawai_id");
    }

    public function jabatan_unit() 
    {
        return $this->belongsTo(JabatanUnit::class, "jabatan_unit_id");
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class, "unit_id");
    }
    
}
