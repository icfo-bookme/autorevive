<?php
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['auth', 'hasAccess']], function () {
    Route::get('allCustomers', 'customer\CustomerController@allCustomers');
    Route::post('listAllCustomers', 'customer\CustomerController@listAllCustomers')->name('listAllCustomers');
    Route::post('addCustomer', 'customer\CustomerController@addCustomer');
    Route::post('getCustomerDetailsById', 'customer\CustomerController@getCustomerDetailsById');
    Route::post('getCustomerOrderHistoryAjax', 'customer\CustomerController@getCustomerOrderHistoryAjax');
    Route::post('userInformationUpdate', 'customer\CustomerController@userInformationUpdate');
    Route::post('getTemplateBody', 'customer\CustomerController@getTemplateBody');
    Route::post('sendSmsAllUser', 'customer\CustomerController@sendSmsAllUser');
    Route::get('addCustomerView', 'customer\CustomerController@addCustomerView');

    /**
     * Product requests
     */
    Route::get('admin/requests', 'product\ProductController@requests');
    Route::post('admin/approveRequest', 'react\HomePageController@approveRequest');
    Route::post('admin/deleteRequest', 'react\HomePageController@deleteRequest');

    
    //scripting routes
    Route::get('importNewCustomer', 'customer\CustomerController@importNewCustomer');
});

//public routes of website
Route::post('admin/requestInsertAjax', 'product\ProductController@requestInsertAjax');




?>