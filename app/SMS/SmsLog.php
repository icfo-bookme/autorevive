<?php

namespace App\SMS;

use Illuminate\Database\Eloquent\Model;

class SmsLog extends Model
{
    protected $table = 'sms_logs';
    protected $fillable = [
        'phone',
        'message',
        'created_by',
        'status',
        'status_code',
        'error_message',
        'smsinfo',
    ];
}
