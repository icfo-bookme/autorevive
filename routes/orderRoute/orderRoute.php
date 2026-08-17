<?php
use Illuminate\Support\Facades\Route;

Route::group(['middleware' =>['auth','hasAccess']], function () {
    //Pending order
    Route::get('allOrderView','order\OrderController@allOrderView');
    // Route::get('allOrderViewold','order\OrderController@allOrderViewold');
    Route::get('orderDetailsView/{id}','order\OrderController@orderDetailsView');
    Route::get('orderDetailsViewOld/{id}','order\OrderController@orderDetailsViewOld');
    Route::post('removeItemFromOrderAjax', 'order\OrderController@removeItemFromOrderAjax');

    //Approved order
    Route::post('directShipmentAssignAjax','order\OrderController@directShipmentAssignAjax');

    Route::get('approvedOrderView','order\OrderController@approvedOrderView');
    Route::get('approvedOrderDetailsView/{id}','order\OrderController@approvedOrderDetailsView');
    Route::post('deliveryManAssignAjax','order\OrderController@deliveryManAssignAjax');

    Route::get('allOngoingOrderView','order\OrderController@allOngoingOrderView');
    Route::get('orderHistoryView','order\OrderController@orderHistoryView');
    Route::post('orderHistory','order\OrderController@orderHistory');

    //pickup route
    Route::post('pickupApproveAjax', 'order\OrderController@pickupApproveAjax');
    Route::post('pickupAjax','order\OrderController@pickupAjax');
    Route::get('pickupOrderView','order\OrderController@pickupOrderView');
    Route::get('pickupOrderDetailsView/{id}','order\OrderController@pickupOrderDetailsView');
    Route::post('pickupOrderApprovedAjax','order\OrderController@pickupOrderApprovedAjax');

    //Shipment order
    Route::get('shipmentOrderView','order\OrderController@shipmentOrderView');
    Route::get('shipmentOrderDetailsView/{id}','order\OrderController@shipmentOrderDetailsView');
    Route::post('insertComment','order\OrderController@insertComment');
    Route::post('shipmentOrderApprovedAjax','order\OrderController@shipmentOrderApprovedAjax');
    Route::post('shipmentOrderRescheduleAjax','order\OrderController@shipmentOrderRescheduleAjax');
    Route::get('cancelOrderView','order\OrderController@cancelOrderView');
    Route::get('CancelledDetailsView/{id}','order\OrderController@CancelledDetailsView');


    Route::get('pendingOrderDetailsView/{id}', 'order\OrderController@pendingOrderDetailsView');

    Route::post('cancelShipmentAjax', 'order\OrderController@cancelShipmentAjax');
    Route::get('orderDeadLineWarningSms', 'order\OrderController@orderDeadLineWarningSms');

    Route::get('getUserDataToAutofill', 'order\OrderController@getUserDataToAutofill');

    //PRIORITY
    Route::post('getPriorityDetails', 'order\OrderController@getPriorityDetails');
    Route::post('updatePriorityDetails', 'order\OrderController@priorityUpdate');

    //POS
    Route::get('refundView/{id}', 'order\OrderController@refundView');


    //scripting routes
    Route::get('CreateDataForSoldItemTrackTableOfAlreadyPlacedSale','order\OrderController@CreateDataForSoldItemTrackTableOfAlreadyPlacedSale');

    Route::get('testMail','order\OrderController@testMail');




    // Route::get('salesDueView','order\OrderController@salesDueView');
    // Route::post('dueCollected', 'order\OrderController@dueCollected');
    // Route::post('getDueDetails', 'order\OrderController@getDueDetails');
    // Route::get('salesCompletedView','order\OrderController@salesCompletedView');
    // Route::get('salesReturnView/{id}','order\OrderController@salesReturnView');
    // Route::get('salesView','order\OrderController@salesView');
    // Route::post('salesInsert','order\OrderController@salesInsert');
    // Route::post('salesUpdate','order\OrderController@salesUpdate');

    // Route::prefix('sale_logs')->name('sale_logs.')->namespace('order')->middleware(['auth', 'hasAccess'])->group(function () {
    //     Route::get('/view','OrderController@salesLogView')->name('view');
    //     Route::post('/list','OrderController@listSalesView')->name('list');
    //     Route::get('view-details/{id}','OrderController@viewSalesLogsDetails')->name('view-details');
    // });


    // Route::post('salesLogView','order\OrderController@salesLogView');


    //Booking routes
    // Route::get('bookingView','order\OrderController@bookingView');
    // Route::post('bookingInsert','order\OrderController@bookingInsert');
    // Route::get('bookedOrdersView','order\OrderController@bookedOrdersView');
    // Route::get('editBooking/{id}','order\OrderController@editBooking');
    // Route::post('bookingUpdate','order\OrderController@bookingUpdate');
    // Route::post('getBookingDetails','order\OrderController@getBookingDetails');
    // Route::post('changeBookingStatus','order\OrderController@changeBookingStatus');
    // Route::post('getBookingInfoForSale','order\OrderController@getBookingInfoForSale');


    // Route::get('saleDetailsView/{id}', 'order\OrderController@saleDetailsView');




});

?>