<?php

namespace Modules\Kepegawaian\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class JabatanUnit extends Model
{
    use HasFactory;

    protected $table = 'jabatan_unit';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $timestamps = true;

    protected $fillable = ['nama', 'jenis_jabatan_id'];
    
    protected static function newFactory()
    {
        return \Modules\Kepegawaian\Database\factories\JabatanUnitFactory::new();
    }

    public function jenis_jabatan() 
    {
        return $this->belongsTo(JenisJabatan::class, "jenis_jabatan_id");
    }

    public function riwayat_jabatan() 
    {
        return $this->hasMany(UnitJabatanPegawai::class, "jabatan_unit_id");
    }

}
