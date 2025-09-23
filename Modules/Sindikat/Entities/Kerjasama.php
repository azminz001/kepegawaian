<?php

namespace Modules\Sindikat\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Kerjasama extends Model
{
    use HasFactory;
    use HasUuids;
    protected $table = 'kerjasama';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $timestamps = true;

    protected $connection = 'sindikat';

    protected $fillable = ['id', 'no_ex', 'no_in', 'nama_institusi', 'nama_pimpinan', 'alamat', 'tanggal_mou', 'durasi', 'keterangan', 'dokumen'];
    
    protected static function newFactory()
    {
        return \Modules\Sindikat\Database\factories\KerjasamaFactory::new();
    }
}
