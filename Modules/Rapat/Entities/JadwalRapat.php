<?php

namespace Modules\Rapat\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class JadwalRapat extends Model
{
    use HasFactory;

    protected $table = 'jadwal_rapat';
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = ['uuid','id_ruang', 'pegawai_id', 'nama_rapat', 'tanggal', 'jam_mulai', 'jam_selesai', 'jumlah_peserta', 'jumlah_snack', 'jumlah_makan', 'status'];

    protected static function newFactory()
    {
        return \Modules\Rapat\Database\factories\RuangRapatFactory::new();
    }
}
