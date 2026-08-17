<?php
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['auth', 'hasAccess']], function () {
    Route::get('welcomeCallView', 'customer\CustomerController@welcomeCallView');
    Route::post('approveWelcomeCall','customer\CustomerController@approveWelcomeCall');
    Route::post('listAllPendingWelcomeCallData','customer\CustomerController@listAllPendingWelcomeCallData')->name('listAllPendingWelcomeCallData');
    Route::post('listAllApprovedWelcomeCallData','customer\CustomerController@listAllApprovedWelcomeCallData')->name('listAllApprovedWelcomeCallData');
});

?>