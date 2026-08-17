<?php

namespace App\Http\Controllers\Shop;

use App\purchase\PurchaseItemBarcode;
use App\stock\StockModel;
use Illuminate\Support\Facades\Session;
use App\Cart;
use App\Wish;
use App\Brand;
use App\Category;
use App\item\ItemModel;
use App\Brand\BrandModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\category\CategoryModel;
use App\subCategory\SubCategoryModel;


class ProductController extends Controller
{

	public function addToCart(Request $request)
	{
		$product = ItemModel::find($request->id);
		$oldCart = Session::has('cart') ? Session::get('cart') : null;
		$cart    = new Cart($oldCart);
		$cart->add($product, $product->id);
		$request->session()->put('cart', $cart);
		return response()->json(["cart" => $cart]);
	}


	public function addToWish(Request $request)
	{
		$product = ItemModel::find($request->id);
		$oldWish = Session::has('wish') ? Session::get('wish') : null;
		$wish    = new Wish($oldWish);
		$wish->add($product, $product->id);
		$request->session()->put('wish', $wish);
		return response()->json(["wish" => $wish]);
	}


	public function wishList(){
		return view('wishlist.wishlist');
	}



	public function decreaseToCart(Request $request)
	{

		$product = ItemModel::find($request->id);
		$oldCart = Session::has('cart') ? Session::get('cart') : null;
		$cart    = new Cart($oldCart);
		$cart->decrease($product, $product->id);
		$request->session()->put('cart', $cart);
		return response()->json(["cart" => $cart]);
	}
	public function addToCartFromDetails(Request $request)
	{

		$product = ItemModel::find($request->id);
		$oldCart = Session::has('cart') ? Session::get('cart') : null;
		$cart    = new Cart($oldCart);
		$cart->addToCartFromDetails($product, $product->id, $request->quantity);
		$request->session()->put('cart', $cart);
		return response()->json(["cart" => $cart]);
	}

	public function searchProductByCategory(Request $request)
	{

		if ($request->id == 0) {
			$allProducts    = ItemModel::where('soft_delete', 0)->where('is_outsourced',0)->where('is_published', 1)->get();
		} else {
			$allProducts    = ItemModel::where('category_id', $request->id)->where('soft_delete', 0)->where('is_outsourced',0)->where('is_published', 1)->get();
		}


		$dataArray = [
			'allProducts'    => $allProducts,
		];



		return view('shop.allProductsAjax', $dataArray);
	}


	public function searchProductBySubCategory(Request $request)
	{
		if ($request->id == 0) {
			$allProducts = ItemModel::where('soft_delete', 0)->where('is_outsourced',0)->where('is_published', 1)->get();
		} else {
			$allProducts = ItemModel::where('sub_category_id', $request->id)
				->where('soft_delete', 0)
                ->where('is_outsourced',0)
				->where('is_published', 1)
				->get();
		}

		$dataArray = [
			'allProducts' => $allProducts,
		];

		return view('shop.allProductsAjax', $dataArray);
	}





	public function searchProductByBrand(Request $request)
	{
		if ($request->id == 0) {
			$allProducts    = ItemModel::where('soft_delete', 0)->where('is_outsourced',0)->where('is_published', 1)->paginate(9, ['*'], 'post_page');
		} else {
			$allProducts    = ItemModel::where('category_id', $request->category_id)->where('brand_id', $request->brand_id)->where('soft_delete', 0)->where('is_outsourced',0)->where('is_published', 1)->paginate(9, ['*'], 'post_page');
		}

		$dataArray = [

			'allProducts'    => $allProducts,

		];

		return view('shop.allProductsAjax', $dataArray);
	}


	public function checkoutDoneIncreaseItem(Request $request)
	{
		$itemId = $request->id;
		$oldCart = Session::has('cart') ? Session::get('cart') : null;
		dd($oldCart->items[$itemId]);
	}


	public function getProductByBrandAjax(Request $request)
	{
		// $LatestProducts = Product::orderBy('id','desc')->take(8)->get();
		if ($request->id == 0) {
			$allProducts    = ItemModel::where('soft_delete', 0)->where('is_outsourced',0)->where('is_published', 1)->paginate(9, ['*'], 'post_page');
		} else {
			$allProducts    = ItemModel::where('brand_id', $request->id)->where('soft_delete', 0)->where('is_outsourced',0)->where('is_published', 1)->paginate(9, ['*'], 'post_page');
		}
		// $allCategories  = Category::all();
		// $allBrands      = Brand::where('category_id',$slug)->get();
		$dataArray = [

			'allProducts'    => $allProducts,

		];

		return view('shop.allProductsAjax', $dataArray)->render();
	}


	// public function searchProducts(Request $request)
	// {
	// 	$search = $request->term;
	// 	$category = $request->category;
	// 	$row_set = [];

	// 	$products = new ItemModel;


	// 	if($category){

    //        $products = $products->where('category_id',$category);
	// 	}


	// 	$products = $products->where('is_published', 1)
	// 						->where('name', 'LIKE', '%' . $search . '%')
	// 						->where('soft_delete', 0)
	// 						->orWhereHas('tags', function($q) use($search)
	// 						{
	// 							$q->where('tag_text', 'LIKE', '%' . $search . '%');

	// 						}) ->limit(5)->get();


	// 	if (!$products->isEmpty()) {
	// 		foreach ($products as $product) {

	// 			$new_row['name']   = $product->name;
	// 			$new_row['image'] = $product->thumbnail;
	// 			$new_row['url'] = url('singleProductDetails/' . $product->id);

	// 			$row_set[] = $new_row; //build an array
	// 		}
	// 	}

	// 	return response()->json($row_set);
	// }




	public function searchProducts(Request $request)
	{
		$search = $request->term;
		$category_id = $request->category;
		$row_set = [];
        $slugArray = explode(" ",$search);

		$products = new ItemModel;


		if($category_id){

           $products = $products->where('category_id',$category_id);
		}

		if ($search) {
            if($category_id){
                $subCategoryIds = SubCategoryModel::select('id')->where('name', 'LIKE', "%$search%")->where('category_id',$category_id)->get()->pluck('id')->toArray();


                $data = [
                    "subCategoryIds" => $subCategoryIds,
                    "search"           => $search,
                    "slugArray"           => $slugArray,
                ];

                $products =  $products->where('soft_delete',0)->where('is_published',1)
                                      ->where(function ($q) use ($data) {
                                        $search           = $data["search"];
                                        $slugArray           = $data["slugArray"];
                                        $subCategoryIds = $data["subCategoryIds"];
                                            $q->where(function ($q) use ($slugArray) {
                                                foreach ($slugArray as $singleSlug){
                                                    $q->where('name', 'LIKE', "%$singleSlug%");
                                                }
                                            })
                                           ->orWhereIn('sub_category_id', $subCategoryIds);
                                      });


            } else{

                $categoryIds = CategoryModel::select('id')->where('name', 'LIKE', "%$search%")->get()->pluck('id')->toArray();
                $subCategoryIds = SubCategoryModel::select('id')->where('name', 'LIKE', "%$search%")->get()->pluck('id')->toArray();
                $brandModelIds = BrandModel::select('id')->where('name', 'LIKE', "%$search%")->get()->pluck('id')->toArray();

                $data = [
                    "categoryIds" => $categoryIds,
                    "subCategoryIds" => $subCategoryIds,
                    "brandModelIds" => $brandModelIds,
                    "search"           => $search,
                    "slugArray"           => $slugArray,
                ];

                $products =    $products->where('soft_delete',0)
                ->where('is_published',1)
                ->where(function ($q) use ($data) {
                    $search           = $data["search"];
                    $slugArray           = $data["slugArray"];
                    $categoryIds = $data["categoryIds"];
                    $subCategoryIds = $data["subCategoryIds"];
                    $brandModelIds = $data["brandModelIds"];
                        $q->where(function ($q) use ($slugArray) {
                            foreach ($slugArray as $singleSlug){
                                $q->where('name', 'LIKE', "%$singleSlug%");
                            }
                        })
                       ->orWhereIn('category_id', $categoryIds)
                       ->orWhereIn('sub_category_id', $subCategoryIds)
                       ->orWhereIn('brand_id', $brandModelIds);
                  })
                ->orWhereHas('tags', function ($q) use ($slugArray) {
                    foreach ($slugArray as $singleSlug){
                        $q->where('tag_text', 'LIKE', "%$singleSlug%");
                    }
                });

            }
        }


		$products = $products->where('soft_delete',0)->where('is_published',1)->limit(5)->get();


		if (!$products->isEmpty()) {
			foreach ($products as $product) {

				$new_row['name']   = $product->name;
//				$new_row['image'] = $product->thumbnail;
				$new_row['image'] = $product->resized_image;
				$new_row['url'] = url('singleProductDetails/' . $product->id);

				$row_set[] = $new_row; //build an array
			}
		}

		return response()->json($row_set);
	}



    //Old function to get item details
	public function getProductByIdAjax(Request $request)
	{
		$product = ItemModel::find($request->id);
		return response()->json($product, 200);
	}

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * To get item details in pos sales panel
     */
    public function getProductByPurchaseItemBarcodeId(Request $request)
    {
        $purchaseItemBarcodeId = $request->get('purchaseItemBarcodeId');
        $purchaseItemBarcodeData = PurchaseItemBarcode::where('id',$purchaseItemBarcodeId)->first();
        $itemData = ItemModel::where('id',$purchaseItemBarcodeData['item_id'])->first();
        $stockData = StockModel::where('item_barcodes_id',$purchaseItemBarcodeId)->select('quantity')->first();

        return response()->json([
            'data' => [
                'purchaseItemBarcodeData' => $purchaseItemBarcodeData,
                'itemData' => $itemData,
                'stockData' => $stockData
            ],
            'status' => true,
            'message' => null
        ]);
    }

	public function sortProductByParam(Request $request)
	{
		$sort_param = $request->sort_param;

		if ($sort_param == 'average') {
			$items = ItemModel::where('soft_delete', 0)
                                 ->where('is_outsourced',0)
				                 ->where('is_published', 1)
				                 ->paginate(12, ['*'], 'post_page');

		}
		elseif ($sort_param ==  'popularity') {
			$items = ItemModel::where('sales_type', 'bestrated')
		                  		->where('soft_delete', 0)
                                ->where('is_outsourced',0)
				                  ->where('is_published', 1)
				                  ->paginate(12, ['*'], 'post_page');
		}
		elseif ($sort_param == 'time') {
			$items = ItemModel::where('soft_delete', 0)
                                ->where('is_outsourced',0)
		                		->where('is_published', 1)
			                 	->orderBy('created_at', 'DESC')
			                 	->paginate(12, ['*'], 'post_page');

		}
		elseif ($sort_param == 'price_asc') {
			$items = ItemModel::where('soft_delete', 0)
                                ->where('is_outsourced',0)
		                 		->where('is_published', 1)
				                ->orderBy('sales_price', 'ASC')
				                ->paginate(12, ['*'], 'post_page');

		}
		elseif ($sort_param == 'price_desc') {
			$items = ItemModel::where('soft_delete', 0)
                                 ->where('is_outsourced',0)
		                  		->where('is_published', 1)
				                  ->orderBy('sales_price', 'DESC')
				                  ->paginate(12, ['*'], 'post_page');

		}
		elseif ($sort_param == 'name') {
			$items = ItemModel::where('soft_delete', 0)
                                 ->where('is_outsourced',0)
		                  		->where('is_published', 1)
				                ->orderBy('name')
			                   	->paginate(12, ['*'], 'post_page');

		}

		// dd($sort_param);

		$data = [
			'allProducts' => $items
		];

		return view('shop.allProductsAjax', $data);
	}
}
