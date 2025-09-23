<?php

namespace Modules\WhatsAppAPI\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LogWhatsAppSent extends Model
{
    use HasFactory;

    protected $table = 'log_wa_sent';
    public $timestamps = false;

    protected $fillable = [
        'jenis',
        'catatan',
        'status',
        'created_at'
    ];
    
    protected static function newFactory()
    {
        return \Modules\WhatsAppAPI\Database\factories\LogWhatsAppSentFactory::new();
    }
}
