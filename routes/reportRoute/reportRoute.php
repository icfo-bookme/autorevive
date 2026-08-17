<?php
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['auth', 'hasAccess']], function () {
    Route::get('allOrderReport','report\ReportController@allOrderReport');
    Route::get('allOrderReportAjax/{fromDate}/{toDate}/{orderType}','report\ReportController@allOrderReportAjax');
    Route::get('pendingOrderReport','report\ReportController@pendingOrderReport');
    Route::get('deadlineMissReport','report\ReportController@deadlineMissReport');
    Route::get('deadlineMissReportAjax/{fromDate}/{toDate}/{teamId}','report\ReportController@deadlineMissReportAjax');

    Route::get('collectedPaymentOrders','report\ReportController@collectedPaymentOrders');
    Route::get('collectedPaymentOrdersAjax/{fromDate}/{toDate}/{payment_method}','report\ReportController@collectedPaymentOrdersAjax');
    Route::get('pendingOrderReportAjax/{fromDate}/{toDate}','report\ReportController@pendingOrderReportAjax');

    // daily order
    Route::get('dailyOrderReport', 'report\ReportController@dailyOrderReport');
    Route::get('dailyOrderReportAjax/{fromDate}/{toDate}', 'report\ReportController@dailyOrderReportAjax');

    // daily delivery
    Route::get('dailyDeliveryReport', 'report\ReportController@dailyDeliveryReport');
    Route::get('dailyDeliveryReportAjax/{fromDate}/{toDate}', 'report\ReportController@dailyDeliveryReportAjax');

    // daily sales
    Route::get('dailySalesReport', 'report\ReportController@dailySalesReport');
    Route::post('dailySalesReportAjax', 'report\ReportController@dailySalesReportAjax')->name('dailySalesReportAjax');
    Route::post('dailySalesReportByItemAjax', 'report\ReportController@dailySalesReportByItemAjax')->name('dailySalesReportByItemAjax');
    Route::post('getinvoiceListHistoryAjax', 'report\ReportController@getinvoiceListHistoryAjax');

    // collection report collectionReportAjax
    Route::get('collectionReport', 'report\ReportController@collectionReport');
    Route::get('collectionReportAjax/{fromDate}/{toDate}', 'report\ReportController@collectionReportAjax');

    // collection report collectionReportAjax
    Route::get('deliveryTeamReport', 'report\ReportController@deliveryTeamReport');
    Route::get('deliveryTeamReportAjax/{fromDate}/{toDate}/{teamId}', 'report\ReportController@deliveryTeamReportAjax');

    // profit-loss report
    Route::get('profitLossReport', 'report\ReportController@profitLossReport');
    Route::post('profitLossReportAjax', 'report\ReportController@profitLossReportAjax')->name('profitLossReportAjax');

    // Net profit-loss report
    Route::get('netProfitLossReport', 'report\ReportController@netProfitLossReport');
    Route::get('netProfitOrdersDataReportAjax/{fromDate}/{toDate}', 'report\ReportController@netProfitOrdersDataReportAjax');
    Route::get('netProfitFundsDataReportAjax/{fromDate}/{toDate}', 'report\ReportController@netProfitFundsDataReportAjax');
    Route::get('netProfitCostsDataReportAjax/{fromDate}/{toDate}', 'report\ReportController@netProfitCostsDataReportAjax');
    Route::post('viewCountNetProfitReportAjax', 'report\ReportController@viewCountNetProfitReportAjax');

    // due sales report
    Route::get('dueSalesReport', 'report\ReportController@dueSalesReport');
    Route::get('dueSalesReportAjax/{fromDate}/{toDate}', 'report\ReportController@dueSalesReportAjax');

    // cash withdrawal report
    Route::get('cashWithdrawalReport', 'report\ReportController@cashWithdrawalReport');
    Route::get('cashWithdrawalReportAjax/{fromDate}/{toDate}', 'report\ReportController@cashWithdrawalReportAjax');

    // website visitor report
    Route::get('websiteVisitorReport', 'report\ReportController@websiteVisitorReport');
    Route::get('websiteVisitorReportAjax/{fromDate}/{toDate}', 'report\ReportController@websiteVisitorReportAjax');

    // expense report
    Route::get('expenseReport', 'report\ReportController@expenseReport');
    Route::post('getCostSubcatBycatAjax','report\ReportController@getCostSubcatBycatAjax');
    // Route::post('expenseReportAjax/{fromDate}/{toDate}/{cat}/{subCat}', 'report\ReportController@expenseReportAjax')->name('expenseReportAjax');
    Route::post('expenseReportAjax', 'report\ReportController@expenseReportAjax')->name('expenseReportAjax');

    // fund report
    Route::get('fundReport', 'report\ReportController@fundReport');
    Route::post('getFundSubcatBycatAjax','report\ReportController@getFundSubcatBycatAjax');
    Route::get('fundReportAjax/{fromDate}/{toDate}/{cat}/{subCat}', 'report\ReportController@fundReportAjax');

    //ending balance report
    Route::get('endingBalanceReport', 'report\ReportController@endingBalanceReport');
    Route::get('endingBalanceReportAjax/{fromDate}/{toDate}', 'report\ReportController@endingBalanceReportAjax');

});

?>