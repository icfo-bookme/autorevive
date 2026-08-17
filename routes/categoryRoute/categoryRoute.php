<?php
use Illuminate\Support\Facades\Route;

Route::group(['middleware' =>['auth','hasAccess']], function () {

    Route::get('allCategoryView','category\CategoryController@allCategoryView');
    Route::post('categoryInsertAjax','category\CategoryController@categoryInsertAjax');
    Route::post('getCategoryDetails','category\CategoryController@getCategoryDetails');
    Route::post('categoryUpdateAjax','category\CategoryController@categoryUpdateAjax');
    Route::post('categoryDeleteAjax','category\CategoryController@categoryDeleteAjax');

    Route::post('getCatPriority','category\CategoryController@getCategoryDetails');
    Route::post('updateCatPriority', 'category\CategoryController@priorityUpdateAjax');

});

?>