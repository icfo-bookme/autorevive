<?php

namespace App\item;

use Illuminate\Database\Eloquent\Model;
use App\item\ItemModel;
class ItemCarModelDetails extends Model
{
    protected $table = 'item_car_model_details';
    protected $fillable =[
        'item_id',
        'car_model_id'
    ];




    public function item(){
        return $this->hasMany(ItemModel::class,'id','item_id');
    }

    

    public function car_models()
    {
        return $this->hasOne(CarModelModel::class, 'id', 'car_model_id');
    }
    
  
    
}
