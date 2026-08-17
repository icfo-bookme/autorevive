<?php
use Illuminate\Support\Facades\Route;


/* search */
Route::post('searchProductBySubCategory', 'Shop\ProductController@searchProductBySubCategory');

// Route::post('sortProductByPopularity', 'Shop\ProductController@sortProductByPopularity');
// Route::post('sortProductByTimeDesc', 'Shop\ProductController@sortProductByTimeDesc');
// Route::post('sortProductByPriceLowToHigh', 'Shop\ProductController@sortProductByPriceLowToHigh');
// Route::post('sortProductByPriceHighToLow', 'Shop\ProductController@sortProductByPriceHighToLow');

Route::post('getModelByBrandIdAjax', 'car\CarBrandController@getModelByBrandIdAjax');
Route::get('searchCar', 'Shop\HomeController@searchCar');


/**
 * Complain
 */
Route::get('admin/complain', 'complain\ComplainController@compalin');
Route::post('admin/insertComplainAjax', 'complain\ComplainController@insertComplainAjax');



/**
 * Delivery Man
 */
Route::post('getTeamsDeliveryHistoryAjax', 'delivery\deliveryController@getTeamsDeliveryHistoryAjax');



/**
 * Rating
 */
Route::post('getItemRatingAjax', 'rating\RatingController@getItemRatingAjax');
Route::post('insertItemRatingAjax', 'rating\RatingController@insertItemRatingAjax');
Route::post('getAllItemRatingAjax', 'rating\RatingController@getAllItemRatingAjax');
Route::post('deleteItemRatingAjax', 'rating\RatingController@deleteItemRatingAjax');

// /**
//  * shipment comment
//  */
// Route::post('insertComment', 'order\OrderController@insertComment');

/**
 * New Password
 */
Route::post('setNewPassword', 'react\HomePageController@setNewPassword');

/**
 * Report
 */
Route::group(
    ['middleware' => ['auth', 'hasAccess']],
    function () {
        Route::get('dailyPurchaseReport', 'report\ReportController@dailyPurchaseReport');
        Route::get('dailyPurchaseReportAjax/{fromDate}/{toDate}', 'report\ReportController@dailyPurchaseReportAjax');
    }
);



/**
 * Delivery/Team Leader pages
 */
Route::get('orderDeliveryManAssign/{id}', 'order\OrderController@orderDeliveryManAssign');
Route::post('orderApproveAjax', 'order\OrderController@orderApproveAjax');


/**
 * Section re-order
 */
Route::post('reorderSectionAjax', 'section\SectionController@reorderSectionAjax');


/**
 * Delivery man notificaton
 */
Route::post('getDeliveryManNotification', 'react\HomePageController@getDeliveryManNotification');
Route::post('setNotificationAsSeen', 'react\HomePageController@setNotificationAsSeen');

/**
 * Settings Page
 */
Route::get('dashboardSettings', 'react\HomePageController@dashboardSettings');
Route::post('updateUserInfoAjax', 'react\HomePageController@updateUserInfoAjax');


/**
 * ItemRoute
 */
Route::post('tagDelete', 'item\ItemController@tagDelete');



/**
 * AJAX - routes (for React)
 */
Route::post('getCompanies', 'car\CarController@getCompanies');
Route::post('getItemDetails/{id}', 'react\HomePageController@getItemDetails');
Route::post('getMyAccountDetail', 'react\HomePageController@getMyAccountDetail');


// Route::post('shopByCategoryAjax/{id}', 'react\HomePageController@shopByCategoryAjax');
Route::post('shopBySectionAjax', 'react\HomePageController@shopBySectionAjax');
Route::post('shopByCategoryAjax', 'react\HomePageController@shopByCategoryAjax');
Route::post('shopBySubCategoryAjax', 'react\HomePageController@shopBySubCategoryAjax');

Route::post('searchByCategoryAjax', 'react\HomePageController@searchByCategoryAjax');

Route::post('getUserDetails', 'react\HomePageController@getUserDetails');
Route::post('updateUsersInfoAjax', 'react\HomePageController@updateUsersInfoAjax');

Route::post('getParentCategory', 'react\HomePageController@getParentCategory');



// temp
// Route::get('allCustomers', 'customer\CustomerController@allCustomers');
