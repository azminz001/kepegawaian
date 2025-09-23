<?php

namespace Modules\Persuratan\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Suket extends Model
{
    use HasFactory;

    protected $connection = 'persuratan';
    protected $table = 'surat_keterangan';
    protected $primaryKey = 'id_suket';
    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = ['id_suket', 'id_klasifikasi', 'nama_suket', 'isi', 'keperluan'];
    
    protected static function newFactory()
    {
        return \Modules\Persuratan\Database\factories\SuketFactory::new();
    }
}
