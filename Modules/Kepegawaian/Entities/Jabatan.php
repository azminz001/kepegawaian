<?php

namespace Modules\Kepegawaian\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Jabatan extends Model
{
    use HasFactory;

    protected $table = 'jabatan';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $timestamps = true;

    protected $fillable = ['nama', 'status_kesehatan', 'status_medis', 'status_perawatan'];
    
    protected static function newFactory()
    {
        return \Modules\Kepegawaian\Database\factories\JabatanFactory::new();
    }

    public function riwayat_jabatan() 
    {
        return $this->hasMany(RiwayatJabatan::class, "jabatan_id");
    }


}
