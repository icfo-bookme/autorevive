<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('shop.index');
// });

use App\Events\ShipmentAssigned;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/* Logs */
Route::group(['middleware' =>['auth','hasAccess']], function () {
   Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');
});

Route::get('/', 'HomeController@index');
Route::post('/getAllProducts', 'Shop\HomeController@getAllProducts');
Route::get('/singleProductDetails/{id}', 'Shop\HomeController@singleProductDetails');
Route::get('/checkout', 'Shop\HomeController@checkOut');
Route::post('/checkoutDone', 'Shop\HomeController@checkoutDone');
Route::post('userRegister','user\UserController@userRegister');
Route::get('shopview','Shop\HomeController@shopview');
Route::get('shopBySection/{id}','Shop\HomeController@shopBySection');
Route::get('shopByCategory/{id}','Shop\HomeController@shopByCat');
Route::get('shopBySubCategory/{id}','Shop\HomeController@shopBySubCat');

Route::get('/getUserDeatailsToAutofill', 'Shop\HomeController@getUserDeatailsToAutofill');

// Route::get('shopBySubCat/{id}','Shop\HomeController@shopBySubCat');
// Route::get('shopByBrand/{id}','Shop\HomeController@shopByBrand');
Route::get('getProductByBrandAjax','Shop\ProductController@getProductByBrandAjax');
Route::get('myAccountView','Shop\HomeController@myAccountView');
Route::get('productDetailsByAccount','Shop\HomeController@productDetailsByAccount');
// Route::get('contactFormView','Shop\HomeController@contactFormView');
Route::get('connectWithUs','Shop\HomeController@contactFormView');
Route::get('aboutUs','Shop\HomeController@aboutUs');



Route::post('/addToCart','Shop\ProductController@addToCart');
Route::post('/addToWish','Shop\ProductController@addToWish');
Route::get('/wishList', 'Shop\ProductController@wishList');
Route::post('/decreaseToCart','Shop\ProductController@decreaseToCart');
Route::post('/addToCartFromDetails','Shop\ProductController@addToCartFromDetails');
Route::get('searchProductByBrand/','Shop\ProductController@searchProductByBrand');
Route::get('/searchProductByCategory','Shop\ProductController@searchProductByCategory');
Route::post('/checkoutDoneIncreaseItem','Shop\ProductController@checkoutDoneIncreaseItem');
Route::post('removeItemFromCart','Shop\HomeController@removeItemFromCart');
Route::post('removeItemFromWish','Shop\HomeController@removeItemFromWish');
Route::post('clearCart','Shop\HomeController@clearCart');

Route::get('/searchProducts','Shop\ProductController@searchProducts');

Route::post('getProductByRange','Shop\HomeController@getProductByRange');
Route::get('getSidecartData','Shop\HomeController@getSidecartData');



Auth::routes();

Route::get('accountSettingsView','Shop\HomeController@accountSettingsView');
Route::post('accountSettingsAjax','Shop\HomeController@accountSettingsAjax');

//role middleware route
include('RoleRoute/roleRoute.php');
include('RoleModuleRoute/moduleRoute.php');


// vendor route
include('vendorRoute/vendorRoute.php');

// category route
include('categoryRoute/categoryRoute.php');

// sub-category route
include('subCategoryRoute/subCategoryRoute.php');

// brand route
include('brandRoute/brandRoute.php');

// items route
include('itemRoute/itemRoute.php');

// purchase route
include('purchaseRoute/purchaseRoute.php');

// order route
include('orderRoute/orderRoute.php');

// section
include('sectionRoute/sectionRoute.php');

// delivary team route
include('deliveryTeamRoute/deliveryTeamRoute.php');
include('payment/paymentRoute.php');


// delivery charge
include('deliveryChargeRoute/deliveryChargeRoute.php');

// Report view
include('reportRoute/reportRoute.php');

// customer route
include('customerRoute/customerRoute.php');

// customer mail
include('customerMailRoute/customerMailRoute.php');

// welcome route
include('welcomeRoute/welcomeRoute.php');

// invoice route
include('invoiceRoute/invoiceRoute.php');

// Car route
include('carRoute/carRoute.php');

// cost management route
include('costManagementRoute/costManagementRoute.php');

// highlights route
include('highlightsRoute/highlightsRoute.php');

// booking route
include('bookingRoute/bookingRoute.php');

// sales route
include('salesRoute/salesRoute.php');

//cashStoragePlatform route
include('cashStoragePlatformRoute/cashStoragePlatformRoute.php');

//Fund route
include('fundRoute/fundRoute.php');

//Re-investment route
include('reinvestmentRoute/reinvestmentRoute.php');

// sms route
include('smsRoute/smsRoute.php'); 



include('usamaRoute.php');
include('react/reactRoute.php');

Route::group(['middleware' =>['auth','hasAccess']], function () {
    Route::post('getProductByIdAjax','Shop\ProductController@getProductByIdAjax');
    Route::post('getProductByPurchaseItemBarcodeId','Shop\ProductController@getProductByPurchaseItemBarcodeId');
    Route::get('siteDetails','website\WebsiteController@siteDetails');
    Route::post('insertSiteDetails','website\WebsiteController@insertSiteDetails');

});




Route::get('/searchInvoiceAdmin','invoice\InvoiceController@searchInvoiceAdmin');

Route::get('event', function(){
   // event(new ShipmentAssigned('halelola'));
   event(new ShipmentAssigned('halelola','hey','hi','hello'));
});


Route::get('listen', function(){
   return view('layouts.backend.master');
});

//  Route::get('shipmentCompleted', function(){
//    event(new ShipmentCompleted('Shipment Completed','completedOrder'));
// });

Route::get('listenShipmentCompleted', function(){
   return view('layouts.backend.master');
 });

Route::get('/menuList','menu\MenuController@menuList');

Auth::routes(['verify' => true]);

// Route::get('/home', 'HomeController@index')->name('home');


//Script routes
Route::get('/resizePreviousUploadedImage', 'Shop\HomeController@resizePreviousUploadedImage');
Route::get('/unusedNidRemove', 'delivery\deliveryController@unusedNidRemove');
Route::get('/unusedChallanRemove', 'purchase\PurchaseController@unusedChallanRemove');
Route::get('/unuseditemimagesRemove', 'item\ItemController@unuseditemimagesRemove');
Route::get('/stockCrossFlaggedDataDelete', 'test\TestController@stockCrossFlaggedDataDelete');




//Test Routes
Route::get('/salesUpdateFix', 'test\TestController@salesUpdateFix');
Route::get('/invoiceAmountFix', 'test\TestController@invoiceAmountFix');
Route::get('/addInvoiceDateFromSaleToSalesdetails', 'test\TestController@addInvoiceDateFromSaleToSalesdetails');
Route::get('/count', 'test\TestController@count');




