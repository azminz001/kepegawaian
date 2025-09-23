<?php

namespace Modules\Sindikat\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Jenjang extends Model
{
    use HasFactory;
    protected $table = 'jenjang';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $timestamps = true;

    protected $connection = 'sindikat';

    protected $fillable = ['nama'];
    
    protected static function newFactory()
    {
        return \Modules\Sindikat\Database\factories\JenjangFactory::new();
    }
    public function jurusan() 
    {
        return $this->hasMany(Jurusan::class, "jenjang_id");
    }
}
