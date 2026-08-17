<?php
use Illuminate\Support\Facades\Route;

Route::group(['middleware' =>['auth','hasAccess']], function () {
    Route::get('invoicePrintView/{id}','invoice\InvoiceController@invoicePrintView');
    Route::get('salesInvoicePrintViewUser/{id}', 'invoice\InvoiceController@salesInvoicePrintViewUser');
});
//working now
Route::get('invoicePrintViewUser/{id}','invoice\InvoiceController@invoicePrintViewUser');

//public eInvoice 
Route::get('e-Invoice/{id}','invoice\InvoiceController@eInvoiceView');

?>
