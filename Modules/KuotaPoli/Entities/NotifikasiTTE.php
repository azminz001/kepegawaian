<?php

namespace Modules\KuotaPoli\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class NotifikasiTTE extends Model
{
    use HasFactory;

    protected $table = 'notifikasi_tte';
    protected $primaryKey = 'ID';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $connection = 'dev_apk';

    protected $fillable = ['SYNC', 'SYNC_DATE'];


    protected static function newFactory()
    {
        return \Modules\KuotaPoli\Database\factories\NotifikasiTTEFactory::new();
    }
}
