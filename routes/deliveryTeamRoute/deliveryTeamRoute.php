<?php
use Illuminate\Support\Facades\Route;

Route::group(['middleware' =>['auth','hasAccess']], function () {

    /**  @var DeliveryTeam  routes **/
    Route::get('deliveryTeamView','delivery\deliveryController@deliveryTeamView');
    Route::post('deliveryTeamInsertAjax','delivery\deliveryController@deliveryTeamInsertAjax');
    Route::post('getMemberDetails','delivery\deliveryController@getMemberDetails');
    Route::post('deliveryTeamUpdateAjax','delivery\deliveryController@deliveryTeamUpdateAjax');
    Route::post('deliveryTeamDeleteAjax','delivery\deliveryController@deliveryTeamDeleteAjax');



    /**  @var TeamLeader  routes **/
    Route::get('teamLeaderView', 'delivery\TeamLeaderController@teamLeaderView');
    Route::post('getTeamLeaderDetails', 'delivery\TeamLeaderController@getTeamLeaderDetails');
    Route::post("teamLeaderInsertAjax", "delivery\TeamLeaderController@teamLeaderInsertAjax");
    Route::post("teamLeaderUpdateAjax", "delivery\TeamLeaderController@teamLeaderUpdateAjax");
    Route::post("teamLeaderDeleteAjax", "delivery\TeamLeaderController@teamLeaderDeleteAjax");
    Route::post("getTeamLeaderDeliveryHistoryAjax", "delivery\TeamLeaderController@getTeamLeaderDeliveryHistoryAjax");
    
});
