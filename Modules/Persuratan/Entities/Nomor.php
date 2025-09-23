<?php

namespace Modules\Persuratan\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Nomor extends Model
{
    use HasFactory;

    protected $connection = 'persuratan';
    protected $table = 'penomoran';
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = ['id_user','id_klasifikasi', 'nomor', 'kelompok', 'bulan', 'tahun', 'nama_surat', 'tanggal_surat', 'status', 'file'];
    
    protected static function newFactory()
    {
        return \Modules\Persuratan\Database\factories\NomorFactory::new();
    }
}
