<?php

namespace Modules\Sindikat\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;


class User extends Model
{
    use HasFactory;
    use HasUuids;

    protected $table = 'users';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $timestamps = true;

    protected $connection = 'sindikat';

    protected $fillable = ['id', 'name', 'email', 'password', 'level', 'ref_id', 'status'];

    protected static function newFactory()
    {
        return \Modules\Sindikat\Database\factories\UsersFactory::new();
    }

    public function institusi(): HasOne
    {
        return $this->hasOne(Institusi::class, 'ref_id', 'id');
    }
}
