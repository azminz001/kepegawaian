<?php

namespace Modules\Sindikat\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Institusi extends Model
{
    use HasFactory;
    use HasUuids;
    protected $table = 'institusi';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $timestamps = true;

    protected $connection = 'sindikat';

    protected $fillable = ['id', 'nama', 'level', 'akreditasi', 'nama_pimpinan', 'telp',  'no_wa', 'email', 'alamat', 'kota', 'provinsi', 'logo', 'status'];

    protected static function newFactory()
    {
        return \Modules\Sindikat\Database\factories\InstitusiFactory::new();
    }

    public function jurusan() 
    {
        return $this->hasMany(Jurusan::class, "institusi_id");
    }

    public function permohonan_magang() 
    {
        return $this->hasMany(PermohonanMagang::class, "institusi_id");
    }

    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'ref_id', 'id');
    }

    public function permohonan_studibanding() 
    {
        return $this->hasMany(PermohonanStudiBanding::class, "institusi_id");
    }

    public function siswa()
    {
        return $this->hasMany(PesertaDidik::class, "institusi_id");
    }

    public function peserta_didik(){
        return $this->join('jurusan', 'institusi.id', '=', 'jurusan.institusi_id')
                    ->join('peserta_didik', 'jurusan.id', '=', 'peserta_didik.jurusan_id')
                    ->join('permohonan_magang', 'institusi.id', '=', 'permohonan_magang.institusi_id');
    }

}
