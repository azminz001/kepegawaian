<?php

namespace Modules\WhatsAppAPI\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Devices extends Model
{
    use HasFactory;
    protected $table = 'whatsapp_device';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $timestamps = true;

    protected $fillable = ['device_id','device_name','nomor_hp', 'status'];

}

