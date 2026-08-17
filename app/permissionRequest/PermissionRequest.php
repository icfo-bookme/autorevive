<?php

namespace App\permissionRequest;

use Illuminate\Database\Eloquent\Model;

class PermissionRequest extends Model
{
    protected $table = 'permission_requests';
    protected $fillable = [
        'user_id',
        'previous_url',
        'current_url',
        'permission',
        'requested_by',
        'approved_by'
    ];


}
