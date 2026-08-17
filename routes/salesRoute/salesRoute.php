<?php
use Illuminate\Support\Facades\Route;

Route::group(['middleware' =>['auth','hasAccess']], function () {

    Route::get('salesDueView','order\OrderController@salesDueView');
    Route::get('dueViewDatatable','order\OrderController@dueViewDatatable')->name('dueViewDatatable');
    Route::post('dueCollected', 'order\OrderController@dueCollected');
    Route::post('getDueDetails', 'order\OrderController@getDueDetails');
    Route::get('salesCompletedView','order\OrderController@salesCompletedView');
    Route::get('getCompletedOrders','order\OrderController@getCompletedOrders')->name('getCompletedOrders');
    Route::get('allSoldItemsView','order\OrderController@allSoldItemsView');
    Route::post('listAllSoldItems','order\OrderController@listAllSoldItems')->name('listAllSoldItems');
    Route::get('salesReturnView/{id}','order\OrderController@salesReturnView');
    Route::get('salesView','order\OrderController@salesView');
    Route::post('salesInsert','order\OrderController@salesInsert');
    Route::post('salesUpdate','order\OrderController@salesUpdate');
    Route::post('cancelSale','order\OrderController@cancelSale');
    Route::get('cancelledSalesView','order\OrderController@cancelledSalesView');

    Route::prefix('sale_logs')->name('sale_logs.')->namespace('order')->middleware(['auth', 'hasAccess'])->group(function () {
        Route::get('/view','OrderController@salesLogView')->name('view');
        Route::post('/list','OrderController@listSalesView')->name('list');
        Route::get('view-details/{id}','OrderController@viewSalesLogsDetails')->name('view-details');
    });

    Route::prefix('due_collection_history')->name('due_collection_history.')->namespace('order')->middleware(['auth', 'hasAccess'])->group(function () {
        Route::get('/view','OrderController@dueCollectionHistoryView')->name('view');
        Route::post('/list','OrderController@listAllDueSalesView')->name('list');
        Route::get('view-details/{id}','OrderController@viewDueSalesPaymentHistory')->name('view-details');
    });

    Route::post('salesLogView','order\OrderController@salesLogView');
    Route::get('saleDetailsView/{id}', 'order\OrderController@saleDetailsView');
    
    Route::get('outsourceView','order\OrderController@outsourceView');
    Route::post('outsourceInsert','order\OrderController@outsourceInsert');
    Route::get('outsourceReturnDetails/{id}','order\OrderController@outsourceReturnDetails');
    Route::post('outsourceUpdate','order\OrderController@outsourceUpdate');


    Route::get('/searchPhoneNumber','order\OrderController@searchPhoneNumber');
    

});

?>