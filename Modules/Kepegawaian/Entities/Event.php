<?php

namespace Modules\Kepegawaian\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Event extends Model
{
    use HasFactory;

    protected $table = 'events';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $timestamps = false;

    // Tambahkan properti ini untuk mengatur koneksi database
    protected $connection = 'mysql2';

    protected static function newFactory()
    {
        return \Modules\Kepegawaian\Database\factories\EventFactory::new();
    }

}