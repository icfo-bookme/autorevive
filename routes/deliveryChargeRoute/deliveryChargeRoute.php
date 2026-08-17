<?php
use Illuminate\Support\Facades\Route;

Route::group(['middleware' =>['auth','hasAccess']], function () {
    Route::get('deliveryChargeView','deliveryCharge\DeliveryChargeController@deliveryChargeView');
    Route::post('deliveryChargeInsertAjax','deliveryCharge\DeliveryChargeController@deliveryChargeInsertAjax');
    Route::post('getChargeDetails','deliveryCharge\DeliveryChargeController@getChargeDetails');
    Route::post('chargeUpdateAjax','deliveryCharge\DeliveryChargeController@chargeUpdateAjax');
    Route::post('chargeDeleteAjax','deliveryCharge\DeliveryChargeController@chargeDeleteAjax');
});

?>