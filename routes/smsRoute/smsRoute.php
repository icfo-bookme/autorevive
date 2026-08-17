<?php
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['auth','hasAccess']],function(){

    //route to add templates and send sms from customers list page
    Route::get('smsTemplateView', 'sms\SmsController@smsTemplateView');
    Route::post('listAllTemplate', 'sms\SmsController@listAllTemplate')->name('listAllTemplate');
    Route::post('smsTemplateInsert', 'sms\SmsController@smsTemplateInsert');
    Route::post('getsmsTemplateForm', 'sms\SmsController@getsmsTemplateForm');
    Route::post('templateUpdate', 'sms\SmsController@templateUpdate');
    Route::post('templateDelete', 'sms\SmsController@templateDelete');

    //route to setting sms
    Route::get('smsSettingView', 'sms\SmsController@smsSettingView');
    Route::post('smsSettingUpsert', 'sms\SmsController@smsSettingUpsert');


});


?>