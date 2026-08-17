<?php

namespace App\Http\Controllers\react;

use Item;
use App\User;
use App\OrderModel;
use App\item\ItemModel;
use App\Brand\BrandModel;
use Illuminate\Http\Request;
use App\section\SectionModel;
use App\category\CategoryModel;
use App\Product\ProductRequest;
use App\customer\CustomerModel;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\deliveryCharge\DeliveryChargeModel;
use App\subCategory\SubCategoryModel;
use DB;
use App\item\ItemCarModelDetails;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;

class HomePageController extends Controller
{
    //New comment
    public function categories()
    {

        $allCategories = CategoryModel::where('soft_delete', 0)->with('sub_category')->orderBy('priority', 'ASC')->orderBy('id', 'ASC')->get();
        return response()->json($allCategories);
    }

    public function mainCategories()
    {
        $allCategories = CategoryModel::where('soft_delete', 0)->with('sub_category')->orderBy('priority', 'ASC')->orderBy('id', 'ASC')->get();
        return response()->json($allCategories);
    }


    public function latestCollection()
    {
        $latestProducts = ItemModel::orderBy('id', 'desc')
            ->where('soft_delete', 0)
            ->where('is_outsourced',0)
            ->where('is_published', 1)
            ->with('category')
            ->with('sub_category')
            ->with('rating')
            ->take(30)
            ->get();

        return response()->json($latestProducts);
    }

    public function dynamicSections(Request $request)
    {
        // $sections = SectionModel::where('soft_delete', 0)
        //     ->with('items', 'items.category', 'items.sub_category', 'items.rating')
        //     ->orderBy('section_order','ASC')
        //     ->get();

        // $cachedResults = Cache::remember('dynamicSectionProducts', 2*60*60, function()
        // {
        //     $sections = SectionModel::where('soft_delete', 0)->with('items', 'items.category', 'items.sub_category', 'items.rating')->orderBy('section_order','ASC')->get()->map(function($query) {
        //         $query->setRelation('items', $query->items->take(11));
        //         return $query;
        //     });

        //     return $sections;
        // });

        $sections = SectionModel::where('soft_delete', 0)
                                ->with('items', 'items.category', 'items.sub_category', 'items.rating')
                                ->orderBy('section_order', 'ASC')
                                ->get()
                                ->map(function ($query) {
                                    $query->setRelation('items', $query->items->take(30));
                                    return $query;
                                });

        return response()->json($sections);
    }

    public function getSidecartReactData()
    {
        $cart = Session::has('cart') ? Session::get('cart') : null;
        $shippingCharge = DeliveryChargeModel::where('soft_delete', '0')->where('name', 'shippingcharge')->first();

        $dataArray = [
            'cart' => $cart,
            'shippingCharge' => $shippingCharge
        ];

        return response()->json($dataArray);
    }


    public function getWishReactData()
    {
        $wish = Session::has('wish') ? Session::get('wish') : null;

        $dataArray = [
            'wish' => $wish,

        ];

        return response()->json($dataArray);
    }

    /**
     *
     * edite_by Usama
     * edit_list
     *          ===(1)===
     *          - added sort block
     */
    // public function allProducts(Request $request)
    // {
    //     $category_id = $request->category_id;
    //     $subcategory_id = $request->subcategory_id;
    //     $per_page = 16;
    //     $skip = $request->skipCount;

    //     if ($category_id) {
    //         $allProducts = ItemModel::where('soft_delete', 0)
    //             ->where('is_published', 1)
    //             ->where('category_id', $category_id)
    //             ->with('rating');
    //         if ($subcategory_id) {
    //             $allProducts = ItemModel::where('soft_delete', 0)
    //                 ->where('is_published', 1)
    //                 ->where('category_id', $category_id)
    //                 ->where('sub_category_id', $subcategory_id)
    //                 ->with('rating');
    //         }
    //     } else {
    //         $allProducts = ItemModel::where('soft_delete', 0)
    //             ->where('is_published', 1)
    //             ->with('rating');
    //     }

    //     if ($request->sortBy) {
    //         $sort_param = $request->sortBy;

    //         if ($sort_param == 'average') {
    //             $allProducts = ItemModel::select('*')
    //                                     ->where('is_published', 1)
    //                                     // ->where('soft_delete', 0) // ===| Column 'soft_delete' in where clause is ambiguous |===
    //                                     ->with('rating');
    //             $allProducts = $allProducts->leftJoin('ratings', 'item.id', '=', 'ratings.item_id')
    //                                     ->select('*','item.id as id','item.name as name',DB::raw('avg(ratings.rating) as avgRating'))
    //                                     ->where('item.soft_delete', 0);

    //             if ($category_id != 'search' && $category_id > 0) {
    //                 $allProducts->where('category_id', $category_id);
    //             }

    //             if (isset($request->subCategory)) {
    //                 $allProducts->where('sub_category_id', $request->subCategory);
    //             }

    //             $allProducts = $allProducts->groupBy('item.id')->orderBy('avgRating', 'DESC');
    //             $allProducts = $allProducts->paginate($per_page);

    //             return response()->json($allProducts);

    //         } elseif ($sort_param ==  'popularity') {
    //             $allProducts->where('sales_type', 'bestrated');
    //         } elseif ($sort_param == 'time') {
    //             $allProducts->orderBy('created_at', 'DESC');
    //         } elseif ($sort_param == 'price_asc') {
    //             $allProducts->orderBy('sales_price', 'ASC');
    //         } elseif ($sort_param == 'price_desc') {
    //             $allProducts->orderBy('sales_price', 'DESC');
    //         } elseif ($sort_param == 'name') {
    //             $allProducts->orderBy('name');
    //         }
    //     }

    //     $allProducts = $allProducts->paginate($per_page);

    //     return response()->json($allProducts);
    // }

    public function allProducts(Request $request)
    {
        $category_id = $request->category_id;
        $subcategory_id = $request->subcategory_id;
        $per_page = 16;
        $skip = $request->skipCount;

        if ($category_id) {
            $allProducts = ItemModel::where('soft_delete', 0)
                ->where('is_outsourced',0)
                ->where('is_published', 1)
                ->where('category_id', $category_id)
                ->with('rating');
            if ($subcategory_id) {
                $allProducts = ItemModel::where('soft_delete', 0)
                    ->where('is_outsourced',0)
                    ->where('is_published', 1)
                    ->where('category_id', $category_id)
                    ->where('sub_category_id', $subcategory_id)
                    ->with('rating');
            }
        } else {
            $allProducts = ItemModel::where('soft_delete', 0)
                ->where('is_outsourced',0)
                ->where('is_published', 1)
                ->with('rating');
        }

        if ($request->sortBy) {
            $sort_param = $request->sortBy;

            if ($sort_param == 'average') {
                $allProducts = ItemModel::select('*')
                    ->where('is_outsourced',0)
                    ->where('is_published', 1)
                    // ->where('soft_delete', 0) // ===| Column 'soft_delete' in where clause is ambiguous |===
                    ->with('rating');
                $allProducts = $allProducts->leftJoin('ratings', 'item.id', '=', 'ratings.item_id')
                    ->select('*', 'item.id as id', 'item.name as name', DB::raw('avg(ratings.rating) as avgRating'))
                    ->where('item.soft_delete', 0)->where('item.is_outsourced',0);

                if ($category_id != 'search' && $category_id > 0) {
                    $allProducts->where('category_id', $category_id);
                }

                if (isset($request->subCategory)) {
                    $allProducts->where('sub_category_id', $request->subCategory);
                }

                $allProducts = $allProducts->groupBy('item.id')->orderBy('avgRating', 'DESC');
                $allProducts = $allProducts->take(TAKE_PRODUCT_FOR_SHOP_PAGE)->skip($skip)->get();
                // $allProducts = $allProducts->paginate($per_page);

                return response()->json($allProducts);

            } elseif ($sort_param == 'popularity') {
                $allProducts->where('sales_type', 'bestrated');
            } elseif ($sort_param == 'time') {
                $allProducts->orderBy('created_at', 'DESC');
            } elseif ($sort_param == 'price_asc') {
                $allProducts->orderBy('sales_price', 'ASC');
            } elseif ($sort_param == 'price_desc') {
                $allProducts->orderBy('sales_price', 'DESC');
            } elseif ($sort_param == 'name') {
                $allProducts->orderBy('name');
            }
        }

        // $allProducts = $allProducts->paginate($per_page);
        $allProducts = $allProducts->take(TAKE_PRODUCT_FOR_SHOP_PAGE)->skip($skip)->get();

        return response()->json($allProducts);
    }

    public function getProductsByProps(Request $request)
    {

        $companyId = $request->companyId;
        $brandId = $request->brandId;
        $modelId = $request->modelId;
        $skip = $request->skipCount;

        $allFilters = [
            "companyId" => $companyId,
            "brandId" => $brandId,
            "modelId" => $modelId
        ];


        $latestProducts = ItemModel::orderBy('id', 'desc')
            ->where('soft_delete', 0)
            ->where('is_outsourced',0)
            ->where('is_published', 1)
            ->with('category')
            ->with('rating')
            ->with('checkModel')
            ->where(function ($q) use ($companyId) {
                $q->where('car_company_id', $companyId);
                //->orWhereNull('car_company_id');
            });



        // $sections = SectionModel::where('soft_delete', 0)
        //                         ->with('items.category')
        //                         ->with('items.rating')
        //                         ->with(array('items' => function ($query) use ($allFilters) {

        //                           //  $query->where('item.car_company_id', $allFilters['companyId']);

        //                             $query->where(function($q) use ( $allFilters) {
        //                                 $q->where('item.car_company_id', $allFilters['companyId'])
        //                                   ->orWhereNull('item.car_company_id');
        //                             });


        //                             if ($allFilters['brandId'] != null) {
        //                              //   $query->where('item.car_brand_id', $allFilters['brandId']);


        //                                 $query->where(function($q) use ( $allFilters) {
        //                                     $q->where('item.car_brand_id', $allFilters['brandId'])
        //                                       ->orWhereNull('item.car_brand_id');
        //                                 });
        //                             }

        //                             if ($allFilters['modelId'] != null) {
        //                                // $query->where('item.car_model_id', $allFilters['modelId']);


        //                                 // $query->where(function($q) use ( $allFilters) {
        //                                 //     $q->where('item.car_model_id', $allFilters['modelId'])
        //                                 //       ->orWhereNull('item.car_model_id');
        //                                 // });


        //                                 $query->whereHas('checkModel', function ($query2) use ($allFilters) {
        //                                     $query2->where(function ($q) use ($allFilters) {
        //                                         $q->where('car_model_id', $allFilters['modelId']);
        //                                           //  ->orWhere('name', 'LIKE', '%'.$keyword.'%');
        //                                     });
        //                                 });
        //                             }
        //                         }));

        if (isset($brandId)) {
            // $latestProducts  = $latestProducts->where('car_brand_id', $brandId);
            $latestProducts = $latestProducts->where(function ($q) use ($brandId) {
                $q->where('car_brand_id', $brandId);
                    // ->orWhereNull('car_brand_id');
            });

        }

        if (isset($modelId)) {
            //    $latestProducts  = $latestProducts->where('car_model_id', $modelId);

            // $latestProducts  = $latestProducts->where(function($q) use ($modelId) {
            //     $q->where('car_model_id', $modelId)
            //       ->orWhereNull('car_model_id');
            // });

            // $latestProducts = $latestProducts->doesnthave('checkModel')->orWhereHas('checkModel', function ($query) use ($modelId) {
            //     $query->where(function ($q) use ($modelId) {
            //         $q->where('car_model_id', $modelId);
            //     });
            // });

            $latestProducts = $latestProducts->WhereHas('checkModel', function ($query) use ($modelId) {
                $query->where(function ($q) use ($modelId) {
                    $q->where('car_model_id', $modelId);
                });
            });

        }

        $latestProducts = $latestProducts->take(TAKE_PRODUCT_FOR_SHOP_PAGE)->skip($skip)->get();

        // $sections           = $sections->get();

        $data = [
            "latestProducts" => $latestProducts,
            // "sections"       => $sections,
            "model" => $modelId
        ];

        return response()->json($data);
    }


    /**
     * edited_by Usama
     * edit_list
     *          ===(1)===
     *          - rewritten the whole function
     *          - previous code
     *              $allProducts = ItemModel::where('soft_delete', 0)->where('is_published', 1)->where('category_id', $request->id)->with('rating')->get();
     *              return response()->json($allProducts);
     */
    public function shopByCat(Request $request)
    {
        $skip = $request->get('skipCountCat');
        $allProducts = ItemModel::where('is_published', 1)
            ->where('is_outsourced',0)
            ->where('category_id', $request->id)
            ->with('rating');

        if (isset($request->sortBy)) {
            if ($request->sortBy == 'average') {
                $allProducts = $allProducts->leftJoin('ratings', 'item.id', '=', 'ratings.item_id')
                    ->select('*', 'item.id as id', 'item.name as name', DB::raw('avg(ratings.rating) as avgRating'))
                    ->where('item.soft_delete', 0)
                    ->groupBy('item.id')
                    ->orderBy('avgRating', 'DESC')
                    ->take(TAKE_PRODUCT_FOR_SHOP_PAGE)
                    ->skip($skip)
                    ->get();

                return response()->json($allProducts);
            } elseif ($request->sortBy == 'popularity') {
                $allProducts->where('sales_type', 'bestrated');
            } elseif ($request->sortBy == 'time') {
                $allProducts->orderBy('created_at', 'DESC');
            } elseif ($request->sortBy == 'price_asc') {
                $allProducts->orderBy('sales_price', 'ASC');
            } elseif ($request->sortBy == 'price_desc') {
                $allProducts->orderBy('sales_price', 'DESC');
            } elseif ($request->sortBy == 'name') {
                $allProducts->orderBy('name');
            }
        }

        $allProducts = $allProducts->where('soft_delete', 0)->take(TAKE_PRODUCT_FOR_SHOP_PAGE)->skip($skip)->get();

        return response()->json($allProducts);
    }


    function shopBySubCat(Request $request)
    {
        $skip = $request->get('skipCountSubCat');
        $allProducts = ItemModel::where('soft_delete', 0)->where('is_outsourced',0)
            ->where('is_published', 1)->where('sub_category_id', $request->subCategory);

        if ($request->category) {
            $allProducts = $allProducts->where('category_id', $request->category);
        }

        $allProducts = $allProducts->with('rating')->take(TAKE_PRODUCT_FOR_SHOP_PAGE)->skip($skip)->get();
        return response()->json($allProducts);
    }

    /**
     * @param Request $request
     * This route is used for filtering data from section products page
     */
    public function sortProductBySectionWithParam(Request $request)
    {
        $sort_param = $request->param;
        $section_id = $request->section_id;
        $skip = $request->skipCount;

        $items = ItemModel::select('*')
            ->where('is_published', 1)
            ->where('is_outsourced',0)
            ->with('rating');

        // all sorts
        if ($sort_param == 'average') {
            $items = $items->leftJoin('ratings', 'item.id', '=', 'ratings.item_id')
                ->select('*', 'item.id as id', 'item.name as name', DB::raw('avg(ratings.rating) as avgRating'))
                ->where('item.soft_delete', 0);

            if ($section_id) {
                $items->where('section_id', $section_id);
            }

            $items = $items->groupBy('item.id')->orderBy('avgRating', 'DESC');
            $items = $items->take(TAKE_PRODUCT_FOR_SHOP_PAGE)->skip($skip)->get();
            return response()->json($items);

        } elseif ($sort_param == 'popularity') {
            $items->where('sales_type', 'bestrated');
        } elseif ($sort_param == 'time') {
            $items->orderBy('created_at', 'DESC');
        } elseif ($sort_param == 'price_asc') {
            $items->orderBy('sales_price', 'ASC');
        } elseif ($sort_param == 'price_desc') {
            $items->orderBy('sales_price', 'DESC');
        } elseif ($sort_param == 'name') {
            $items->orderBy('name');
        }elseif ($sort_param == 'onsale') {
            $items = $items->whereColumn('regular_price','>','sales_price');
        }

        // selected category
        if ($section_id > 0) {
            $items->where('section_id', $section_id);
        }

        $items = $items->where('soft_delete', 0)->take(TAKE_PRODUCT_FOR_SHOP_PAGE)->skip($skip)->get();

        return response()->json($items);

    }

    public function sortProductByParam(Request $request)
    {
        $sort_param = $request->param;
        $category_id = $request->category;
        $per_page = $request->itemsCountPerPage ? $request->itemsCountPerPage : 16;
        $skip = $request->skipCount;

        $items = ItemModel::select('*')
            ->where('is_published', 1)
            ->where('is_outsourced',0)
            ->with('rating')
            ->with('checkModel');
        // ->where('soft_delete', 0) // ===| Column 'soft_delete' in where clause is ambiguous |===

        // car search
        if ($request->is_searched) {
            if ($request->comapny_id) {
                $items->where('car_company_id', $request->comapny_id);
            }

            if ($request->brand_id) {
                $items->where('car_brand_id', $request->brand_id);
            }

            // if ($request->model_id) {
            //     $items->where('car_model_id', $request->model_id);
            // }

            // //including null value
            // if ($request->model_id) {
            //     $modelId = $request->model_id;
            //     $items->doesnthave('checkModel')->orWhereHas('checkModel', function ($query) use ($modelId) {
            //         $query->where(function ($q) use ($modelId) {
            //             $q->where('car_model_id', $modelId);
            //         });
            //     });
            // }
            if ($request->model_id) {
                $modelId = $request->model_id;
                $items->WhereHas('checkModel', function ($query) use ($modelId) {
                    $query->where(function ($q) use ($modelId) {
                        $q->where('car_model_id', $modelId);
                    });
                });
            }

        }

        // all sorts
//        if ($sort_param == 'average') {
//            $items = $items->leftJoin('ratings', 'item.id', '=', 'ratings.item_id')
//                ->select('*', 'item.id as id', 'item.name as name', DB::raw('avg(ratings.rating) as avgRating'))
//                ->where('item.soft_delete', 0);
//
//            if ($category_id != 'search' && $category_id > 0) {
//                $items->where('category_id', $category_id);
//            }
//
//            if (isset($request->subCategory)) {
//                $items->where('sub_category_id', $request->subCategory);
//            }
//
//            $items = $items->groupBy('item.id')->orderBy('avgRating', 'DESC');
//            // $items = $items->get();
//            $items = $items->paginate($per_page);
//            return response()->json($items);
//
//        } elseif ($sort_param == 'popularity') {
//            $items->where('sales_type', 'bestrated');
//        }


        if ($sort_param == 'time') {
            $items->orderBy('created_at', 'DESC');
        } elseif ($sort_param == 'price_asc') {
            $items->orderBy('sales_price', 'ASC');
        } elseif ($sort_param == 'price_desc') {
            $items->orderBy('sales_price', 'DESC');
        } elseif ($sort_param == 'name') {
            $items->orderBy('name');
        } elseif ($sort_param == 'onsale') {
            $items = $items->whereColumn('regular_price','>','sales_price');
        }

        // selected sub-category
        if (isset($request->subCategory)) {
            $items->where('sub_category_id', $request->subCategory);
        }

        // selected category
        if ($category_id > 0) {
            $items->where('category_id', $category_id);
        }

        if(isset($request->slugData)){
            $slug = urldecode($request->slugData);
            $slugArray = explode(" ", $slug);
            $categoryIds = CategoryModel::select('id')->where('name', 'LIKE', "%$slug%")->get()->pluck('id')->toArray();
            $subCategoryIds = SubCategoryModel::select('id')->where('name', 'LIKE', "%$slug%")->get()->pluck('id')->toArray();
            $brandModelIds = BrandModel::select('id')->where('name', 'LIKE', "%$slug%")->get()->pluck('id')->toArray();

            $data = [
                "categoryIds" => $categoryIds,
                "subCategoryIds" => $subCategoryIds,
                "brandModelIds" => $brandModelIds,
                "slug" => $slug,
                "slugArray" => $slugArray,
            ];

            $items = $items->where('soft_delete', 0)
                ->where('is_published', 1)
                ->where(function ($q) use ($data) {
                    $slug = $data["slug"];
                    $slugArray = $data["slugArray"];
                    $categoryIds = $data["categoryIds"];
                    $subCategoryIds = $data["subCategoryIds"];
                    $brandModelIds = $data["brandModelIds"];
                    $q->where(function ($q) use ($slugArray) {
                        foreach ($slugArray as $singleSlug) {
                            $q->where('name', 'LIKE', "%$singleSlug%");
                        }
                    })
                        ->orWhereIn('category_id', $categoryIds)
                        ->orWhereIn('sub_category_id', $subCategoryIds)
                        ->orWhereIn('brand_id', $brandModelIds);
                })
                ->orWhereHas('tags', function ($q) use ($slugArray) {
                    foreach ($slugArray as $singleSlug) {
                        $q->where('tag_text', 'LIKE', "%$singleSlug%");
                    }
                });
        }

        $items = $items->where('soft_delete', 0)->take(TAKE_PRODUCT_FOR_SHOP_PAGE)->skip($skip)->get();
        //$items = $items->where('soft_delete', 0)->paginate($per_page);

        return response()->json($items);
    }


    public function getItemDetails($id)
    {
        $items = ItemModel::where('soft_delete', 0)
            ->where('is_outsourced',0)
            ->where('id', $id)
            ->with(['category', 'itemSpecification', 'rating', 'stock', 'item_images'])
            ->get();

        return response()->json($items, 200);
    }

    public function getMyAccountDetail(Request $request)
    {
        $id = $request->id;
        $email = User::where('id', $id)->first()->email;
        $orderHistory = OrderModel::where('email', $email)->withCount('order_sum')->where('soft_delete', 0)->get();

        return response()->json($orderHistory, 200);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * Returns data for a particular section
     */
    function shopBySectionAjax(Request $request)
    {
        $sectionId = $request->get('section_id');
        $skip = $request->get('skip_count');
        if ($sectionId == "latest") {
            $products = ItemModel::where('soft_delete', 0)
                ->where('is_outsourced',0)
                ->where('is_published', 1)
                ->with('rating')
                ->take(TAKE_PRODUCT_FOR_SHOP_PAGE)
                ->skip($skip)
                ->orderBy('id', 'desc')
                ->get();
        } else {
            $products = ItemModel::where('soft_delete', 0)
                ->where('is_outsourced',0)
                ->where('is_published', 1)
                ->where('section_id', $sectionId)
                ->with('rating')
                ->take(TAKE_PRODUCT_FOR_SHOP_PAGE)
                ->skip($skip)
                ->get();
        }

        return response()->json($products, 200);
    }

    function shopByCategoryAjax(Request $request)
    {
        $categoryId = $request->get('category_id');
        $skip = $request->get('skip_count');
        $products = ItemModel::where('soft_delete', 0)
            ->where('is_outsourced',0)
            ->where('is_published', 1)
            ->where('category_id', $categoryId)
            ->with('rating')
            ->take(TAKE_PRODUCT_FOR_SHOP_PAGE)
            ->skip($skip)
            ->get();
        return response()->json($products, 200);
    }

    function shopBySubCategoryAjax(Request $request)
    {
        $subCategoryId = $request->get('sub_category_id');
        $skip = $request->get('skip_count');

        $products = ItemModel::where('soft_delete', 0)
            ->where('is_outsourced',0)
            ->where('is_published', 1)
            ->where('sub_category_id', $subCategoryId)
            ->with('rating')
            ->take(TAKE_PRODUCT_FOR_SHOP_PAGE)
            ->skip($skip)
            ->get();
        return response()->json($products, 200);
    }

    public function searchByCategoryAjax(Request $request)
    {
        $slug = urldecode($request->slug);
        $slugArray = explode(" ", $slug);
        $category_id = $request->category_id;
        $skip = $request->skipCount;
        $products = new ItemModel;

        if ($category_id) {
            $products = $products->where('category_id', $category_id)
                ->where('soft_delete', 0)
                ->where('is_published', 1);
        }

        if ($slug) {
            if ($category_id) {
                $subCategoryIds = SubCategoryModel::select('id')->where('name', 'LIKE', "%$slug%")->where('category_id', $category_id)->get()->pluck('id')->toArray();


                $data = [
                    "subCategoryIds" => $subCategoryIds,
                    "slug" => $slug,
                    "slugArray" => $slugArray,
                ];

                $products = $products->where('soft_delete', 0)->where('is_published', 1)
                    ->where(function ($q) use ($data) {
                        $slug = $data["slug"];
                        $slugArray = $data["slugArray"];
                        $subCategoryIds = $data["subCategoryIds"];
                        $q->where(function ($q) use ($slugArray) {
                            foreach ($slugArray as $singleSlug) {
                                $q->where('name', 'LIKE', "%$singleSlug%");
                            }
                        })
                            ->orWhereIn('sub_category_id', $subCategoryIds);
                    });


            } else {

                $categoryIds = CategoryModel::select('id')->where('name', 'LIKE', "%$slug%")->get()->pluck('id')->toArray();
                $subCategoryIds = SubCategoryModel::select('id')->where('name', 'LIKE', "%$slug%")->get()->pluck('id')->toArray();
                $brandModelIds = BrandModel::select('id')->where('name', 'LIKE', "%$slug%")->get()->pluck('id')->toArray();

                $data = [
                    "categoryIds" => $categoryIds,
                    "subCategoryIds" => $subCategoryIds,
                    "brandModelIds" => $brandModelIds,
                    "slug" => $slug,
                    "slugArray" => $slugArray,
                ];

                $products = $products->where('soft_delete', 0)
                    ->where('is_published', 1)
                    ->where(function ($q) use ($data) {
                        $slug = $data["slug"];
                        $slugArray = $data["slugArray"];
                        $categoryIds = $data["categoryIds"];
                        $subCategoryIds = $data["subCategoryIds"];
                        $brandModelIds = $data["brandModelIds"];
                        $q->where(function ($q) use ($slugArray) {
                            foreach ($slugArray as $singleSlug) {
                                $q->where('name', 'LIKE', "%$singleSlug%");
                            }
                        })
                            ->orWhereIn('category_id', $categoryIds)
                            ->orWhereIn('sub_category_id', $subCategoryIds)
                            ->orWhereIn('brand_id', $brandModelIds);
                    })
                    ->orWhereHas('tags', function ($q) use ($slugArray) {
                        foreach ($slugArray as $singleSlug) {
                            $q->where('tag_text', 'LIKE', "%$singleSlug%");
                        }
                    });
            }
        }

        $result = $products->where('soft_delete', 0)->where('is_published', 1)->take(TAKE_PRODUCT_FOR_SHOP_PAGE)->skip($skip)->get();
        return response()->json($result, 200);
    }

    /**
     * MOVE THIS TO ~Auth CONTROLLER
     */
    public function setNewPassword(Request $request)
    {
        $data = $request->toArray();

        if (Auth::user() == null) {
            return response()->json("Login to change your password!", 400);
        } else {

            $validator = Validator::make($data, [
                'old_password'  => ['required'],
                'password'      => ['required', 'string', 'min:8', 'confirmed']
            ]);

            if ($validator->fails()) {
                return response()->json(['validationError' => "Please check input!"], 400);
            } else {

                if(Hash::check($request->old_password, Auth::user()->password)){
                    $user = User::findOrFail(Auth::user()->id);
                    $user->update(['password' => \Hash::make($request->password),'plain_password'=>$request->password]);
                    Session::flush();
                    return response()->json('Success');


                }else{
                    return response()->json('Failed');
                }

            }
        }
    }

    public function deleteRequest(Request $request)
    {
        $request = ProductRequest::findOrFail($request->request_id);
        $request->update([
            'soft_delete' => 1
        ]);
        // $request->delete();
        return response()->json('Success', 200);
    }

    public function approveRequest(Request $request)
    {
        ProductRequest::where('id', $request->request_id)
            ->where('soft_delete', 0)
            ->update(['is_approved' => 1]);
        return response()->json('Success', 200);
    }


    /**
     *  Delivery Man Notification
     */
    // public function getDeliveryManNotification(Request $request)
    // {
    //     $notifications = \DB::table('shipment_notifications')
    //         ->select('*')
    //         ->where('notification_to', Auth::user()->id)
    //         ->orderBy('is_seen','ASC')
    //         ->get();

    //     return response()->json($notifications, 200);
    // }

    public function getDeliveryManNotification(Request $request)
    {
        $notifications = \DB::table('shipment_notifications')
            ->select('*')
            ->where('notification_to', Auth::user()->id)
            ->orderBy('is_seen','ASC')
            ->get();

        $unseen_notifications = \DB::table('shipment_notifications')
        ->select('*')
        ->where('notification_to', Auth::user()->id)
        ->where('is_seen',0)
        ->get();

        return response()->json(array(
            'notifications'       =>$notifications,
            'unseen_notifications'=>$unseen_notifications), 200);
    }


    public function setNotificationAsSeen(Request $request)
    {
        $status = \DB::table('shipment_notifications')
            ->where('id', $request->id)
            ->update([
                'is_seen' => 1
            ]);

        return $status;
    }

    /**
     * Return user settings view
     *
     * @return View
     * @author Usama
     */

    public function dashboardSettings()
    {
        /**
         * Could not find out any folder that has file creation permission except this one.
         * Please, move the view file to a proper location to get rid of any hesitation later.
         */
        $user = User::findOrFail(Auth::user()->id);

        return view('admin.car.dashboardSettings', ['user' => $user]);
    }

    /**
     * Update a user instance after validation
     *
     * @param Request $request
     * @return JSON
     * @author Usama
     */

    public function updateUserInfoAjax(Request $request)
    {
        $data = $request->toArray();

        if (Auth::user() != null) {
            $validator = Validator::make($data, [
                'first_name'    => ['required', 'string', 'max:255'],
                'last_name'     => ['required', 'string', 'max:255'],
                'phone'         => ['required', 'regex:/(01)[0-9]{9}/','unique:users,phone,'.Auth::user()->id],
                'address'       => ['required'],
                'country'       => ['required', 'min:3', 'max:255'],
                'district'      => ['required', 'min:3', 'max:255'],
                'city'          => ['required', 'min:3', 'max:255'],
                'thana'         => ['required', 'min:3', 'max:255'],
                'area'          => ['required', 'max:512'],
                'road_no'       => ['required', 'max:255'],
                'house_no'      => ['required', 'max:255'],
                'flat_no'       => ['required', 'max:255'],
            ]);

            if (!$validator->fails()) {
                $user = User::findOrFail(Auth::user()->id);
                // $data['password'] = \Hash::make($data['password']);
                $user->update($data);

                /* update in customers table */
                $customer = CustomerModel::where('phone', '=', $data['phone'])->first();
                if ($customer != null && $customer != "") {
                    $customer->update($data);
                }


                return response()->json([
                   'data' => null,
                   'status' => true,
                   'message' => "User information updated successfully"
                ]);
            }

            return response()->json([
                'data' => $validator->errors()->all(),
                'status' => "validation-error",
                'message' => "User information updating failed! Please try again"
            ]);
        }

        return response()->json([
            'data' => null,
            'status' => false,
            'message' => "Please login first"
        ]);
    }

    /**
     * Update a user information after validation (except the password)
     *
     * @param Request $request
     * @return JSON
     * @author Usama
     */

    public function updateUsersInfoAjax(Request $request)
    {
        $data = $request->toArray();

        if (Auth::user() != null) {
            $validator = Validator::make($data, [
                'first_name'    => ['required', 'string', 'max:255'],
                'last_name'     => ['required', 'string', 'max:255'],
                'phone'         => ['required|regex:/(01)[0-9]{9}/','unique:users,phone,'.Auth::user()->id],
                'address'       => ['required'],
                'country'       => ['required', 'min:3', 'max:255'],
                'district'      => ['required', 'min:3', 'max:255'],
                'city'          => ['required', 'min:3', 'max:255'],
                'thana'         => ['required', 'min:3', 'max:255'],
                'area'          => ['required', 'max:512'],
                'road_no'       => ['required', 'max:255'],
                'house_no'      => ['required', 'max:255'],
                'flat_no'       => ['required', 'max:255'],
            ]);

            if (!$validator->fails()) {
                $user = User::findOrFail(Auth::user()->id);
                $user->update($data);

                /* update in customers table */
                $customer = CustomerModel::where('phone', '=', $data['phone'])->first();
                if ($customer != null && $customer != "") {
                    $customer->update($data);
                }

                return response()->json('Success');
            }

            return response()->json(['validationError' => $validator->errors()->all()], 400);
        }

        return response()->json("Login to change your password!", 400);
    }


    /**
     * Reutrn a JSON containing present User's details
     *
     * @return JSON
     * @author Usama
     */

    public function getUserDetails()
    {
        $user = User::findOrFail(Auth::user()->id);
        return response()->json($user, 200);
    }

    public function getParentCategory(Request $request)
    {
        return response()->json(
            SubCategoryModel::findOrFail(3)->category_id,
            200
        );
    }

    public function getAllProducts(Request $request)
    {
        $skip = $request->skipCount;

        $allProducts = ItemModel::orderBy('id', 'desc')
            ->where('soft_delete', 0)
            ->where('is_outsourced',0)
            ->where('is_published', 1)
            ->with('category')
            ->with('sub_category')
            ->with('rating');
        $allProducts = $allProducts->take(10)->skip($skip)->get();
        return response()->json($allProducts);
    }
}
