<?php

namespace Modules\Kepegawaian\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Berita extends Model
{
    use HasFactory;
    use HasUuids;
    protected $table = 'berita';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $timestamps = true;

    protected $fillable = ['id','perihal','judul','deskripsi', 'jenis'];
    
    protected static function newFactory()
    {
        return \Modules\Kepegawaian\Database\factories\AnakPegawaiFactory::new();
    }

}
