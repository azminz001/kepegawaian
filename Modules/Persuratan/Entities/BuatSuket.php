<?php

namespace Modules\Persuratan\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BuatSuket extends Model
{
    use HasFactory;

    protected $connection = 'persuratan';
    protected $table = 'buat_suket';
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = ['id_penomoran', 'id_suket', 'pegawai_id', 'tanggal_pengajuan', 'tanggal_terbit', 'keterangan', 'file', 'status'];

    protected static function newFactory()
    {
        return \Modules\Persuratan\Database\factories\SuketFactory::new();
    }
}
