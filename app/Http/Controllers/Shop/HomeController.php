<?php

namespace App\Http\Controllers\Shop;

use App\Http\Helpers\UtilityHelper;
use App\SiteVisit;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\item\ItemModel;
use App\category\CategoryModel;
use App\Brand\BrandModel;
use App\Cart;
use Session;
use Illuminate\Support\Facades\Validator;
use DB;
use App\OrderModel;
use App\OrderDetailsModel;
use Illuminate\Support\Facades\Auth;
use App\sales\SalesDetailsModel;
use App\section\SectionModel;
use App\Mail\OrderConfirmationMail;
use Illuminate\Support\Facades\Mail;
use App\deliveryCharge\DeliveryChargeModel;
use App\contact\ContactModel;
use App\WebsiteDetailsModel;
use App\User;
use App\car\CarModel;
use App\stock\StockModel;
use App\customer\CustomerModel;
use App\welcomeCall\WelcomeCallModel;
use Log;
use App\MAC;
use Illuminate\Support\Facades\Hash;

use App\Wish;

class HomeController extends Controller
{

    //const DELIVERY_CHARGE = 60;

    public function resizePreviousUploadedImage()
    {
        try {
            //Get items where items are not resized
            $items = ItemModel::where('resized_image', null)->take(200)->get();
            $resizedItems = 0;
            foreach ($items as $item) {
                if($item['thumbnail'] != null){
                    //Returns main image and extension details
                    $imageDetails = UtilityHelper::getImageDetails($item['thumbnail']);
                    $original_file = $item['thumbnail'];

                    //Returns file where new small file will be stored
                    $resize_file = UtilityHelper::getResizeFilePath($imageDetails['image'], $imageDetails['extension']);

                    if (!file_exists($resize_file)) {
                        //This actually resizes the file
                        $this->imageResize($original_file, $resize_file, $imageDetails['extension']);
                        $resizedItems++;
                    }

                    //Updates image is_resized field by 1 after image resize is done.
                    ItemModel::where('id', $item['id'])->update([
                        'resized_image' => $resize_file
                    ]);
                }
            }

            return json_encode([
                'status' => true,
                'message' => 'Image resized successfully',
                'resizedItems' => $resizedItems
            ]);
        } catch (\Exception $exception) {
            return json_encode([
                'status' => false,
                'message' => $exception->getMessage()
            ]);
        }
    }

    public function imageResize($original_file, $resize_file, $extension)
    {
//        $wmax = 225;
//        $hmax = 225;
        $wmax = 320;
        $hmax = 320;
        $resize_response = UtilityHelper::image_resize(public_path($original_file), public_path($resize_file), $wmax, $hmax, $extension);
        return $resize_response;
    }


    public function index(Request $request)
    {
        // $LatestProducts    = ItemModel::orderBy('id', 'desc')->take(8)->get();
        // $dealOfTheWeek     = ItemModel::Where('sales_type', 'dealOfTheWeek')->where('soft_delete', 0)->latest()->first();

        // $allProducts    = ItemModel::where('soft_delete', 0)->get();

        // $specialOffers  = ItemModel::where('sales_type', 'special')->where('soft_delete', 0)->where('is_published', 1)->get();
        // $onsaleProducts    = ItemModel::where('sales_type', 'onsale')->where('soft_delete', 0)->where('is_published', 1)->get();
        // $bestRatedProduct  = ItemModel::where('sales_type', 'bestrated')->where('soft_delete', 0)->where('is_published', 1)->get();

        // $allCategories  = CategoryModel::where('soft_delete', 0)->get();

        // $categoryOne    = CategoryModel::where('id', 1)->with("items")->first();

        // $categoryTwo    = CategoryModel::where('id', 2)->with("items")->first();
        // $brands         = BrandModel::where('soft_delete', 0)->get();
        // $sections       =  SectionModel::where('soft_delete', 0)->get();


        // // $topOrders           = OrderDetailsModel::select('product_id',DB::raw('count(*) as total'))->groupBy('product_id')->orderBy(\DB::raw('count(product_id)'), 'DESC')->take(20)->get();
        // $topOrders           = OrderDetailsModel::select('product_id', DB::raw('count(*) as total'))->groupBy('product_id')->orderBy(\DB::raw('count(product_id)'), 'DESC')->paginate(10);
        // $categoryOneItem     = ItemModel::where('category_id', 1)->pluck('id')->where('is_published', 1)->toArray();
        // $categoryTwoItem     = ItemModel::where('category_id', 2)->pluck('id')->where('is_published', 1)->toArray();
        // $bestCategoryOneItem = OrderDetailsModel::select('product_id', DB::raw('count(*) as total'))->whereIn('product_id', $categoryOneItem)->groupBy('product_id')->orderBy(\DB::raw('count(product_id)'), 'DESC')->take(20)->get();
        // $bestCategoryTwoItem = OrderDetailsModel::select('product_id', DB::raw('count(*) as total'))->whereIn('product_id', $categoryTwoItem)->groupBy('product_id')->orderBy(\DB::raw('count(product_id)'), 'DESC')->take(20)->get();

        // //  return $bestCategoryTwo;

        // $websiteDetails = WebsiteDetailsModel::where('soft_delete', 0)->first();

        // $companies = CarModel::where('soft_delete', 0)->get();

        // if (ItemModel::where('sales_type', 'featured')->where('soft_delete', 0)->where('is_published', 1)->count() > 0 || ItemModel::where('sales_type', 'special')->where('soft_delete', 0)->where('is_published', 1)->count() > 0) {
        // 	$fProduct             = ItemModel::where('sales_type', 'featured')->where('soft_delete', 0)->where('is_published', 1)->paginate(10, ['*'], 'new-page-name');

        // 	$dataArray = [
        // 		'LatestProducts'    => $LatestProducts,
        // 		'allProducts'    => $allProducts,
        // 		'specialOffers'      => $specialOffers,
        // 		'onsaleProducts'     => $onsaleProducts,
        // 		'bestRatedProduct'   => $bestRatedProduct,
        // 		'allCategories'      => $allCategories,
        // 		'brands'             => $brands,
        // 		'categoryOne'        => $categoryOne,
        // 		'categoryTwo'        => $categoryTwo,
        // 		'topOrders'          => $topOrders,
        // 		'dealOfTheWeek'      => $dealOfTheWeek,
        // 		'bestCategoryOneItem' => $bestCategoryOneItem,
        // 		'bestCategoryTwoItem' => $bestCategoryTwoItem,
        // 		'fProduct'           => $fProduct,
        // 		'sections'           => $sections,
        // 		'websiteDetails'     => $websiteDetails,
        // 		'companies'          => $companies
        // 	];
        // } else {


        // 	$dataArray = [
        // 		'LatestProducts'     => $LatestProducts,
        // 		'allProducts'    => $allProducts,
        // 		'specialOffers'      => $specialOffers,
        // 		// 'featuredProducts'   => $featuredProducts,
        // 		'onsaleProducts'     => $onsaleProducts,
        // 		'bestRatedProduct'   => $bestRatedProduct,
        // 		'allCategories'      => $allCategories,
        // 		'brands'             => $brands,
        // 		'categoryOne'        => $categoryOne,
        // 		'categoryTwo'        => $categoryTwo,
        // 		'topOrders'          => $topOrders,
        // 		'dealOfTheWeek'      => $dealOfTheWeek,
        // 		'bestCategoryOneItem' => $bestCategoryOneItem,
        // 		'bestCategoryTwoItem' => $bestCategoryTwoItem,
        // 		'sections'           => $sections,
        // 		'websiteDetails'     => $websiteDetails,
        // 		'companies'          => $companies
        // 	];
        // }
        //$MAC = exec('getmac');

        //	$MAC = strtok($MAC, ' ');


        $ip = $request->ip();
        $this->countSiteVisit($ip);

        if (Auth::user()) {
            $attributes = [
                'user_id' => Auth::user()->id,
                'mac' => $ip
            ];

        } else {
            $attributes = [
                'mac' => $ip
            ];

        }


        MAC::insert($attributes);

        return view('shop.index');
    }


    public function searchCar(Request $request)
    {
        $LatestProducts = ItemModel::orderBy('id', 'desc')
            ->where('is_outsourced',0)
            ->where('car_company_id', $request->company_id)
            ->where('car_brand_id', $request->brand_id)
            ->where('car_model_id', $request->model_id)
            ->take(8)
            ->get();


        $dealOfTheWeek = ItemModel::Where('sales_type', 'dealOfTheWeek')
            ->where('soft_delete', 0)
            ->where('is_outsourced',0)
            ->where('car_company_id', $request->company_id)
            ->where('car_brand_id', $request->brand_id)
            ->where('car_model_id', $request->model_id)
            ->latest()
            ->first();

        $allProducts = ItemModel::where('soft_delete', 0)
            ->where('is_outsourced',0)
            ->where('car_company_id', $request->company_id)
            ->where('car_brand_id', $request->brand_id)
            ->where('car_model_id', $request->model_id)
            ->get();

        $specialOffers = ItemModel::where('sales_type', 'special')
            ->where('soft_delete', 0)
            ->where('is_outsourced',0)
            ->where('car_company_id', $request->company_id)
            ->where('car_brand_id', $request->brand_id)
            ->where('car_model_id', $request->model_id)
            ->where('is_published', 1)
            ->get();

        $onsaleProducts = ItemModel::where('sales_type', 'onsale')
            ->where('soft_delete', 0)
            ->where('is_outsourced',0)
            ->where('car_company_id', $request->company_id)
            ->where('car_brand_id', $request->brand_id)
            ->where('car_model_id', $request->model_id)
            ->where('is_published', 1)
            ->get();

        $bestRatedProduct = ItemModel::where('sales_type', 'bestrated')
            ->where('soft_delete', 0)
            ->where('is_outsourced',0)
            ->where('car_company_id', $request->company_id)
            ->where('car_brand_id', $request->brand_id)
            ->where('car_model_id', $request->model_id)
            ->where('is_published', 1)
            ->get();

        $allCategories = CategoryModel::where('soft_delete', 0)->get();
        $categoryOne = CategoryModel::where('id', 1)->with("items")->first();
        $categoryTwo = CategoryModel::where('id', 2)->with("items")->first();
        $brands = BrandModel::where('soft_delete', 0)->get();
        $sections = SectionModel::where('soft_delete', 0)->get();


        $topOrders = OrderDetailsModel::select('product_id', DB::raw('count(*) as total'))->groupBy('product_id')->orderBy(\DB::raw('count(product_id)'), 'DESC')->paginate(10);
        $categoryOneItem = ItemModel::where('is_outsourced',0)
            ->where('category_id', 1)
            ->where('car_company_id', $request->company_id)
            ->where('car_brand_id', $request->brand_id)
            ->where('car_model_id', $request->model_id)
            ->pluck('id')
            ->where('is_published', 1)
            ->toArray();

        $categoryTwoItem = ItemModel::where('is_outsourced',0)
            ->where('category_id', 2)
            ->where('car_company_id', $request->company_id)
            ->where('car_brand_id', $request->brand_id)
            ->where('car_model_id', $request->model_id)
            ->pluck('id')
            ->where('is_published', 1)
            ->toArray();

        $bestCategoryOneItem = OrderDetailsModel::select('product_id', DB::raw('count(*) as total'))->whereIn('product_id', $categoryOneItem)->groupBy('product_id')->orderBy(\DB::raw('count(product_id)'), 'DESC')->take(20)->get();
        $bestCategoryTwoItem = OrderDetailsModel::select('product_id', DB::raw('count(*) as total'))->whereIn('product_id', $categoryTwoItem)->groupBy('product_id')->orderBy(\DB::raw('count(product_id)'), 'DESC')->take(20)->get();

        //  return $bestCategoryTwo;

        $websiteDetails = WebsiteDetailsModel::where('soft_delete', 0)->first();

        $companies = CarModel::where('soft_delete', 0)->get();

        if (ItemModel::where('sales_type', 'featured')->where('soft_delete', 0)->where('is_outsourced',0)
                ->where('is_published', 1)->count() > 0 || ItemModel::where('sales_type', 'special')->where('soft_delete', 0)->where('is_outsourced',0)->where('is_published', 1)->count() > 0) {
            $fProduct = ItemModel::where('sales_type', 'featured')->where('soft_delete', 0)->where('is_outsourced',0)->where('is_published', 1)->paginate(10, ['*'], 'new-page-name');

            $dataArray = [
                'LatestProducts' => $LatestProducts,
                'allProducts' => $allProducts,
                'specialOffers' => $specialOffers,
                'onsaleProducts' => $onsaleProducts,
                'bestRatedProduct' => $bestRatedProduct,
                'allCategories' => $allCategories,
                'brands' => $brands,
                'categoryOne' => $categoryOne,
                'categoryTwo' => $categoryTwo,
                'topOrders' => $topOrders,
                'dealOfTheWeek' => $dealOfTheWeek,
                'bestCategoryOneItem' => $bestCategoryOneItem,
                'bestCategoryTwoItem' => $bestCategoryTwoItem,
                'fProduct' => $fProduct,
                'sections' => $sections,
                'websiteDetails' => $websiteDetails,
                'companies' => $companies
            ];
        } else {


            $dataArray = [
                'LatestProducts' => $LatestProducts,
                'allProducts' => $allProducts,
                'specialOffers' => $specialOffers,
                // 'featuredProducts'   => $featuredProducts,
                'onsaleProducts' => $onsaleProducts,
                'bestRatedProduct' => $bestRatedProduct,
                'allCategories' => $allCategories,
                'brands' => $brands,
                'categoryOne' => $categoryOne,
                'categoryTwo' => $categoryTwo,
                'topOrders' => $topOrders,
                'dealOfTheWeek' => $dealOfTheWeek,
                'bestCategoryOneItem' => $bestCategoryOneItem,
                'bestCategoryTwoItem' => $bestCategoryTwoItem,
                'sections' => $sections,
                'websiteDetails' => $websiteDetails,
                'companies' => $companies
            ];
        }


        return view('components.search_result', $dataArray)->render();
    }


    public function shopview()
    { 
        $allCategories = CategoryModel::where('soft_delete', 0)->get();
        $allProducts = ItemModel::where('soft_delete', 0)->where('is_outsourced',0)->where('is_published', 1)->paginate(12, ['*'], 'post_page');
        $brands = BrandModel::where('soft_delete', 0)->get();
        $sections = SectionModel::where('soft_delete', 0)->get();
        $dataArray = [
            'allCategories' => $allCategories,
            'allProducts' => $allProducts,
            'brands' => $brands,
            'sections' => $sections
        ];
        return view('shop.shop', $dataArray);
    }
    /**
     * @param $id
     * Returns section page products blade
     */
    public function shopBySection($id)
    {
        return view('shop.shopBySection');
    }

    public function shopByCat($id)
    {

        $allCategories = CategoryModel::where('soft_delete', 0)->get();
        $allProducts = ItemModel::where('soft_delete', 0)->where('is_outsourced',0)->where('is_published', 1)->where('category_id', $id)->paginate(9, ['*'], 'post_page');
        $brands = BrandModel::where('soft_delete', 0)->get();
        $sections = SectionModel::where('soft_delete', 0)->get();


        $dataArray = [
            'allCategories' => $allCategories,
            'allProducts' => $allProducts,
            'brands' => $brands,
            'sections' => $sections
        ];
        return view('shop.shopByCategory', $dataArray);
    }


    public function getAllProducts()
    {

        $allProducts = ItemModel::where('soft_delete', 0)->where('is_outsourced',0)->where('is_published', 1)->get();
        $dataArray = [
            'allProducts' => $allProducts
        ];

        return view('shop.allProductsAjax', $dataArray)->render();
    }

    public function singleProductDetails($id)
    {

        $allCategories = CategoryModel::where('soft_delete', 0)->get();
        $productDetails = ItemModel::findOrFail($id);
        $sections = SectionModel::where('soft_delete', 0)->get();


        $brands = BrandModel::where('soft_delete', 0)->get();

        $dataArray = [
            'productDetails' => $productDetails,
            'allCategories' => $allCategories,
            'brands' => $brands,
            'sections' => $sections

        ];
        return view('shop.singleProductDetails', $dataArray);
    }

    public function checkOut()
    {
        $cart = Session::has('cart') ? Session::get('cart') : null;
        $allCategories = CategoryModel::where('soft_delete', 0)->get();
        $brands = BrandModel::where('soft_delete', 0)->get();
        $sections = SectionModel::where('soft_delete', 0)->get();
        $shippingCharge = DeliveryChargeModel::where('soft_delete', '0')->where('name', 'shippingcharge')->first();


        $dataArray = [
            'cart' => $cart,
            'allCategories' => $allCategories,
            'brands' => $brands,
            'sections' => $sections,
            'shippingCharge' => $shippingCharge
        ];
        return view('shop.checkOut', $dataArray);
    }


    public function getSidecartData()
    {
        $cart = Session::has('cart') ? Session::get('cart') : null;
        $allCategories = CategoryModel::where('soft_delete', 0)->get();
        $brands = BrandModel::where('soft_delete', 0)->get();
        $sections = SectionModel::where('soft_delete', 0)->get();
        $shippingCharge = DeliveryChargeModel::where('soft_delete', '0')->where('name', 'shippingcharge')->first();


        $dataArray = [
            'cart' => $cart,
            'allCategories' => $allCategories,
            'brands' => $brands,
            'sections' => $sections,
            'shippingCharge' => $shippingCharge
        ];


        return view('shop.sideNavCartData', $dataArray);
    }


    public function removeItemFromCart(Request $request)
    {
        //$oldCart = Session::has('cart') ? Session::get('cart') : null;
        $oldCart = session()->pull('cart', []);
        $carts = $oldCart->items;

        if (array_key_exists($request->item_id, $carts)) {
            unset($carts[$request->item_id]);
        }
        $oldCart = session()->pull('cart', []);
        $cart = new Cart($oldCart);
        foreach ($carts as $key => $cartItems) {

            $product = ItemModel::find($key);
            $cart->directUpdate($product, $product->id, $cartItems['qty']);
            $request->session()->put('cart', $cart);
        }


        return response()->json("success");
    }

    public function removeItemFromWish(Request $request)
    {
        //$oldCart = Session::has('cart') ? Session::get('cart') : null;


        $oldWish = session()->pull('wish', []);
        $wishs = $oldWish->items;


        if (array_key_exists($request->item_id, $wishs)) {

            unset($wishs[$request->item_id]);

        }
        $oldWish = session()->pull('wish', []);

        $wish = new Wish($oldWish);


        if ($wishs) {
            foreach ($wishs as $key => $wishItems) {

                $product = ItemModel::find($key);
                $wish->directUpdate($product, $product->id, $wishItems['qty']);
                $request->session()->put('wish', $wish);
            }


        } else {


            Session::forget('wish');
            //$request->session()->put('wish', $wish);


        }


        return response()->json("success");
    }

    public function clearCart(Request $request)
    {
        Session::forget('cart');
        return response()->json("success");
    }


    /* fetching all information
    for matching user to autofill on the checkout page
    */
    public function getUserDeatailsToAutofill(Request $request)
    {
        $matchedUser = CustomerModel::where('phone', $request->mble_num)->first();

        return response()->json(array('matchedUserInfo' => $matchedUser));

    }


    public function checkoutDone(Request $request)
    {

        $deliveryType = $request->dtype;
        $shippingCharge = DeliveryChargeModel::where('soft_delete', '0')->where('name', 'shippingcharge')->first();

        $attributeNames = array(
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'company_name' => $request->company,
            'phone_number' => $request->number,
            'email' => $request->email,
            'country' => $request->country,
            'district' => $request->district,
            'city' => $request->city,
            'thana' => $request->thana,
            'area' => $request->area,
            'road_no' => $request->road,
            'house_no' => $request->house,
            'flat_no' => $request->flat,
            'delivery_type' => $deliveryType,
            'notes' => $request->notes,
            'price' => $request->price,
            'product_id' => $request->product_id,
            'quantity' => $request->quantity,
            'title' => $request->title
        );

        $validator = Validator::make($attributeNames, [
            'first_name' => 'required',
            'last_name' => 'required',
            'phone_number' => 'required|regex:/(01)[0-9]{9}/'
        ]);

        if ($validator->fails()) {
            return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        } else {

            $hasProblemQuantity = 0;
            for ($i = 0; $i < count($request->product_id); $i++) {
                $productDetails = ItemModel::where('id', $request->product_id[$i])->first();

                if ($productDetails->minimum_order_quantity > $request->quantity[$i]) {

                    $hasProblemQuantity = 1;
                    $problemProductName = $productDetails->name;
                    $minimumQuantity = $productDetails->minimum_order_quantity;

                    break;
                }
            }

            if ($hasProblemQuantity == 1) {
                $errorData = [
                    "problemProductName" => $problemProductName,
                    "minimumQuantity" => $minimumQuantity
                ];
                return response()->json($errorData);
            } else {
                DB::beginTransaction();
                $uniqueId = uniqid('ORD');
                try {
                    $order = new OrderModel();
                    $order->first_name = $request->first_name;
                    $order->last_name = $request->last_name;
                    $order->phone_number = $request->number;
                    $order->email = $request->email;

                    $order->country = $request->country;
                    $order->district = $request->district;
                    $order->city = $request->city;
                    $order->thana = $request->thana;
                    $order->area = $request->area;
                    $order->house_no = $request->house;
                    $order->road_no = $request->road;
                    $order->flat_no = $request->flat;
                    $order->delivery_type = $request->dtype;
                    $order->order_code = $uniqueId; // ORD = Order
                    $order->order_notes = $request->notes;
                    if ($deliveryType == "pickup" || $request->subTotal >= 3000) {
                        $order->is_shipment_charge_applied = 0;
                    } else {
                        //$order->is_shipment_charge_applied = $this::DELIVERY_CHARGE;
                        $order->is_shipment_charge_applied = $shippingCharge->amount;
                    }

                    $order->save();


                    for ($i = 0; $i < count($request->product_id); $i++) {
                        $costPrice = ItemModel::where('id', $request->product_id[$i])->select('cost_price', 'sales_price')->first();

                        $orderDetails = new OrderDetailsModel();
                        $orderDetails->order_id = $order->id;
                        $orderDetails->product_id = $request->product_id[$i];
                        $orderDetails->product_name = $request->title[$i];
                        $orderDetails->quantity = $request->quantity[$i];
                        $orderDetails->price = $request->price[$i];
                        $orderDetails->cost_price = $costPrice->cost_price;
                        $orderDetails->unit_price = $costPrice->sales_price;
                        $orderDetails->save();

                        // update stock
                        // StockModel::where('item_id', $request->product_id[$i])
                        // 			->decrement('quantity', $request->quantity[$i]);
                    }


                    /*  NEW CUSTOMER INSERT INTO customers TABLE FROM SALE PANEL  */
                    $customerMailPhoneExists = CustomerModel::where('phone', '=', $request->number)->first();
                    if (isset($customerMailPhoneExists->id)) {
                        $customer_id = $customerMailPhoneExists->id;
                    }

                    if ($customerMailPhoneExists === null) {

                        $newCustomer = new CustomerModel();
                        $newCustomer->first_name = $request->first_name;
                        $newCustomer->last_name = $request->last_name;
                        $newCustomer->email = $request->email;
                        $newCustomer->phone = $request->number;
                        $newCustomer->country = $request->country;
                        $newCustomer->district = $request->district;
                        $newCustomer->city = $request->city;
                        $newCustomer->thana = $request->thana;
                        $newCustomer->area = $request->area;
                        $newCustomer->road_no = $request->road;
                        $newCustomer->house_no = $request->house;
                        $newCustomer->flat_no = $request->flat;
                        $newCustomer->car_no = $request->car_no;
                        $newCustomer->address = $request->address;
                        $newCustomer->created_by = @Auth::user()->first_name;
                        $newCustomer->updated_by = @Auth::user()->first_name;
                        $newCustomer->save();

                        WelcomeCallModel::create([
                            'customer_id' => $newCustomer->id,
                            'created_by' => $newCustomer->first_name
                        ]);

                    }

                    Session::forget('cart');
                    DB::commit();

                    $email = $request->email;

                    $firstName = $request->first_name;
                    $lastName = $request->last_name;
                    $number = $request->number;

//                    $uniqueId = sprintf("%04s", $order->id);
                    $uniqueId = "#0101" . $order->id;

                    $address = '';
                    $address .= $request->flat ? 'Flat no - ' . $request->flat . ', ' : '';
                    $address .= $request->house ? 'House no - ' . $request->house . ', ' : '';
                    $address .= $request->road ? 'Road no - ' . $request->road . ', ' : '';
                    $address .= $request->area ? $request->area . ', ' : '';
                    $address .= $request->thana ? $request->thana . ', ' : '';
                    $address .= $request->city ? $request->city . ', ' : '';
                    $address .= $request->district ? $request->district . ', ' : '';
                    $address .= $request->country ? $request->country . ', ' : '';
                    $address = trim($address);
                    $address = rtrim($address, ',');
                    $address .= '.';

                    if ($email != null && $email != '') {
                        Mail::to($email)->send(new OrderConfirmationMail($firstName, $lastName, $email, $number, $address, $uniqueId));
                    }

                    return response()->json("success");
                } catch (\Exception $exception) {
                    DB::rollback();
                    Log::error($exception->getMessage());
                    return response()->json(array('dbErrors' => $exception->getMessage()));
                }

            }

        }

    }


    function shopBySubCat($id)
    {
        $allCategories = CategoryModel::where('soft_delete', 0)->get();
        $allProducts = ItemModel::where('soft_delete', 0)->where('is_outsourced',0)->where('is_published', 1)->where('sub_category_id', $id)->paginate(9, ['*'], 'post_page');
        $brands = BrandModel::where('soft_delete', 0)->get();
        $sections = SectionModel::where('soft_delete', 0)->get();
        $dataArray = [
            'allCategories' => $allCategories,
            'allProducts' => $allProducts,
            'brands' => $brands,
            'sections' => $sections
        ];
        return view('shop.shopBySubCategory', $dataArray);
    }


    public function shopByBrand($id)
    {
        $allCategories = CategoryModel::where('soft_delete', 0)->get();
        $allProducts = ItemModel::where('soft_delete', 0)->where('is_outsourced',0)->where('is_published', 1)->where('brand_id', $id)->paginate(9, ['*'], 'post_page');
        $brands = BrandModel::where('soft_delete', 0)->get();
        $sections = SectionModel::where('soft_delete', 0)->get();
        $dataArray = [
            'allCategories' => $allCategories,
            'allProducts' => $allProducts,
            'brands' => $brands,
            'sections' => $sections
        ];
        return view('shop.shopByCategory', $dataArray);
    }


    public function myAccountView()
    {
        if (Auth::user()) {
            $email = Auth::user()->email;

            $allCategories = CategoryModel::where('soft_delete', 0)->get();
            $brands = BrandModel::where('soft_delete', 0)->get();
            $orderHistory = OrderModel::where('email', $email)->where('soft_delete', 0)->get();
            $sections = SectionModel::where('soft_delete', 0)->get();


            $dataArray = [
                'allCategories' => $allCategories,
                'orderHistory' => $orderHistory,
                'brands' => $brands,
                'sections' => $sections

            ];


            return view('shop.myAccount', $dataArray);
        } else {
            return redirect()->route('login');
        }
    }


    public function productDetailsByAccount(Request $request)
    {
        $shippingChargeApplied = OrderModel::where('id', $request->id)->where('soft_delete', 0)->first()->is_shipment_charge_applied;
        $orderDetails = OrderDetailsModel::where('order_id', $request->id)->where('soft_delete', 0)->get();
        $shippingCharge = DeliveryChargeModel::where('soft_delete', '0')->where('name', 'shippingcharge')->first();

        $data = [
            'shippingChargeApplied' => $shippingChargeApplied,
            'orderDetails' => $orderDetails,
            'shippingCharge' => $shippingCharge
        ];

        return view('shop.orderDetails', $data);
    }


    public function contactFormView()
    {

        $allCategories = CategoryModel::where('soft_delete', 0)->get();
        $brands = BrandModel::where('soft_delete', 0)->get();
        $sections = SectionModel::where('soft_delete', 0)->get();


        $dataArray = [
            'allCategories' => $allCategories,
            'brands' => $brands,
            'sections' => $sections
        ];


        return view('shop.contact', $dataArray);
    }


    public function contactMailSendAjax(Request $request)
    {


        //gettings attributes
        $attributeNames = array(
            'name' => $request->firstName,
            'email' => $request->email,
            'contact_number' => $request->mobilenumber,
            'message' => $request->mssge,
            'type' => $request->type
        );


        //return dd($attributeNames);

        //validating the attributes
        $validator = Validator::make($attributeNames, [
            'name' => 'required',
            'email' => 'required',
            'contact_number' => 'required',
            'message' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        } else {

            ContactModel::create($attributeNames);
            // Mail::send(new ContactMail($email,$name,$number,$message));
            return response()->json("success");
        }
    }


    public function accountSettingsView()
    {

        $allCategories = CategoryModel::where('soft_delete', 0)->get();
        $brands = BrandModel::where('soft_delete', 0)->get();
        $sections = SectionModel::where('soft_delete', 0)->get();


        $dataArray = [
            'allCategories' => $allCategories,
            'brands' => $brands,
            'sections' => $sections
        ];


        return view('shop.accountSettings', $dataArray);
    }


    public function accountSettingsAjax(Request $request)
    {


        $userInfo = User::findOrFail(Auth::user()->id);
        if ($request->confirmPass) {
            $pass = Hash::make($request->confirmPass);
        } else {
            $pass = $userInfo->password;
        }


        $attributeNames = array(
            'name' => $request->name,
            'email' => $request->email,
            'password' => $pass
        );


        //return dd($attributeNames);

        //validating the attributes
        $validator = Validator::make($attributeNames, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . Auth::user()->id,
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        } else {
            $userInfo->update($attributeNames);
            return response()->json("Success");
        }
    }


    public function aboutUs()
    {

        $allCategories = CategoryModel::where('soft_delete', 0)->get();
        $brands = BrandModel::where('soft_delete', 0)->get();
        $sections = SectionModel::where('soft_delete', 0)->get();


        $dataArray = [
            'allCategories' => $allCategories,
            'brands' => $brands,
            'sections' => $sections
        ];


        return view('shop.about', $dataArray);
    }


    public function getProductByRange(Request $request)
    {
        $allProducts = ItemModel::where('soft_delete', 0)
            ->where('is_outsourced',0)
            ->where('is_published', 1)
            ->whereBetween('sales_price', [$request->from, $request->to])
            ->get();
        $dataArray = [
            'allProducts' => $allProducts
        ];
        return view('shop.allProductsAjax', $dataArray)->render();
    }

    /**
     * @param $ip
     * @return void
     * Unique visit counts
     */
    protected function countSiteVisit($ip)
    {
        $visitData = SiteVisit::where('visitor_ip',$ip)->first();

//        if(!$visitData){
//            DB::table('site_visits')->insert(
//                [
//                    'visitor_ip' => $ip,
//                    'visited_at' => date('Y-m-d H:i:s')
//                ]
//            );
//        }
        DB::table('site_visits')->insert(
            [
                'visitor_ip' => $ip,
                'visited_at' => date('Y-m-d H:i:s')
            ]
        );
    }

}
