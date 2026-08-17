<?php
use Illuminate\Support\Facades\Route;

Route::group(['middleware' =>['auth','hasAccess']], function () {
    Route::get('allVendorView','vendor\vendorController@allVendorView');
    Route::post('vendorInsertAjax','vendor\vendorController@vendorInsertAjax');
    Route::post('getVendorDetails','vendor\vendorController@getVendorDetails');
    Route::post('vendorUpdateAjax','vendor\vendorController@vendorUpdateAjax');
    Route::post('vendorDeleteAjax','vendor\vendorController@vendorDeleteAjax');
});

?>