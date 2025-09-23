<?php

namespace Modules\Persuratan\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SuratMasuk extends Model
{
    use HasFactory;

    protected $connection = 'persuratan';
    protected $table = 'surat_masuk';
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = ['id','id_user', 'nomor', 'perihal', 'dari', 'sifat', 'tanggal_surat', 'tanggal_terima', 'file', 'disposisi'];
    
    protected static function newFactory()
    {
        return \Modules\Persuratan\Database\factories\SuratMasukFactory::new();
    }
}
