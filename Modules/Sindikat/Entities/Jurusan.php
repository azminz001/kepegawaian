<?php

namespace Modules\Sindikat\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Jurusan extends Model
{
    use HasFactory;
    use HasUuids;
    protected $table = 'jurusan';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $timestamps = true;

    protected $connection = 'sindikat';

    protected $fillable = ['id','nama', 'keterangan', 'jenjang_id', 'institusi_id'];
    
    protected static function newFactory()
    {
        return \Modules\Sindikat\Database\factories\JurusanFactory::new();
    }
    public function institusi() 
    {
        return $this->belongsTo(Institusi::class, "institusi_id");
    }
    public function jenjang() 
    {
        return $this->belongsTo(Jenjang::class, "jenjang_id");
    }
    public function peserta_didik() 
    {
        return $this->hasMany(PesertaDidik::class, "jurusan_id");
    }
}
