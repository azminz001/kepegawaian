<?php

namespace Modules\Sindikat\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Arsip extends Model
{
    use HasFactory;

    protected $table = 'arsip';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $timestamps = true;

    protected $connection = 'sindikat';

    protected $fillable = ['judul', 'slug', 'content', 'jenis', 'kategori_id'];
    
    protected static function newFactory()
    {
        return \Modules\Sindikat\Database\factories\ArsipFactory::new();
    }

    public function kategori() 
    {
        return $this->belongsTo(Kategori::class, "kategori_id");
    }
    public function arsip_file() 
    {
        return $this->hasMany(ArsipFile::class, "arsip_id");
    }

    public function get_thumbnail()
    {
        return $this->hasOne(ArsipFile::class, "arsip_id");
    }
}
