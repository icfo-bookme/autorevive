<?php

namespace App\SMS;
use App\User;
use Illuminate\Database\Eloquent\Model;

class SmsTemplate extends Model
{
    protected $table = 'sms_templates';
    protected $fillable = [
        'name',
        'body',
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
