<?php

namespace Modules\Sindikat\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Diklat extends Model
{
    use HasFactory;
    use HasUuids;
    protected $table = 'diklat';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $timestamps = true;

    protected $connection = 'sindikat';

    protected $fillable = ['perihal', 'tanggal_mulai', 'tanggal_selesai', 'penyelenggara', 'tempat', 'jenis'];
    
    protected static function newFactory()
    {
        return \Modules\Sindikat\Database\factories\DiklatFactory::new();
    }

    //Pegawai Diklat
    // public function pegawai() 
    // {
    //     return $this->hasMany(Jurusan::class, "institusi_id");
    // }
}
