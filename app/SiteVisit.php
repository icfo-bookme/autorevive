<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SiteVisit extends Model
{
    protected $table = 'site_visits';
    protected $fillable = [
        'visitor_ip',
        'visited_at'
    ];
}
