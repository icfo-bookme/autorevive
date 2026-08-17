<?php
use Illuminate\Support\Facades\Route;

Route::group(['middleware' =>['auth','hasAccess']], function () {
    Route::get('allSectionView','section\SectionController@allSectionView');
    Route::post('sectionInsertAjax','section\SectionController@sectionInsertAjax');
    Route::post('getSectionDetails','section\SectionController@getSectionDetails');
    Route::post('sectionUpdateAjax','section\SectionController@sectionUpdateAjax');
    Route::post('sectionDeleteAjax','section\SectionController@sectionDeleteAjax');
});
Route::get('getAllSections','section\SectionController@getAllSections');

?>