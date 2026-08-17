<?php

namespace App\rating;

use Illuminate\Database\Eloquent\Model;

class RatingModel extends Model
{
    protected $table = 'ratings';

    protected $fillable = [
        'item_id',
        'rating',
        'review',
        'name',
        'email',
        'soft_delete',
    ];

    protected $attributes = [
        'soft_delete' => 0
    ];
}
