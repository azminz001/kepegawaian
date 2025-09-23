<?php

namespace Modules\Sindikat\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class PermohonanLitbang extends Model
{
    use HasFactory;
    use HasUuids;

    protected $table = 'permohonan_litbang';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $timestamps = true;

    protected $connection = 'sindikat';
    protected $fillable = ['nama', 'nim', 'perguruan_tinggi', 'fakultas', 'program_studi', 'no_hp', 'email', 'passcode', 'is_terms_agreed'];
    
    protected static function newFactory()
    {
        return \Modules\Sindikat\Database\factories\PermohonanLitbangFactory::new();
    }

    public function daftar_permohonan()
    {
        return $this->hasMany(PermohonanLitbangDetail::class, 'permohonan_litbang_id')->latest();
    }
}
