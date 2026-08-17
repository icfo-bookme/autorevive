<?php
use Illuminate\Support\Facades\Route;

Route::group(['middleware' =>['auth','hasAccess']], function () {
    //COMPANY
    Route::get('companySetupView','car\CarController@companySetupView');
    Route::post('companyInsertAjax','car\CarController@companyInsertAjax');

    //BRAND
    Route::get('carBrandSetupView','car\CarBrandController@carBrandSetupView');
    Route::post('carBrandInsertAjax','car\CarBrandController@carBrandInsertAjax');

    //MODEL
    Route::get('carModelSetupView','car\CarModelController@carModelSetupView');
    Route::post('carModelInsertAjax','car\CarModelController@carModelInsertAjax');

    //ENGINE
    Route::get('carEngineSetupView','car\CarModelController@carEngineSetupView');
    Route::post('carEngineInsertAjax','car\CarModelController@carEngineInsertAjax');

    //ALL COMPANIES VIEW,EDIT AND DELETE
    Route::get('allCompaniesView','car\CarController@allCompaniesView');
    Route::post('getCompanyInfoAjax','car\CarController@getCompanyInfoAjax');
    Route::post('companyUpdateAjax','car\CarController@companyUpdateAjax');
    Route::post('companyDeleteAjax','car\CarController@companyDeleteAjax');

    //ALL BRANDS VIEW,EDIT AND DELETE
    Route::get('allCarBrandsView','car\CarBrandController@allCarBrandsView');
    Route::post('getCarBrandInfoAjax','car\CarBrandController@getCarBrandInfoAjax');
    Route::post('carBrandUpdateAjax','car\CarBrandController@carBrandUpdateAjax');
    Route::post('carBrandDeleteAjax','car\CarBrandController@carBrandDeleteAjax');

    //ALL MODELS VIEW,EDIT AND DELETE
    Route::get('allCarModelsView','car\CarModelController@allCarModelsView');
    Route::post('getCarModelInfoAjax','car\CarModelController@getCarModelInfoAjax');
    Route::post('carModelUpdateAjax','car\CarModelController@carModelUpdateAjax');
    Route::post('carModelDeleteAjax','car\CarModelController@carModelDeleteAjax');

    //ALL ENGINES VIEW,EDIT AND DELETE
    Route::get('allCarEnginesView','car\CarModelController@allCarEnginesView');
    Route::post('getCarEngineInfoAjax','car\CarModelController@getCarEngineInfoAjax');
    Route::post('carEngineUpdateAjax','car\CarModelController@carEngineUpdateAjax');
    Route::post('carEngineDeleteAjax','car\CarModelController@carEngineDeleteAjax');


    Route::post('getAllBrandsAjax', 'car\CarBrandController@getAllBrandsAjax');
    Route::post('getAllModelsAjax', 'car\CarBrandController@getAllModelsAjax');
});

//public routes
Route::post('getBrandByCompanyIdAjax','car\CarBrandController@getBrandByCompanyIdAjax'); 
?>

