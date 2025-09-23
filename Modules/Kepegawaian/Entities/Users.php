<?php

namespace Modules\Kepegawaian\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Users extends Model
{
    use HasFactory;

    protected $table = 'users';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $timestamps = true;

    protected $fillable = ['name','email', 'username', 'password', 'level'];
    
    protected static function newFactory()
    {
        return \Modules\Kepegawaian\Database\factories\UnitFactory::new();
    }

}
