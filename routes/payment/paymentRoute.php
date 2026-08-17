<?php
use Illuminate\Support\Facades\Route;

Route::group(['middleware' =>['auth','hasAccess']], function () {
    Route::get('collectPayment','payment\PaymentController@collectPayment');
    Route::get('paymentCollectionDetails/{id}','payment\PaymentController@paymentCollectionDetails');
    Route::post('paymentCollectedAjax','payment\PaymentController@paymentCollectedAjax');
    Route::get('completedOrder','payment\PaymentController@completedOrder');
    Route::get('completedOrderDetailsView/{id}','payment\PaymentController@completedOrderDetailsView');
    Route::get('cashWithdraw','payment\PaymentController@cashWithdraw');
    Route::POST('cashWithDrawInsert','payment\PaymentController@cashWithDrawInsert');
});

?>