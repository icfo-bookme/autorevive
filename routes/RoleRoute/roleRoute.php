<?php
use Illuminate\Support\Facades\Route;

// Route::group(['middleware' => ['auth', 'hasAccess']], function () {

//     Route::get('/admin', 'HomeController@index')->name('home');
//     Route::get('/roleInsert', 'role\RoleController@roleInsertView');
//     Route::get('/rolesView', 'role\RoleController@rolesView');
//     Route::get('/rolesAssign', 'role\RoleController@rolesAssignView');
//     Route::get('/rolesAssignUser', 'role\RoleController@roleAssignUserView');

// });

// Route::group(['middleware' => 'auth','hasAccess'], function () {

//     Route::post('/roleInsertAjaxRequest', 'role\RoleController@roleInsertAjaxRequest');
//     Route::post('/rolesDeleteAjax', 'role\RoleController@rolesDeleteAjax');
//     Route::post('/rolesAssignInsert', 'role\RoleController@rolesAssignInsert');
//     Route::post('/roleAssignUserInsertAjax', 'role\RoleController@roleAssignUserInsertAjax');
//     Route::post('/getmodulebyrole', 'role\RoleController@getmodulebyrole');
//     Route::post('/roleModuleAssignAjax', 'role\RoleController@roleModuleAssignAjax');
//     Route::post('/getRole', 'role\RoleController@getRole');
//     Route::post('/getAllRoles', 'role\RoleController@getAllRoles');
//     Route::post('/roleUpdatAjax', 'role\RoleController@roleUpdatAjax');

// });

Route::group(['middleware' => 'hasAccess','auth'], function () {
    Route::get('/admin', 'HomeController@index')->name('home');
    Route::get('/admin/roleInsert', 'admin\role\RoleController@index');
    Route::get('/admin/rolesView', 'admin\role\RoleController@rolesView');
    Route::get('/admin/rolesAssign', 'admin\role\RoleController@rolesAssign');

    Route::get('/admin/adminPanelRegister', 'admin\role\RoleController@adminPanelRegister');
    Route::post('/admin/adminRegister', 'admin\role\RoleController@adminRegister');

    Route::get('/admin/rolesAssignUser', 'admin\role\RoleController@roleAssignUser');
    Route::post('/admin/getModuleByUser', 'admin\role\RoleController@getModuleByUser');
    Route::post('/admin/removeUserRole', 'admin\role\RoleController@removeUserRole');
    Route::post('/admin/removeRoleModule', 'admin\role\RoleController@removeRoleModule');
    Route::post('/admin/roleInsertAjaxRequest', 'admin\role\RoleController@roleInsertAjaxRequest');
    Route::post('/admin/rolesDeleteAjax', 'admin\role\RoleController@rolesDeleteAjax');


    Route::get('/admin/modulesView', 'admin\module\moduleController@modulesView');
    Route::get('/admin/moduleInsert', 'admin\module\moduleController@moduleInsert');
    Route::post('/admin/moduleInsertAjax', 'admin\module\moduleController@moduleInsertAjax');
    Route::post('admin/updateModule/{id}', 'admin\module\moduleController@updateModule');
    Route::post('admin/modulesDeleteAjax', 'admin\module\moduleController@modulesDeleteAjax');
    //Route::get('/admin/moduleSetupView', 'admin\module\moduleController@moduleSetup');
    Route::get('/admin/moduleSetupView', 'admin\module\moduleController@moduleSetupView');
    Route::post('admin/moduleDetailsInsertAjax', 'admin\module\moduleController@moduleDetailsInsertAjax');
    Route::get('admin/moduleRouteView', 'admin\module\moduleController@moduleRouteView');
    Route::post('/admin/removeModuleRoute' ,'admin\module\moduleController@removeModuleRoute');


    Route::post('/admin/roleAssignUserInsertAjax', 'admin\role\RoleController@roleAssignUserInsertAjax');
    Route::post('/admin/getmodulebyrole', 'admin\role\RoleController@getmodulebyrole');
    Route::post('/admin/roleModuleAssignAjax', 'admin\role\RoleController@roleModuleAssignAjax');
    Route::post('/admin/getRole/', 'admin\role\RoleController@getRole');
    Route::get('/admin/getAllRoles', 'admin\role\RoleController@getAllRoles');
    Route::post('/admin/roleUpdatAjax', 'admin\role\RoleController@updateRole');
    Route::post('/admin/getRouteByModule', 'admin\module\moduleController@getRouteByModule');
});

?>