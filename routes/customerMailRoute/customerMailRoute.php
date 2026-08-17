<?php
use Illuminate\Support\Facades\Route;


Route::group(['middleware' => ['auth', 'hasAccess']], function () {
    Route::get('allCustomerMailView','customerMail\CustomerMailController@allCustomerMailView');
    Route::post('contactMailDeleteAjax','customerMail\CustomerMailController@contactMailDeleteAjax');
    Route::post('contactMailReplyAjax','customerMail\CustomerMailController@contactMailReplyAjax');
});

//public routes of website
Route::post('contactMailSendAjax','Shop\HomeController@contactMailSendAjax');

?>