<?php
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['auth', 'hasAccess']], function () {
    Route::get('cashInsertView', 'CashFlowController@cashInsertView');
    Route::post('cashInsertAjax', 'CashFlowController@cashInsertAjax');
    Route::post('getCashInfo', 'CashFlowController@getCashInfo');
    Route::post('cashUpdateAjax', 'CashFlowController@cashUpdateAjax');


    // Route::get('cashFlowView', 'CashFlowController@cashFlowViewPaid');
    Route::post('cashflowInsertAjax', 'CashFlowController@cashflowInsertAjax');
    Route::get('cashFlowView', 'CashFlowController@cashFlowView');
    Route::post('getCashFlowInfo', 'CashFlowController@getCashFlowInfo');
    Route::post('updateCashFlowDetails', 'CashFlowController@update');


    Route::get('approveInventory', 'CashFlowController@approveInventoryView');
    Route::post('approveByInv', 'CashFlowController@approveByInv');

    
    Route::get('approveBySupplyChain', 'CashFlowController@approveBySupplyChainView');
    Route::post('approveBySupp', 'CashFlowController@approveBySupp');

    
    Route::get('approveByHOP', 'CashFlowController@approveByHopView');
    Route::post('approvedByHop', 'CashFlowController@approvedByHop');

    
    Route::get('approveByCeo', 'CashFlowController@approveByCeoView');
    Route::post('approveByCeo', 'CashFlowController@approveByCeo');


    Route::get('allRequisitions', 'CashFlowController@allRequisitionsView');
});

?>