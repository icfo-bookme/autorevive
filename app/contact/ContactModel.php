<?php

namespace App\contact;

use Illuminate\Database\Eloquent\Model;

class ContactModel extends Model
{
    protected $table = 'contact_table';
    protected $fillable =[
        'name',
        'email',
        'contact_number',
        'message',
        'type',
        'is_replied',
        'soft_delete'
    ];
    
}
