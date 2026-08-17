<?php
use Illuminate\Support\Facades\Route;

Route::group(['middleware' =>['auth','hasAccess']], function () {
    Route::get('itemSetupView','item\ItemController@itemSetupView');
    Route::post('itemInsertAjax','item\ItemController@itemInsertAjax');
    Route::post('getSubcategoryBycategoryAjax','item\ItemController@getSubcategoryBycategoryAjax');
    Route::get('allItemsView','item\ItemController@allItemsView');
    Route::post('listAllItems','item\ItemController@listAllItems')->name('listAllItems');
    Route::post('getItemInfoAjax','item\ItemController@getItemInfoAjax');
    Route::post('ItemPublicationInfoChangeAjax','item\ItemController@ItemPublicationInfoChangeAjax');
    Route::post('itemUpdateAjax','item\ItemController@itemUpdateAjax');
    Route::post('itemDeleteAjax','item\ItemController@itemDeleteAjax');
    Route::get('itemImageInfo/{id}','item\ItemController@itemImageInfo');
    Route::post('itemImageUpdateAjax','item\ItemController@itemImageUpdateAjax');
    Route::post('itemImageDeleteAjax','item\ItemController@itemImageDeleteAjax');
    Route::post('itemImageInsertAjax','item\ItemController@itemImageInsertAjax');
    Route::post('generateBarcode','item\ItemController@generateBarcode');
    Route::get('addWatermarkToPreviousImage','item\ItemController@addWatermarkToPreviousImage');
    Route::get('itemDuplicate/{id}','item\ItemController@itemDuplicate');
});


// Route::post('itemSetupView','item\ItemController@itemSetupView');
?>