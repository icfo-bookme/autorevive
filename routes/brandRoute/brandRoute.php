<?php
use Illuminate\Support\Facades\Route;

Route::group(['middleware' =>['auth','hasAccess']], function () {
    Route::get('allBrandView','brand\BrandController@allBrandView');
    Route::post('brandInsertAjax','brand\BrandController@brandInsertAjax');
    Route::post('getBrandDetails','brand\BrandController@getBrandDetails');
    Route::post('brandUpdateAjax','brand\BrandController@brandUpdateAjax');
    Route::post('brandDeleteAjax','brand\BrandController@brandDeleteAjax');
});

?>