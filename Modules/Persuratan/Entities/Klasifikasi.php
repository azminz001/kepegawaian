<?php

namespace Modules\Persuratan\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Klasifikasi extends Model
{
    use HasFactory;

    protected $connection = 'persuratan';
    protected $table = 'klasifikasi';
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = ['kode', 'nama'];
    
    protected static function newFactory()
    {
        return \Modules\Persuratan\Database\factories\KlasifikasiFactory::new();
    }
}
