<?php

namespace Modules\Kepegawaian\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class JenjangPendidikan extends Model
{
    use HasFactory;

    protected $table = 'jenjang_pendidikan';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $timestamps = true;
    
    protected static function newFactory()
    {
        return \Modules\Kepegawaian\Database\factories\JenjangPendidikanFactory::new();
    }

    public function riwayat_pendidikan() 
    {
        return $this->hasMany(RiwayatPendidikan::class, "jenjang_pendidikan_id");
    }
}
