<?php

namespace Modules\Sindikat\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KarirPeserta extends Model
{
    use HasFactory;

    protected $table = 'karir_peserta_2025';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $timestamps = true;

    protected $connection = 'sindikat';

    protected $fillable = ['sanggahan', 'response_sanggah', 'verifikator_response', 'response_sanggah', 'update_keterangan'];
    
    protected static function newFactory()
    {
        return \Modules\Sindikat\Database\factories\KarirPesertaFactory::new();
    }
}
