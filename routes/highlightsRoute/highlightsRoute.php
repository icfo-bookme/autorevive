<?php
use Illuminate\Support\Facades\Route;

Route::group(['middleware' =>['auth','hasAccess']], function () {
    Route::get('highlightsView', 'highlights\HighlightsController@highlightsView');
    Route::post('highlightsDelete', 'highlights\HighlightsController@highlightsDelete');
});

?>