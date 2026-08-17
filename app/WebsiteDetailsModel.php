<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WebsiteDetailsModel extends Model
{
    public $table = "website_details";
    public $fillable = [
        'banner_image_path',
        'logo_path',
        'banner_text',
        'soft_delete'
    ];
}
