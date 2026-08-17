<?php
use Illuminate\Support\Facades\Route;

Route::group(['middleware' =>['auth','hasAccess']], function () {
    Route::get('bookingView','order\OrderController@bookingView');
    Route::post('bookingInsert','order\OrderController@bookingInsert');
    Route::get('bookedOrdersView','order\OrderController@bookedOrdersView');
    Route::get('editBooking/{id}','order\OrderController@editBooking');
    Route::post('bookingUpdate','order\OrderController@bookingUpdate');
    Route::post('getBookingDetails','order\OrderController@getBookingDetails');
    Route::post('changeBookingStatus','order\OrderController@changeBookingStatus');
    Route::post('getBookingInfoForSale','order\OrderController@getBookingInfoForSale');
});

?>