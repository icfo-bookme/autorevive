<?php

namespace App\section;

use Illuminate\Database\Eloquent\Model;
use App\item\ItemModel;

class SectionModel extends Model
{
    protected $table = 'section';
    protected $fillable = [

        'name',
        'created_by',
        'updated_by',
        'soft_delete'

    ];


  public function items(){
    return $this->hasMany(ItemModel::class,'section_id','id')->where('soft_delete',0)->where('is_published',1)->orderBy('updated_at','DESC');
  }



}
