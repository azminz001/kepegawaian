<?php

namespace Modules\Kepegawaian\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class JenisJabatan extends Model
{
    use HasFactory;

    protected $table = 'jenis_jabatan';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $timestamps = true;

    protected $fillable = ['nama'];
    
    protected static function newFactory()
    {
        return \Modules\Kepegawaian\Database\factories\JenisJabatanFactory::new();
    }

    public function jabatan_unit() 
    {
        return $this->hasMany(JabatanUnit::class,"jenis_jabatan_id");
    }
}
