<?php

namespace Modules\Sindikat\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KarirPesertaAll extends Model
{
    use HasFactory;

    protected $table = 'all_peserta_karir';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $timestamps = true;

    protected $connection = 'sindikat';

    protected $fillable = ['sanggahan', 'response_sanggah', 'verifikator_response', 'response_sanggah', 'update_keterangan'];
    
    protected static function newFactory()
    {
        return \Modules\Sindikat\Database\factories\KarirPesertaAllFactory::new();
    }
}
