<?php 
use Illuminate\Support\Facades\Route;

//Permission Module Route
//view route
Route::group(['middleware' =>['auth','hasAccess']], function () {

Route::get('/PermissionModulesView', 'permissionModule\PermissionModuleController@PermissionModulesView');
Route::get('/PermissionModuleInsert', 'permissionModule\PermissionModuleController@PermissionModuleInsert');
Route::get('/PermissionModuleSetup', 'permissionModule\PermissionModuleController@PermissionModuleSetup');
Route::get('/PermissionModuleRouteView', 'permissionModule\PermissionModuleController@PermissionModuleRouteView');
Route::get('/PermissionModuleRoleAssign','permissionModule\PermissionModuleController@PermissionModuleRoleAssign');
});

//internal Route
Route::group(['middleware' => 'auth','hasAccess'], function () {

Route::post('/PermissionModuleInsertAjax', 'permissionModule\PermissionModuleController@PermissionModuleInsertAjax');
Route::post('/PermissionModuleDetailsInsertAjax','permissionModule\PermissionModuleController@PermissionModuleDetailsInsertAjax');
Route::post('/PermissionModulesDeleteAjax','permissionModule\PermissionModuleController@PermissionModulesDeleteAjax');
Route::get('/getRouteByPermissionModule/{id}','permissionModule\PermissionModuleController@getRouteByPermissionModule');
Route::get('/getPermissionModule/{id}', 'permissionModule\PermissionModuleController@getPermissionModule');
Route::patch('/updatePermissionModule/{id}', 'permissionModule\PermissionModuleController@updatePermissionModule');
Route::post('/getPermissionModuleDetailsByidAjax','permissionModule\PermissionModuleController@getPermissionModuleDetailsByidAjax');
Route::post('/PermissionModuleDetailsUpdateAjax','permissionModule\PermissionModuleController@PermissionModuleDetailsUpdateAjax');
Route::post('/PermissionModuleDetailsDeleteAjax','permissionModule\PermissionModuleController@PermissionModuleDetailsDeleteAjax');
Route::post('/PermissionModuleRoleAssignInsertAjax','permissionModule\PermissionModuleController@PermissionModuleRoleAssignInsertAjax');

});

