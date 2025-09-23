<?php

namespace Modules\Kepegawaian\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Keluhan extends Model
{
    use HasFactory;
    use HasUuids;
    protected $table = 'keluhan';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $timestamps = true;

    protected $fillable = ['id','judul','catatan','gambar','user_id'];
    
    protected static function newFactory()
    {
        return \Modules\Kepegawaian\Database\factories\KeluhanFactory::new();
    }

      //////////////////////////////////////////////////////////////
     ///*                  Eloquent Relationship              *////
    //////////////////////////////////////////////////////////////
    public function pengguna() 
    {
        return $this->belongsTo(Users::class, "user_id");
    }

    public function balasan() 
    {
        return $this->hasMany(KeluhanBalasan::class,"keluhan_id");
    }
}
