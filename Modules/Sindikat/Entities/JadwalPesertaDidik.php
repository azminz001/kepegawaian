<?php

namespace Modules\Sindikat\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Kepegawaian\Entities\Unit;


class JadwalPesertaDidik extends Model
{
    use HasFactory;
    protected $table = 'pesertadidik_jadwal';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $timestamps = true;

    protected $connection = 'sindikat';
    protected $fillable = [
        'tanggal_mulai',
        'tanggal_selesai',
        'unit_id',
        'peserta_didik_id'
    ];
    
    protected static function newFactory()
    {
        return \Modules\Sindikat\Database\factories\JadwalPesertaDidikFactory::new();
    }

    /**
     * Get the user that owns the JadwalPesertaDidik
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function peserta_didik()
    {
        return $this->belongsTo(PesertaDidik::class, 'peserta_didik_id');
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class, 'unit_id');
    }
}
