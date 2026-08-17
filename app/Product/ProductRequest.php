<?php

namespace App\Product;

use Illuminate\Database\Eloquent\Model;

class ProductRequest extends Model
{
    protected $table = 'product_requests';
    protected $fillable = [
        'user_name',
        'user_phone',
        'user_email',
        'product_detail',
        'product_image',
        'soft_delete',
        'created_at',
        'updated_at'
    ];
}
