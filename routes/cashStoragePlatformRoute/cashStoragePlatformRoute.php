<?php
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['auth', 'hasAccess']], function () {
    //Ending Balance Routes
    Route::get('cashStoragePlatformView', 'cashStoragePlatform\cashStoragePlatformController@cashStoragePlatformView');
     Route::get('cashStoragePlatformViewInactive', 'cashStoragePlatform\cashStoragePlatformController@cashStoragePlatformViewInactive');
    Route::post('cashStoragePlatformInsertAjax', 'cashStoragePlatform\cashStoragePlatformController@cashStoragePlatformInsertAjax');
    Route::post('cashStoragePlatformUpdateAjax', 'cashStoragePlatform\cashStoragePlatformController@cashStoragePlatformUpdateAjax');
    Route::post('cashStoragePlatformDeleteAjax', 'cashStoragePlatform\cashStoragePlatformController@cashStoragePlatformDeleteAjax');
    Route::post('cashStoragePlatformRestoreAjax', 'cashStoragePlatform\cashStoragePlatformController@cashStoragePlatformRestoreAjax');
    Route::post('getCashPlatformName', 'cashStoragePlatform\cashStoragePlatformController@getCashPlatformName');
    Route::post('cashPlatformNameUpdate', 'cashStoragePlatform\cashStoragePlatformController@cashPlatformNameUpdate');
    // Route::post('totalCashCalculationDetails/{parameter}', 'cashStoragePlatform\cashStoragePlatformController@totalCashCalculationDetails');
    Route::get('totalCashCalculationDetails', 'cashStoragePlatform\cashStoragePlatformController@totalCashCalculationDetails')->name('totalCashCalculationDetails');


    //Cost Insert Crud Routes (Cost Category routes)
    Route::get('costCategoryView', 'costInsert\CostCategoryController@costCategoryView')->name('costCategoryView');
    Route::get('costCategoryViewInactive', 'costInsert\CostCategoryController@costCategoryViewInactive')->name('costCategoryViewInactive');
    Route::post('listAllCostCategories', 'costInsert\CostCategoryController@listAllCostCategories')->name('listAllCostCategories');
    Route::post('listAllCostCategoriesInactive', 'costInsert\CostCategoryController@listAllCostCategoriesInactive')->name('listAllCostCategoriesInactive');

    Route::post('costCategoryInsert', 'costInsert\CostCategoryController@costCategoryInsert')->name('costCategoryInsert');
    Route::post('getCostCategoryEditForm', 'costInsert\CostCategoryController@getCostCategoryEditForm')->name('getCostCategoryEditForm');
    Route::post('costCategoryUpdate', 'costInsert\CostCategoryController@costCategoryUpdate')->name('costCategoryUpdate');
    Route::post('costCategoryDelete', 'costInsert\CostCategoryController@costCategoryDelete')->name('costCategoryDelete');
    Route::post('costCategoryRestore', 'costInsert\CostCategoryController@costCategoryRestore')->name('costCategoryRestore');
    //(Cost Sub Category routes)
    Route::get('costSubCategoryView', 'costInsert\CostSubCategoryController@costSubCategoryView')->name('costSubCategoryView');
    Route::post('listAllCostSubCategories', 'costInsert\CostSubCategoryController@listAllCostSubCategories')->name('listAllCostSubCategories');
    Route::post('costSubCategoryInsert', 'costInsert\CostSubCategoryController@costSubCategoryInsert')->name('costSubCategoryInsert');
    Route::post('getCostSubCategoryEditForm', 'costInsert\CostSubCategoryController@getCostSubCategoryEditForm')->name('getCostSubCategoryEditForm');
    Route::post('costSubCategoryUpdate', 'costInsert\CostSubCategoryController@costSubCategoryUpdate')->name('costSubCategoryUpdate');
    Route::post('costSubCategoryDelete', 'costInsert\CostSubCategoryController@costSubCategoryDelete')->name('costSubCategoryDelete');

    //(Cost Insert routes)
    Route::get('costInsertView', 'costInsert\CostInsertController@costInsertView')->name('costInsertView');
    Route::post('listAllInsertedCosts', 'costInsert\CostInsertController@listAllInsertedCosts')->name('listAllInsertedCosts');
    Route::post('getSubcategoriesByCategoryId', 'costInsert\CostInsertController@getSubcategoriesByCategoryId')->name('getSubcategoriesByCategoryId');
    Route::post('costInsert', 'costInsert\CostInsertController@costInsert')->name('costInsert');
    Route::post('getCostEditForm', 'costInsert\CostInsertController@getCostEditForm')->name('getCostEditForm');
    Route::post('showCostEditReasonPage', 'costInsert\CostInsertController@showCostEditReasonPage')->name('showCostEditReasonPage');
    Route::post('getCostEditReasonDetails', 'costInsert\CostInsertController@getCostEditReasonDetails')->name('getCostEditReasonDetails');
    Route::post('costUpdate', 'costInsert\CostInsertController@costUpdate')->name('costUpdate');
    Route::post('costDelete', 'costInsert\CostInsertController@costDelete')->name('costDelete');
    Route::post('approvalStatusChange', 'costInsert\CostInsertController@approvalStatusChange')->name('approvalStatusChange');
    Route::post('getCostLogForm', 'costInsert\CostInsertController@getCostLogForm')->name('getCostLogForm');
});

?>
