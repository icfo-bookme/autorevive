<?php
use Illuminate\Support\Facades\Route;

/* search */
Route::post('/categories', 'react\HomePageController@categories');
Route::post('/mainCategories', 'react\HomePageController@mainCategories');
Route::post('/latestCollection', 'react\HomePageController@latestCollection');
Route::post('/dynamicSections', 'react\HomePageController@dynamicSections');
Route::post('/getSidecartReactData', 'react\HomePageController@getSidecartReactData');
Route::post('/getWishReactData', 'react\HomePageController@getWishReactData');
Route::post('/allProducts','react\HomePageController@allProducts');


Route::post('/getProductsByProps', 'react\HomePageController@getProductsByProps');
Route::post('/shopByCat', 'react\HomePageController@shopByCat');
Route::post('/shopBySubCat', 'react\HomePageController@shopBySubCat');
/* sort */
Route::post('sortProductByParam', 'react\HomePageController@sortProductByParam');
Route::post('sortProductBySectionWithParam', 'react\HomePageController@sortProductBySectionWithParam');
Route::post('search', 'react\HomePageController@sortProductByParam');
Route::post('getAllProducts', 'react\HomePageController@getAllProducts');




