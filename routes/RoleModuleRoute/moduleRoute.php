<?php
use Illuminate\Support\Facades\Route;

//view route
Route::group(['middleware' => ['auth', 'hasAccess']], function () {

    // Route::get('/modulesView', 'module\moduleController@modulesView');
    // Route::get('/moduleInsertView', 'module\moduleController@moduleInsertView');
    // Route::get('/moduleSetupView', 'admin\module\moduleController@moduleSetupView');
});

//internal Route
Route::group(['middleware' => 'auth','hasAccess'], function () {

    // Route::post('/moduleInsertAjax', 'admin\module\moduleController@moduleInsertAjax');
    // Route::post('/getRouteByModule', 'module\moduleController@getRouteByModule');
    // Route::post('/moduleSetupAjax', 'module\moduleController@moduleSetupAjax');
    // Route::post('/moduleUpdatAjax', 'module\moduleController@moduleUpdatAjax');
    Route::get('admin/getModule/{id}', 'admin\module\moduleController@getModule');
    Route::post('admin/getModuleDetailsByidAjax', 'admin\module\moduleController@getModuleDetailsByidAjax');
    Route::post('admin/moduleDetailsUpdateAjax', 'admin\module\moduleController@moduleDetailsUpdateAjax');
    Route::post('admin/moduleDetailsDeleteAjax', 'admin\module\moduleController@moduleDetailsDeleteAjax');


});

?>