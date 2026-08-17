<?php


Route::group(['middleware' => ['auth', 'hasAccess']], function () {

    Route::get('roleView', 'role\RoleController@roleView');
    Route::post('roleInsertAjax', 'role\RoleController@roleInsertAjax');
    Route::get('editRoleAjax/{id}', 'role\RoleController@editRoleAjax');
    Route::patch('updateRoleAjax/{id}', 'role\RoleController@updateRoleAjax');
    Route::get('deleteRoleAjax/{id}', 'role\RoleController@deleteRoleAjax');
});
