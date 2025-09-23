<?php

namespace Modules\Sindikat\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InHouseTraining extends Model
{
    use HasFactory;
    use HasUuids;
    protected $table = 'in_house_training';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $timestamps = true;

    protected $connection = 'sindikat';

    protected $fillable = ['id', 'judul', 'tanggal_mulai', 'tanggal_selesai', 'sasaran_peserta', 'jumlah_peserta', 'narasumber', 'dokumen'];
    
    protected static function newFactory()
    {
        return \Modules\Sindikat\Database\factories\InHouseTrainingFactory::new();
    }
}
