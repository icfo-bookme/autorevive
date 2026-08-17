<?php

namespace App\subCategory;

use App\category\CategoryModel;

use Illuminate\Database\Eloquent\Model;

class SubCategoryModel extends Model
{
    protected $table = 'sub_category';
    protected $fillable = [
        'category_id',
        'name',
        'created_by',
        'updated_by',
        'soft_delete'
    ];



    public function category()
    {
        return $this->belongsTo(CategoryModel::class, 'category_id', 'id');
    }


    
}
