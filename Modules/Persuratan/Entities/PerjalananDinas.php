<?php

namespace Modules\Persuratan\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PerjalananDinas extends Model
{
    use HasFactory;

    protected $connection = 'persuratan';
    protected $table = 'perjalanan_dinas';
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = ['dasar_surat', 'nomor_surat', 'tanggal_surat', 'id_user', 'keperluan', 'tanggal_berangkat', 'tanggal_pulang', 'kota_tujuan', 'tempat_tujuan', 'nama_driver'];

    
    protected static function newFactory()
    {
        return \Modules\Persuratan\Database\factories\PerjalananDinasFactory::new();
    }
}
