<?php

namespace Modules\Kepegawaian\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Golongan extends Model
{
    use HasFactory;

    protected $table = 'golongan';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $timestamps = true;
    
    protected static function newFactory()
    {
        return \Modules\Kepegawaian\Database\factories\GolonganFactory::new();
    }

    public function riwayat_golongan() 
    {
        return $this->hasMany(RiwayatGolongan::class, "golongan_id");
    }
}
