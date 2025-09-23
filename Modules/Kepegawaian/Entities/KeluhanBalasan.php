<?php

namespace Modules\Kepegawaian\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KeluhanBalasan extends Model
{
    use HasFactory;
    use HasUuids;
    protected $table = 'keluhan_balasan';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $timestamps = true;

    protected $fillable = ['id','balasan','gambar','user_id', 'keluhan_id'];
    
    protected static function newFactory()
    {
        return \Modules\Kepegawaian\Database\factories\KeluhanBalasanFactory::new();
    }

      //////////////////////////////////////////////////////////////
     ///*                  Eloquent Relationship              *////
    //////////////////////////////////////////////////////////////
    public function pengguna() 
    {
        return $this->belongsTo(Users::class, "user_id");
    }

    public function keluhan() 
    {
        return $this->belongsTo(Keluhan::class, "keluhan_id");
    }
}
