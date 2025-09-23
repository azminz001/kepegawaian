<?php

namespace Modules\Sindikat\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Kategori extends Model
{
    use HasFactory;
    protected $table = 'kategori';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $timestamps = true;

    protected $connection = 'sindikat';

    protected $fillable = ['nama', 'slug', 'keterangan'];
    
    protected static function newFactory()
    {
        return \Modules\Sindikat\Database\factories\KategoriFactory::new();
    }
    public function arsip() 
    {
        return $this->hasMany(Arsip::class, "kategori_id");
    }
}
