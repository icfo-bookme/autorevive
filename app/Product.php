<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Category;
use App\Brand;

class Product extends Model
{
    //
    protected $fillable =[
                          'title',
                          'imagePath',
                          'description',
                          'price'
                        ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'categoryId', 'id');
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brandId', 'id');
    }



}
