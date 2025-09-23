<?php

namespace Modules\WhatsAppAPI\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SampleAPI extends Model
{
    use HasFactory;
    protected $table = 'sample_pegawai';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $timestamps = true;

    protected $fillable = ['nama','nomor_induk','no_hp', 'tanggal_lahir'];
}

