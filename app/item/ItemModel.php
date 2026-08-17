<?php

namespace App\item;

use Illuminate\Database\Eloquent\Model;
use App\subCategory\SubCategoryModel;
use App\Brand\BrandModel;
use App\category\CategoryModel;
use App\item\ItemPictureModel;
use App\item\ItemSpecification;
use App\section\SectionModel;
use App\tags\Tags;
use App\rating\RatingModel;
use App\stock\StockModel;
use App\item\ItemCarModelDetails;
class ItemModel extends Model
{
    protected $table = 'item';
    protected $fillable = [
        'category_id',
        'sub_category_id',
        'brand_id',
        'section_id',
        'name',
        'barcode',
        'length',
        'height',
        'width',
        'regular_price',
        'minimum_order_quantity',
        'cost_price',
        'sales_price',
        'offer_price',
        'thumbnail',
        'resized_image',
        'details',
        'sales_type',
        'is_published',
        'created_by',
        'updated_by',
        'soft_delete',
        'car_company_id',
        'car_brand_id',
        'car_model_id',
        'has_watermark',
        'resized_image',
        'is_outsourced'
    ];

    public function category()
    {
        return $this->belongsTo(CategoryModel::class, 'category_id', 'id');
    }

    public function sub_category()
    {
        return $this->belongsTo(SubCategoryModel::class, 'sub_category_id', 'id');
    }

    public function brand()
    {
        return $this->belongsTo(BrandModel::class, 'brand_id', 'id');
    }

    public function item_images()
    {
        return $this->hasMany(ItemPictureModel::class, 'item_id', 'id');
    }

    public function itemSpecification()
    {
        return $this->hasMany(ItemSpecification::class, 'item_id', 'id');
    }

    // public function section()
    // {
    //     return $this->hasMany(SectionModel::class, 'section_id', 'id');
    // }


    public function section()
    {
        return $this->belongsTo(SectionModel::class, 'section_id', 'id');
    }

    public function tags()
    {
        return $this->hasMany(Tags::class, 'item_id', 'id');
    }

    public function rating()
    {
        return $this->hasMany(RatingModel::class, 'item_id', 'id');
    }

    public function sortBy_rating_desc()
    {
        return $this->hasMany(RatingModel::class, 'item_id', 'id')->select('rating');
    }

    public function stock()
    {
        return $this->hasOne(StockModel::class, 'item_id', 'id')->where('soft_delete', 0);
    }


    public function checkModel(){
        return $this->hasMany(ItemCarModelDetails::class,'item_id','id');
    }





}
