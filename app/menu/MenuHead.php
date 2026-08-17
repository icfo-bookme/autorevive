<?php

namespace App\menu;

use App\menu\MenuDetails;
use Illuminate\Database\Eloquent\Model;

class MenuHead extends Model
{
    public $table = "menu_head";
    public $fillable = [
        'menu',
        'soft_delete',
    ];

    public function details()
    {
        return $this->hasMany(MenuDetails::class, 'menu_id', 'id');
    }
}
