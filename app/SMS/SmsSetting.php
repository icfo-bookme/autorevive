<?php

namespace App\SMS;

use Illuminate\Database\Eloquent\Model;

class SmsSetting extends Model
{
    protected $table = 'sms_settings';
    protected $fillable = [
        'type',
        'sms_body',
        'status',
        'created_by',
        'updated_by',
        'soft_delete'
    ];


    public function createdBy(){
        return $this->belongsTo(User::class,'created_by','id');
    }
    public function updatedBy(){
        return $this->belongsTo(User::class,'updated_by','id');
    }
    
}
