<?php
use Illuminate\Support\Facades\Route;

Route::group(['middleware' =>['auth','hasAccess']], function () {
    Route::get('allSubCategoryView', 'subCategory\SubCategoryController@allSubCategoryView');
    Route::post('subCategoryInsertAjax','subCategory\SubCategoryController@subCategoryInsertAjax');
    Route::post('getSubCategoryDetails','subCategory\SubCategoryController@getSubCategoryDetails');
    Route::post('subCategoryUpdateAjax','subCategory\SubCategoryController@subCategoryUpdateAjax');
    Route::post('subCategoryDeleteAjax','subCategory\SubCategoryController@subCategoryDeleteAjax');
});

?>