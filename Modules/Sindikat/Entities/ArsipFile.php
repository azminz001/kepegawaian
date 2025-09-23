<?php

namespace Modules\Sindikat\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ArsipFile extends Model
{
    use HasFactory;
    protected $table = 'file_arsip';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $timestamps = true;

    protected $connection = 'sindikat';

    protected $fillable = ['deskripsi', 'file', 'arsip_id'];
    
    protected static function newFactory()
    {
        return \Modules\Sindikat\Database\factories\ArsipFileFactory::new();
    }
    public function file_arsip() 
    {
        return $this->belongsTo(Arsip::class, "arsip_id");
    }
}
