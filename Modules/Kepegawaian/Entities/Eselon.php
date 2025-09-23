<?php

namespace Modules\Kepegawaian\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Eselon extends Model
{
    use HasFactory;

    protected $table = 'eselon';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $timestamps = true;

    protected static function newFactory()
    {
        return \Modules\Kepegawaian\Database\factories\EselonFactory::new();
    }

    public function riwayat_jabatan() 
    {
        return $this->hasMany(RiwayatJabatan::class, "eselon_id");
    }
}
