<?php

namespace Modules\Rapat\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RuangRapat extends Model
{
    use HasFactory;

    protected $table = 'ruang_pertemuan';
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = ['nama', 'kapasitas'];
    
    protected static function newFactory()
    {
        return \Modules\Rapat\Database\factories\RuangRapatFactory::new();
    }
}
