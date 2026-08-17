<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Product;

class Category extends Model
{
    //
    protected $fillable =[
                          'name',
                        ];

    public function allBrands()
    {
      return $this->hasMany(Brand::Class, 'categoryId');
    }
    public function allProducts()
    {
      return $this->hasMany(Product::Class, 'categoryId');
    }
}
