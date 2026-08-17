<?php

namespace App\highlights;

use Illuminate\Database\Eloquent\Model;

class HighlightsModel extends Model
{
    protected $table = 'highlights';
    protected $fillable = [
        'type_id',
        'type',
        'summary',
        'created_by',
    ];
    

}
