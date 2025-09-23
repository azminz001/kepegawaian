<?php

namespace Modules\Rapat\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KehadiranRapat extends Model
{
    use HasFactory;

    protected $table = 'kehadiran_rapat';
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = ['uuid_jadwal_rapat','nama_peserta', 'nip_nrp', 'instansi'];

    protected static function newFactory()
    {
        return \Modules\Rapat\Database\factories\RuangRapatFactory::new();
    }
}
