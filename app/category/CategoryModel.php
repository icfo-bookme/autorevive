<?php

namespace App\category;

use App\item\ItemModel;
use Illuminate\Database\Eloquent\Model;
use App\subCategory\SubCategoryModel;

class CategoryModel extends Model
{

    protected $table = 'category';

    protected $fillable = [
        'name',
        'priority',
        'created_by',
        'updated_by',
        'soft_delete'
    ];


  public function sub_category(){
      return $this->hasMany(SubCategoryModel::class,'category_id','id')->where('soft_delete',0);
  }

  public function items(){
    return $this->hasMany(ItemModel::class,'category_id','id');
  }


}
