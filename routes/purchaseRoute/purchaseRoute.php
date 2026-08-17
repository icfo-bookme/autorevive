<?php
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' =>['auth','hasAccess']], function () {

    //Purchase Route
    Route::get('purchaseSetupView','purchase\PurchaseController@purchaseSetupView');
    Route::post('purchaseInserAjax','purchase\PurchaseController@purchaseInserAjax');
    Route::get('allPurchaseView','purchase\PurchaseController@allPurchaseView');
    Route::get('allSinglePurchaseView','purchase\PurchaseController@allSinglePurchaseView');
    Route::get('purchaseInfoView/{id}','purchase\PurchaseController@purchaseInfoView');
    Route::get('purchaseInfoEdit/{id}','purchase\PurchaseController@purchaseInfoEdit')->name('purchaseInfoEdit');
    Route::post('purchaseUpdateAjax','purchase\PurchaseController@purchaseUpdateAjax');
    Route::post('purchaseDeleteAjax','purchase\PurchaseController@purchaseDeleteAjax');
    Route::get('abnormalPurchaseView','purchase\PurchaseController@abnormalPurchaseView');


    //purchase Drafts Route
    // Route::post('draftedPurchaseInserAjax','purchase\PurchaseController@draftedPurchaseInserAjax');
    // Route::get('draftedPurchaseInfoEdit/{id}','purchase\PurchaseController@draftedPurchaseInfoEdit')->name('draftedPurchaseInfoEdit');
    // Route::post('draftedPurchaseUpdateAjax','purchase\PurchaseController@draftedPurchaseUpdateAjax');
    Route::get('allDraftedPurchaseView','purchase\PurchaseController@allDraftedPurchaseView');
    Route::post('draftInsert', 'purchase\PurchaseController@draftInsert')->name('draftInsert');
    Route::post('getDraftEditForm', 'purchase\PurchaseController@getDraftEditForm')->name('getDraftEditForm');
    Route::post('draftUpdate', 'purchase\PurchaseController@draftUpdate')->name('draftUpdate');
    Route::post('draftDelete', 'purchase\PurchaseController@draftDelete')->name('draftDelete');
    Route::get('draftedPurchaseSetupView/{id}','purchase\PurchaseController@draftedPurchaseSetupView');


    
    //Stock Routes
    Route::get('allStockView','purchase\PurchaseController@allStockView');
    Route::post('listAllStocks','purchase\PurchaseController@listAllStocks')->name('listAllStocks');
    Route::get('stockOutView','purchase\PurchaseController@stockOutView');
    Route::get('listAllStockOut','purchase\PurchaseController@listAllStockOut')->name('listAllStockOut');
    Route::post('change-status/{id}','purchase\PurchaseController@stockPublicSatusChange');
    Route::post('change-price-display/{id}','purchase\PurchaseController@priceDisplaySatusChange');

    //Physical Inventory Count Panel Routes
    Route::get('physicalStockCount','purchase\PurchaseController@physicalStockCount');
    Route::post('itemCountByBarcode','purchase\PurchaseController@itemCountByBarcode');
    Route::post('getItemCountDetailsAjax','purchase\PurchaseController@getItemCountDetailsAjax');
    Route::post('itemCountUpdateAjax','purchase\PurchaseController@itemCountUpdateAjax');
    Route::get('discrepancyReport','purchase\PurchaseController@discrepancyReport');
    Route::post('listAllPhysicalStockCount','purchase\PurchaseController@listAllPhysicalStockCount')->name('listAllPhysicalStockCount');
    Route::post('listAllForDiscrepancyReport','purchase\PurchaseController@listAllForDiscrepancyReport')->name('listAllForDiscrepancyReport');
    Route::post('backupAndClearCountDataList','purchase\PurchaseController@backupAndClearCountDataList');
    Route::get('stockCountSheet','purchase\PurchaseController@stockCountSheet');



    //Added by hamida
    Route::post('getPurchaseDetails','purchase\PurchaseController@getPurchaseDetails');
    Route::post('updateItemPrice', 'purchase\PurchaseController@updateItemPrice');
    Route::post('editRequestAjax', 'purchase\PurchaseController@editRequestAjax');
    Route::get('allEditRequests', 'purchase\PurchaseController@allEditRequests');
    Route::post('approveEditRequest', 'purchase\PurchaseController@approveEditRequest');
    Route::post('duplicateFlagAjax', 'purchase\PurchaseController@duplicateFlagAjax');
    Route::post('crossFlagAjax', 'purchase\PurchaseController@crossFlagAjax');
    Route::get('stockDetailsView/{id}','purchase\PurchaseController@stockDetailsView');
    Route::get('stockDetailsEdit/{id}','purchase\PurchaseController@stockDetailsEdit');
    Route::post('purchaseUpdateFromStock', 'purchase\PurchaseController@purchaseUpdateFromStock');
    Route::get('getItemDetailsForStockView/{id}', 'purchase\PurchaseController@getItemDetailsForStockView');
    Route::post('getPriceAndQuantityForStockEdit', 'purchase\PurchaseController@getPriceAndQuantityForStockEdit');


    //Purchase Log Routes
    Route::prefix('purchase-logs')->name('purchase-logs.')->namespace('purchase')->middleware(['auth', 'hasAccess'])->group(function () {
        Route::get('/view','PurchaseController@purchaseLogsView')->name('view');
        Route::post('/list','PurchaseController@listPurchaseLogs')->name('list');
        Route::get('view-details/{id}','PurchaseController@viewPurchaseLogsDetails')->name('view-details');
    });

    // Route::post('getPricesById','purchase\PurchaseController@getPricesById');

    //Item search by barcode from POS sales panel
    Route::post('itemSearchByBarcode','purchase\PurchaseController@itemSearchByBarcode');
    Route::post('downloadBarcode','purchase\PurchaseController@downloadBarcode');

    //Generate barcode for previously purchased item
    Route::get('generateBarcodeForPreviousPurchase','purchase\PurchaseController@generateBarcodeForPreviousPurchase');

    Route::get('copyPurchasedItemsToStock','purchase\PurchaseController@copyPurchasedItemsToStock');

    Route::get('copyDuplicateFlagFromOldStockToStock','purchase\PurchaseController@copyDuplicateFlagFromOldStockToStock');

    Route::get('test', 'purchase\PurchaseController@test');

    Route::get('testPurchaseMismatch','purchase\PurchaseController@testPurchaseMismatch');


});

?>