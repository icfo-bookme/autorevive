<?php
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['auth', 'hasAccess']], function () {

    //Fund Insert Crud Routes (Fund Category routes)
    Route::get('fundCategoryView', 'fundInsert\FundCategoryController@fundCategoryView')->name('fundCategoryView');
    Route::post('listAllFundCategories', 'fundInsert\FundCategoryController@listAllFundCategories')->name('listAllFundCategories');
    Route::post('fundCategoryInsert', 'fundInsert\FundCategoryController@fundCategoryInsert')->name('fundCategoryInsert');
    Route::post('getFundCategoryEditForm', 'fundInsert\FundCategoryController@getFundCategoryEditForm')->name('getFundCategoryEditForm');
    Route::post('fundCategoryUpdate', 'fundInsert\FundCategoryController@fundCategoryUpdate')->name('fundCategoryUpdate');
    Route::post('fundCategoryDelete', 'fundInsert\FundCategoryController@fundCategoryDelete')->name('fundCategoryDelete');

    //(Fund Sub Category routes)
    Route::get('fundSubCategoryView', 'fundInsert\FundSubCategoryController@fundSubCategoryView')->name('fundSubCategoryView');
    Route::post('listAllFundSubCategories', 'fundInsert\FundSubCategoryController@listAllFundSubCategories')->name('listAllFundSubCategories');
    Route::post('fundSubCategoryInsert', 'fundInsert\FundSubCategoryController@fundSubCategoryInsert')->name('fundSubCategoryInsert');
    Route::post('getFundSubCategoryEditForm', 'fundInsert\FundSubCategoryController@getFundSubCategoryEditForm')->name('getFundSubCategoryEditForm');
    Route::post('fundSubCategoryUpdate', 'fundInsert\FundSubCategoryController@fundSubCategoryUpdate')->name('fundSubCategoryUpdate');
    Route::post('fundSubCategoryDelete', 'fundInsert\FundSubCategoryController@fundSubCategoryDelete')->name('fundSubCategoryDelete');

    //(Fund Insert routes)
    Route::get('fundInsertView', 'fundInsert\FundInsertController@fundInsertView')->name('fundInsertView');
    Route::post('listAllInsertedFunds', 'fundInsert\FundInsertController@listAllInsertedFunds')->name('listAllInsertedFunds');
    Route::post('getFundSubcategoriesByCategoryId', 'fundInsert\FundInsertController@getFundSubcategoriesByCategoryId')->name('getFundSubcategoriesByCategoryId');
    Route::post('fundInsert', 'fundInsert\FundInsertController@fundInsert')->name('fundInsert');
    Route::post('getFundEditForm', 'fundInsert\FundInsertController@getFundEditForm')->name('getFundEditForm');
    Route::post('fundUpdate', 'fundInsert\FundInsertController@fundUpdate')->name('fundUpdate');
    Route::post('fundDelete', 'fundInsert\FundInsertController@fundDelete')->name('fundDelete');


});

?>
