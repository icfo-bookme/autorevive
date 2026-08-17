<?php
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['auth', 'hasAccess']], function () {
    //(Reinvestment routes)
    Route::get('reinvestmentView', 'reinvestment\ReinvestmentController@reinvestmentView')->name('reinvestmentView');
    Route::post('listAllReinvestment', 'reinvestment\ReinvestmentController@listAllReinvestment')->name('listAllReinvestment');
    Route::post('reinvestmentInsert', 'reinvestment\ReinvestmentController@reinvestmentInsert')->name('reinvestmentInsert');
    Route::post('getReinvestmentEditForm', 'reinvestment\ReinvestmentController@getReinvestmentEditForm')->name('getReinvestmentEditForm');
    Route::post('reinvestmentUpdate', 'reinvestment\ReinvestmentController@reinvestmentUpdate')->name('reinvestmentUpdate');
    Route::post('investmentDelete', 'reinvestment\ReinvestmentController@investmentDelete')->name('investmentDelete');

});

?>