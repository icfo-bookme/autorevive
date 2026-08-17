<?php

namespace App\menu;

use Illuminate\Database\Eloquent\Model;

class MenuDetails extends Model
{
    public $table = "menu_details";
    public $fillable = [
        'menu_id',
        'name',
        'route',
        'soft_delete',
    ];
}
