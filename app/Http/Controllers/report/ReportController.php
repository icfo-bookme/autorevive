<?php

namespace App\Http\Controllers\report;

use App\PaymentCollectionModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\deliveryCharge\DeliveryChargeModel;
use App\OrderModel;
use App\SiteVisit;
use Illuminate\Support\Facades\DB;
use App\shipment\ShipmentModel;
use App\admin\UserRolesModel;
use App\sales\SalesModel;
use App\sales\SalesDetailsModel;
use App\purchase\PurchaseModel;
use App\PaymentMethodModel;
use App\CashWithdraw\CashWithDrawModel;
use App\item\ItemModel;
use Exception;
use Intervention\Image\Facades\Image;
use SubCategory;
use Illuminate\Support\Facades\Log;
use App\CostInsert\CostCategory;
use App\CostInsert\CostInsert;
use App\CostInsert\CostSubCategory;
use App\FundInsert\FundCategory;
use App\FundInsert\FundInsert;
use App\FundInsert\FundSubCategory;
use App\CashStoragePlatform\CashStoragePlatform;
use Yajra\DataTables\DataTables;
use Carbon\Carbon;


define('DeliveryTeamRoleId', 3);

class ReportController extends Controller
{

    public function pendingOrderReport()
    {
        return view('admin.report.pendingOrderReport', ['deliveryTeam' => $this->getDeliveryTeam()]);
    }

    public function allOrderReport()
    {
        return view('admin.report.allOrderReport', ['deliveryTeam' => $this->getDeliveryTeam()]);
    }

    public function deadlineMissReport()
    {
        return view('admin.report.deadlineMissReport', ['deliveryTeam' => $this->getDeliveryTeam()]);
    }

    public function collectedPaymentOrders()
    {
        $paymentMethods = PaymentMethodModel::all();
        $data = [
            'paymentMethods'    => $paymentMethods
            // 'users'             => $users
        ];

        return view('admin.report.collectedPaymentOrders', ['deliveryTeam' => $this->getDeliveryTeam()], $data);
    }

    /**
     * * * * * * * * * * * * * * * *
     * NEW - start (PAGES)
     * * * * * * * * * * * * * * * *
     */
    public function dailyOrderReport()
    {
        return view('admin.report.dailyOrderReport', ['deliveryTeam' => $this->getDeliveryTeam()]);
    }

    public function dailyDeliveryReport()
    {
        return view('admin.report.dailyDeliveryReport', ['deliveryTeam' => $this->getDeliveryTeam()]);
    }

    public function dailySalesReport()
    {
        return view('admin.report.dailySalesReport', ['deliveryTeam' => $this->getDeliveryTeam()]);
    }

    public function dailyPurchaseReport()
    {
        return view('admin.report.dailyPurchaseReport', ['deliveryTeam' => $this->getDeliveryTeam()]);
    }

    public function challanReport()
    {
        return view('admin.report.challanReport', ['deliveryTeam' => $this->getDeliveryTeam()]);
    }

    public function invoiceReport()
    {
        return view('admin.report.invoiceReport', ['deliveryTeam' => $this->getDeliveryTeam()]);
    }

    public function collectionReport()
    {
        return view('admin.report.collectionReport', ['deliveryTeam' => $this->getDeliveryTeam()]);
    }

    public function profitLossReport()
    {
        return view('admin.report.profitLossReport', ['deliveryTeam' => $this->getDeliveryTeam()]);
    }

    public function netProfitLossReport()
    {
        return view('admin.report.netProfitLossReport', ['deliveryTeam' => $this->getDeliveryTeam()]);
    }

    public function dueSalesReport()
    {
        return view('admin.report.dueSalesReport', ['deliveryTeam' => $this->getDeliveryTeam()]);
    }

    public function cashWithdrawalReport()
    {
        return view('admin.report.cashWithdrawalReport', ['deliveryTeam' => $this->getDeliveryTeam()]);
    }

    public function websiteVisitorReport()
    {
        return view('admin.report.websiteVisitorReport', ['deliveryTeam' => $this->getDeliveryTeam()]);
    }

    public function expenseReport()
    {

        $categories     = CostCategory::where('soft_delete',SOFT_DELETE_NO)->get();
        $data = [
            'categories'    => $categories
        ];

        return view('admin.report.expenseReport',$data);
    }

    public function getCostSubcatBycatAjax(Request $request){
        try{
            $subCategory = CostSubCategory::select('id','name')->where(['category_id' => $request->id,'soft_delete' => SOFT_DELETE_NO])->get();

            if($subCategory){
                return response()->json([
                    'data'      => $subCategory,
                    'status'    => true
                ]);
            }
            return response()->json([
                'data'      => null,
                'status'    => false
            ]);
        } catch(Exception $exception){
            Log::error($exception->getMessage());
            return response()->json([
                'data'      => $exception->getMessage(),
                'status'    => false
            ]);

        }
    }

    public function fundReport()
    {

        $categories     = FundCategory::where('soft_delete',SOFT_DELETE_NO)->get();
        $data = [
            'categories'    => $categories
        ];

        return view('admin.report.fundReport',$data);
    }

    public function endingBalanceReport()
    {
        return view('admin.report.endingBalanceReport');
    }

    public function getFundSubcatBycatAjax(Request $request){
        try{
            $subCategory = FundSubCategory::select('id','name')->where(['category_id' => $request->id,'soft_delete' => SOFT_DELETE_NO])->get();

            if($subCategory){
                return response()->json([
                    'data'      => $subCategory,
                    'status'    => true
                ]);
            }
            return response()->json([
                'data'      => null,
                'status'    => false
            ]);
        } catch(Exception $exception){
            Log::error($exception->getMessage());
            return response()->json([
                'data'      => $exception->getMessage(),
                'status'    => false
            ]);

        }
    }



    public function deliveryTeamReport(){

        $deliveryTeamRoleId = 3; // more dynamic approach is needed
        // $deliveryTeam = UserRolesModel::where('role_id', $deliveryTeamRoleId)
        $deliveryTeam = UserRolesModel::where('role_id', env('DELIVERYMAN_ROLE'))
			->where('soft_delete', 0)
			->with('user')
            ->get(); // FIX IN VIEW

            $data = [
                'deliveryTeam' => $deliveryTeam
            ];

        return view('admin.report.deliveryTeamReport',$data);


    }


    public function deliveryTeamReportAjax(Request $request)
    {
        $fromDate  = $request->fromDate;
        $toDate    = $request->toDate;
        $teamId    = $request->teamId;

        // $shipments = ShipmentModel::whereDate('created_at', '>=', $fromDate)
        //                         ->whereDate('created_at', '<=', $toDate);
        $shipments = ShipmentModel::select('*', DB::raw('CASE WHEN completed_at IS NOT NULL THEN TIMESTAMPDIFF(minute, deadline_time, completed_at) ELSE TIMESTAMPDIFF(minute, deadline_time, now()) END AS difference'))
                                ->where('soft_delete', 0)
                                // ->whereDate('created_at', '>=', $fromDate)
                                // ->whereDate('created_at', '<=', $toDate);
                                ->whereDate('completed_at', '>=', $fromDate)
                                ->whereDate('completed_at', '<=', $toDate);
                                // ->whereRaw("TIMESTAMPDIFF(minute, deadline_time, completed_at) > 0");

        if ($request->teamId != 'all') {
            $shipments->where('delivery_team_id', $teamId);
        }

        $shipments = $shipments->get();
        // dd($shipments);

        return view('admin.report.deliveryTeamReportAjax', ['shipments' => $shipments]);
    }



    /**
     * * * * * * * * * * * * * * * *
     * NEW - start (AJAX)
     * * * * * * * * * * * * * * * *
     */
    // public function pendingOrderReportAjax()
    // {
    //     return view('admin.report.pendingOrderReport');
    // }

    public function deadlineMissReportAjax(Request $request)
    {
        $fromDate = $request->fromDate;
        $toDate = $request->toDate;

        $shipments = ShipmentModel::select('*',DB::raw('CASE WHEN completed_at IS NOT NULL THEN TIMESTAMPDIFF(minute,deadline_time,completed_at) ELSE TIMESTAMPDIFF(minute,deadline_time,now()) END AS difference'))->where('soft_delete', 0)->whereDate('created_at', '>=', $fromDate)->whereDate('created_at', '<=', $toDate)->whereRaw( "CASE WHEN  completed_at IS NOT NULL THEN TIMESTAMPDIFF(minute,deadline_time,completed_at)> 0 ELSE TIMESTAMPDIFF(minute,deadline_time,now())> 0 END");


        if ($request->teamId != 'all') {
           $shipments = $shipments->where('delivery_team_id',$request->teamId);
        }

        $shipments = $shipments->get();
        //dd($shipments[0]->orders->total_price[0]->total);

        return view('admin.report.deadlineMissReportAjax', ['shipments' => $shipments]);
    }


    public function allOrderReportAjax(Request $request){

        $fromDate   = $request->fromDate;
        $toDate     = $request->toDate;

        $orders = new OrderModel;

        // if ($request->teamId != 'all') {
        //     $shipments = $shipments->with(['shipment']);
        // }

        if($request->orderType == "ongoing" ){
            $orders = $orders->where('is_shipment', 0)
                                ->where('status',0)
                                    ->where('is_rejected', 0)
                                        ->where('soft_delete',0);

        }

        else if($request->orderType == "pending" ){
            $orders = $orders->where('is_approve', 0)
                                ->where('is_rejected', 0);


        }

        else if($request->orderType == "approved"){

            $orders = $orders->where('is_approve', 1)
                                ->where('is_rejected', 0)
                                    ->where('shipment_assigned', 0);


        }

        else if($request->orderType == "shipment"){

            $orders = $orders->where('is_approve', 1)
                                ->where('is_rejected', 0)
                                    ->where('shipment_assigned', 1)
                                        ->where('is_shipment', 0)
                                            ->where('delivery_type', 'delivery');

        }

        else if($request->orderType == "pickup"){

            $orders = $orders->where('is_approve', 1)
                                ->where('is_rejected', 0)
                                    ->where('shipment_assigned', 1)
                                        ->where('is_shipment', 0)
                                            ->where('delivery_type', 'pickup');

        }

        // else if($request->orderType == "payment"){

        //     $orders = $orders->where('is_rejected',0)
        //                         ->where('shipment_assigned',1)
        //                             ->where('is_shipment',1)
        //                                 ->where('is_payment',0);

        // }

        else if($request->orderType == "completed"){

            $orders = $orders->where('is_approve',1)
                                ->where('is_rejected',0)
                                    ->where('shipment_assigned',1)
                                        ->where('status',1)
                                            ->where('is_shipment',1)
                                                ->where('is_payment',1)
                                                    ->orderBy('id','DESC');

        }

        else if($request->orderType == "canceled"){
            $orders = $orders->where('is_rejected',1);
        }

        else if($request->orderType == "all"){
            $orders = $orders;
        }

        $deliveryCharge = DeliveryChargeModel::select('amount')->where('name', 'shippingcharge')->first();

        $orders = $orders->whereDate('created_at', '>=', $fromDate)->whereDate('created_at', '<=', $toDate)->where('delivery_type','!=', "shop")->where('soft_delete',0)->get();


        return view('admin.report.allOrderReportAjax', ['orders' => $orders,'deliveryCharge' => $deliveryCharge]);

    }



    public function dailyOrderReportAjax(Request $request)
    {
        $fromDate = $request->fromDate;
        $toDate = $request->toDate;
        $orders = OrderModel::where('soft_delete', 0)->where('delivery_type','!=', "shop")->whereDate('created_at', '>=', $fromDate)->whereDate('created_at', '<=', $toDate)->get();
        return view('admin.report.dailyOrderReportAjax', ['orders' => $orders]);
    }


    public function dailyDeliveryReportAjax(Request $request)
    {
        $fromDate = $request->fromDate;
        $toDate = $request->toDate;
        $deliveries = OrderModel::where('is_approve', 1)
            ->where('is_rejected', 0)
            ->where('shipment_assigned', 1)
            ->where('is_shipment', 1)
            ->where('soft_delete', 0)
            ->whereDate('shipment_completed_at', '>=', $fromDate)
            ->whereDate('shipment_completed_at', '<=', $toDate)
            ->get();

        return view('admin.report.dailyDeliveryReportAjax', ['deliveries' => $deliveries]);
    }

    public function dailySalesReportAjax(Request $request)
    {
        $fromDate   = $request->fromDate;
        $toDate     = $request->toDate;
        $sales = SalesModel::where('status', 1)
            ->whereDate('completed_at', '>=', $fromDate)
            ->whereDate('completed_at', '<=', $toDate)
            ->where('is_cancelled',0)
            ->where('is_due_paid',1)
            ->get();
        
        // Calculate the total collected payment
        $totalCollectedPayment = $sales->sum(function($sale) {
            if (isset($sale->total_price[0]->total)) {
                $totalPrice = $sale->total_price[0]->total;
                return ($totalPrice + $sale->is_shipment_charge_applied) - $sale->discount_amount;
            }
            return 0;
        });
    
        // Return data to DataTables
        if ($request->ajax()) {
            return DataTables::of($sales)
                ->addIndexColumn() 
                ->addColumn('invoice_no', function ($sale) {
                    return '<a onclick="invoiceModal(' . $sale->order_id . ')" style="padding: 5px 10px;color: #fff;cursor: pointer;" class="btn badge badge-primary" data-toggle="tooltip" title="" data-original-title="Invoice">
                                #0202' . $sale->order_id .
                            '</a>';
                })
                ->addColumn('customer_name', function ($sale) {
                    return '<a class="custom_textDecoration" href="' . url('completedOrderDetailsView', $sale->order_id) . '" style="cursor: pointer">' . $sale->first_name . ' ' . $sale->last_name . '</a>';
                })
                ->addColumn('completed_at', function ($sale) {
                    return Carbon::parse($sale->completed_at)->format('Y-m-d');  // Ensure Carbon is used for formatting
                })
                // Add Total
                // ->addColumn('total', function($sale) {
                //     return ($sale->total_price[0]->total + $sale->is_shipment_charge_applied) - $sale->discount_amount;
                // })
                ->addColumn('total', function($sale) {
                    $total = ($sale->total_price[0]->total + $sale->is_shipment_charge_applied) - $sale->discount_amount;
                    return number_format($total, 2, '.', '');
                })
                ->setRowClass(function ($sale) {
                    return 'text-center';
                })
                ->with('total_collected_payment', $totalCollectedPayment) 
                ->rawColumns(['invoice_no', 'customer_name', 'completed_at', 'total'])
                ->make(true); 
        }
    
        return view('admin.report.dailySalesReport'); // Adjust this view as necessary
    }

    public function dailySalesReportByItemAjax(Request $request)
    {
        $fromDate = $request->fromDate;
        $toDate = $request->toDate;

        $soldItems = SalesDetailsModel::select("*")
            ->selectRaw('sum(quantity) as quantitySum')
            ->selectRaw('sum(price) as sum')
            ->groupBy('barcode_id')
            ->where('updated_by', '!=', 'website')
            ->where('soft_delete',0)
            ->with(['sales','barcode','product'])
            ->whereHas('sales', function($q)use($fromDate,$toDate){
                $q->where('status', 1)
                    ->whereDate('completed_at', '>=', $fromDate)
                    ->whereDate('completed_at', '<=', $toDate)
                    ->where('is_cancelled',0)
                    ->where('is_due_paid',1);
            })->get();

        // Calculate totalCollectedSum
        $totalCollectedSum = $soldItems->sum('sum');

        // Return data to DataTables
        if ($request->ajax()) {
            return DataTables::of($soldItems)
                ->addIndexColumn()
                ->addColumn('barcode', function ($row) use ($fromDate, $toDate) {
                    if ($row->product->is_outsourced == 0) {
                        return '<a onclick="getinvoiceListHistory(' . ($row->barcode_id ?? 'null') . ', \'' . $fromDate . '\', \'' . $toDate . '\')" 
                                   class="custom_textDecoration" data-toggle="tooltip" 
                                   title="Invoices" 
                                   style="cursor: pointer; color: #C70909;">' . 
                                   ($row->barcode->barcode ?? 'N/A') . 
                               '</a>';
                    } else {
                        return '<a onclick="invoiceModal(' . ($row->order_id ?? 'null') . ')" 
                                   class="custom_textDecoration" data-toggle="tooltip" 
                                   title="Invoice" 
                                   style="cursor: pointer; color: #C70909;">-- Outsourced --</a>';
                    }
                })
                ->addColumn('item_name', function ($row) {
                    return $row->product->name;
                })
                // ->addColumn('total', function ($row) {
                //     return $row->sum;
                // })
                ->addColumn('total', function ($row) {
                    return number_format($row->sum, 2, '.', ''); 
                })                
                ->addColumn('quantity', function ($row) {
                    return $row->quantitySum;
                })
                ->setRowClass(function ($row) {
                    return 'text-center';
                })
                ->with('totalCollectedSum', $totalCollectedSum)
                ->rawColumns(['barcode'])
                ->make(true);
        }

        return view('admin.report.dailySalesReportByItem'); // Adjust this view as necessary
    }

    public function getinvoiceListHistoryAjax(Request $request){

        $barcodeId = $request->barcode_id;
        $fromDate = $request->fromDate;
        $toDate = $request->toDate;

        // $invoices = SalesDetailsModel::where('soft_delete', 0)
        //                     ->where('barcode_id', $request->barcode_id)
        //                     ->get();

        $invoices = SalesDetailsModel::where('barcode_id', $barcodeId)
                            ->where('soft_delete',0)
                            ->with(['sales'])
                                ->whereHas('sales', function($q)use($fromDate,$toDate){
                                    $q->where('status', 1)
                                        // ->whereDate('invoice_date', '>=', $fromDate)
                                        // ->whereDate('invoice_date', '<=', $toDate)
                                        ->whereDate('completed_at', '>=', $fromDate)
                                        ->whereDate('completed_at', '<=', $toDate)
                                        ->where('is_cancelled',0)
                                        ->where('is_due_paid',1);
                                })->get();

        return response()->json($invoices, 200);
    }

//    public function viewCountNetProfitReportAjax(Request $request)
//    {
//        $fromDate  = $request->fromDate;
//        $toDate    = $request->toDate;
//
//        $orderDetails = PaymentCollectionModel::where('soft_delete',0)
//            ->whereDate('updated_at', '>=', $fromDate)
//            ->whereDate('updated_at', '<=', $toDate)
//            ->whereRaw('invoice_amount = total_amount')
//            ->with(['order'])
//            ->get();
//
//        $totalProfit = 0;
//        foreach ($orderDetails as $detail)
//        {
//            $costPrice = $detail->order->total_cost_price()->first()['total'];
//            $profit = $detail->invoice_amount - $costPrice;
//            $totalProfit += $profit;
//        }
//
//        $totalFunds = FundInsert::where('soft_delete',0)
//            ->whereDate('created_at', '>=', $fromDate)
//            ->whereDate('created_at', '<=', $toDate)
//            ->sum('amount');
//
//        $totalCostInserts = CostInsert::where('soft_delete',0)
//            ->whereDate('created_at', '>=', $fromDate)
//            ->whereDate('created_at', '<=', $toDate)
//            ->sum('amount');
//
//        $netProfits = ($totalProfit + $totalFunds) - $totalCostInserts;
//
//        return response()->json([
//            'totalProfit' => $totalProfit,
//            'totalFunds' => $totalFunds,
//            'totalCostInserts' => $totalCostInserts,
//            'netProfits' => $netProfits
//        ]);
//    }

    public function viewCountNetProfitReportAjax(Request $request)
    {
        $fromDate  = $request->fromDate;
        $toDate    = $request->toDate;

        $salesDetails = SalesModel::where('status', 1)
            ->whereDate('completed_at', '>=', $fromDate)
            ->whereDate('completed_at', '<=', $toDate)
            ->where('is_cancelled',0)
            ->where('is_due_paid',1)
            ->with(['total_price','total_cost_price','order'])
            ->get();

        $totalProfit = 0;
        foreach ($salesDetails as $detail)
        {
            $cost     = $detail->total_cost_price[0]->totalCost;
            $sale     = $detail->total_price[0]->total;
            $shipping = $detail->is_shipment_charge_applied;
            $discount = $detail->discount_amount;
            $profit   = ($sale - $cost)+$shipping-$discount;
            $totalProfit += $profit;
        }

        $totalFunds = FundInsert::where('soft_delete',0)
            ->whereDate('date', '>=', $fromDate)
            ->whereDate('date', '<=', $toDate)
            ->sum('amount');

        $totalCostInserts = CostInsert::where('soft_delete',0)
            ->whereDate('date', '>=', $fromDate)
            ->whereDate('date', '<=', $toDate)
            ->sum('amount');

        $netProfits = ($totalProfit + $totalFunds) - $totalCostInserts;

        return response()->json([
            'totalProfit' => $totalProfit,
            'totalFunds' => $totalFunds,
            'totalCostInserts' => $totalCostInserts,
            'netProfits' => $netProfits
        ]);
    }

//    public function netProfitOrdersDataReportAjax(Request $request)
//    {
//        $fromDate  = $request->fromDate;
//        $toDate    = $request->toDate;
//        $orderDetails = PaymentCollectionModel::where('soft_delete',0)
//            ->whereDate('updated_at', '>=', $fromDate)
//            ->whereDate('updated_at', '<=', $toDate)
//            ->whereRaw('invoice_amount = total_amount')
//            ->with(['order'])
//            ->get();
//
//        return view('admin.report.netProfitOrdersDataReportAjax', ['orderDetails' => $orderDetails]);
//    }

    public function netProfitOrdersDataReportAjax(Request $request)
    {
        $fromDate  = $request->fromDate;
        $toDate    = $request->toDate;

        $salesDetails = SalesModel::where('status', 1)
            ->whereDate('completed_at', '>=', $fromDate)
            ->whereDate('completed_at', '<=', $toDate)
            ->where('is_cancelled',0)
            ->where('is_due_paid',1)
            ->with(['total_price','total_cost_price','order'])
            ->get();

        return view('admin.report.netProfitOrdersDataReportAjax', ['salesDetails' => $salesDetails]);
    }

    public function netProfitFundsDataReportAjax(Request $request)
    {
        $fromDate  = $request->fromDate;
        $toDate    = $request->toDate;

        $fundDetails = FundInsert::where('soft_delete',0)
            ->whereDate('date', '>=', $fromDate)
            ->whereDate('date', '<=', $toDate)
            ->get();

        return view('admin.report.netProfitFundsDataReportAjax', ['fundDetails'=>$fundDetails]);
    }

    public function netProfitCostsDataReportAjax(Request $request)
    {
        $fromDate  = $request->fromDate;
        $toDate    = $request->toDate;

        $costDetails = CostInsert::where('soft_delete',0)
            ->whereDate('date', '>=', $fromDate)
            ->whereDate('date', '<=', $toDate)
            ->get();

        return view('admin.report.netProfitCostsDataReportAjax', ['costDetails'=>$costDetails]);
    }

    public function profitLossReportAjax(Request $request)
    {
        $fromDate  = $request->fromDate ?? now()->startOfMonth()->toDateString();
        $toDate    = $request->toDate ?? now()->endOfMonth()->toDateString();

        $query = SalesModel::where('status', 1)
            ->whereDate('completed_at', '>=', $fromDate)
            ->whereDate('completed_at', '<=', $toDate)
            ->where('is_cancelled',0)
            ->where('is_due_paid',1)
            ->with(['total_price','total_cost_price','order'])
            ->orderBy('completed_at', 'DESC');


        // Aggregate totals
        $totals = $query->get()->reduce(function ($carry, $detail) {
            $cost = $detail->total_cost_price[0]->totalCost ?? 0;
            $sale = $detail->total_price[0]->total ?? 0;
            $shipping = $detail->is_shipment_charge_applied ?? 0;
            $discount = $detail->discount_amount ?? 0;
            $profit = $sale - $cost + $shipping - $discount;

            return [
                'totalCost' => $carry['totalCost'] + $cost,
                'totalSale' => $carry['totalSale'] + $sale,
                'totalShipping' => $carry['totalShipping'] + $shipping,
                'totalDiscount' => $carry['totalDiscount'] + $discount,
                'totalProfit' => $carry['totalProfit'] + $profit,
            ];
        }, ['totalCost' => 0, 'totalSale' => 0, 'totalShipping' => 0, 'totalDiscount' => 0, 'totalProfit' => 0]);

        // Fetch data for DataTable
        $dataTable = DataTables::of($query)
        ->addIndexColumn()
        ->addColumn('completed_at', function ($row) {
            return Carbon::parse($row->completed_at)->format('Y-m-d');  // Ensure Carbon is used for formatting
        })
        ->addColumn('sale', function ($row) {
            return number_format($row->total_price[0]->total, 2);
        })
        ->addColumn('cost', function ($row) {
            return number_format($row->total_cost_price[0]->totalCost, 2);
        })
        ->addColumn('shipping', function ($row) {
            return number_format($row->is_shipment_charge_applied, 2);
        })
        ->addColumn('discount', function ($row) {
            return number_format($row->discount_amount, 2);
        })
        ->addColumn('profit', function ($row) {
            $sale = $row->total_price[0]->total;
            $cost = $row->total_cost_price[0]->totalCost;
            $shipping = $row->is_shipment_charge_applied;
            $discount = $row->discount_amount;
            $profit = ($sale - $cost) + $shipping - $discount;

            return number_format($profit, 2);
        })
        ->addColumn('invoice_button', function ($row) {
            $orderId = $row->order_id;
            $deliveryType = $row->order->delivery_type;
            
            // Generate the invoice button based on delivery type
            if ($deliveryType == 'delivery' || $deliveryType == 'pickup') {
                return '<a onclick="invoiceModal(' . @$orderId . ')" class="btn badge badge-primary" style="padding: 5px 10px; color: #fff; cursor: pointer;" data-toggle="tooltip" title="Invoice"> #0101' . $orderId . '</a>';
            } else {
                return '<a onclick="invoiceModal(' . @$orderId . ')" class="btn badge badge-primary" style="padding: 5px 10px; color: #fff; cursor: pointer;" data-toggle="tooltip" title="Invoice"> #0202' . $orderId . '</a>';
            }
        })
        ->rawColumns(['invoice_button'])
        ->make(true);

        // Aggregate totals
        $subTotals = $query->get()->reduce(function ($carry, $detail) {
            $cost = $detail->total_cost_price[0]->totalCost ?? 0;
            $sale = $detail->total_price[0]->total ?? 0;
            $shipping = $detail->is_shipment_charge_applied ?? 0;
            $discount = $detail->discount_amount ?? 0;
            $profit = $sale - $cost + $shipping - $discount;

            return [
                'subTotalCost' => $carry['subTotalCost'] + $cost,
                'subTotalSale' => $carry['subTotalSale'] + $sale,
                'subTotalShipping' => $carry['subTotalShipping'] + $shipping,
                'subTotalDiscount' => $carry['subTotalDiscount'] + $discount,
                'subTotalProfit' => $carry['subTotalProfit'] + $profit,
            ];
        }, ['subTotalCost' => 0, 'subTotalSale' => 0, 'subTotalShipping' => 0, 'subTotalDiscount' => 0, 'subTotalProfit' => 0]);

        // Add totals to the DataTable response
        $dataTable = $dataTable->getData();
        $dataTable->totals = $totals;
        $dataTable->subTotals = $subTotals;

        return response()->json($dataTable);
    }

    public function dueSalesReportAjax(Request $request)
    {
        $fromDate  = $request->fromDate;
        $toDate    = $request->toDate;

        $dueSalesDetails = SalesModel::where('payment_due','>', 0)
                                        ->where('is_due_paid','0')
                                        ->where('is_cancelled',0)
                                        ->whereDate('created_at', '>=', $fromDate)
                                        ->whereDate('created_at', '<=', $toDate)
                                        ->get();

        return view('admin.report.dueSalesReportAjax', ['dueSalesDetails' => $dueSalesDetails]);
    }

    public function cashWithdrawalReportAjax(Request $request)
    {
        $fromDate  = $request->fromDate;
        $toDate    = $request->toDate;

        $cashWithdrawalDetails = CashWithDrawModel::whereDate('created_at', '>=', $fromDate)
                                                    ->whereDate('created_at', '<=', $toDate)
                                                    ->get();



        return view('admin.report.cashWithdrawalReportAjax', ['cashWithdrawalDetails' => $cashWithdrawalDetails]);
    }

    //Just a test
    public function dailyPurchaseReportAjax(Request $request)
    {
        $fromDate = $request->fromDate;
        $toDate = $request->toDate;


        $purchases = PurchaseModel::where('soft_delete', 0)
                                ->whereDate('purchase_date', '>=', $fromDate)
                                ->whereDate('purchase_date', '<=', $toDate)
                                ->with('vendor')
                                ->get();



        return view('admin.report.dailyPurchaseReportAjax', ['purchases' => $purchases]);
    }

    public function collectionReportAjax(Request $request)
    {
        $fromDate = $request->fromDate;
        $toDate = $request->toDate;

        $collections = OrderModel::where('is_approve', 1)
                                ->where('is_rejected', 0)
                                ->where('shipment_assigned', 1)
                                ->where('is_shipment', 1)
                                ->where('is_payment', 0)
                                ->where('soft_delete', 0)
                                ->whereDate('created_at', '>=', $fromDate)
                                ->whereDate('created_at', '<=', $toDate)
                                ->with('shipment')
                                ->with('total_price')
                                ->orderBy('id', 'DESC')->get();

        // $collections = OrderModel::where('is_approve', 1)
        //     ->where('is_shipment', 1)
        //     ->where('is_payment', 1)
        //     ->where('soft_delete', 0)
        //     ->whereDate('created_at', '>=', $fromDate)
        //     ->whereDate('created_at', '<=', $toDate)
        //     ->get();

        return view('admin.report.collectionReportAjax', ['collections' => $collections]);
    }
    /**
     * * * * * * * * * * * * * * * *
     * NEW - end
     * * * * * * * * * * * * * * * *
     */

    public function collectedPaymentOrdersAjax(Request $request)
    {

        $fromDate = $request->fromDate;
        $toDate = $request->toDate;

        $deliveryCharge = DeliveryChargeModel::select('amount')->where('name', 'shippingcharge')->first();
        $orders = OrderModel::where('is_payment', 1)->where('status', 1);

        if($fromDate){
            $orders =   $orders->whereDate('created_at', '>=', $fromDate);
        }

        if($toDate){
            $orders =   $orders->whereDate('created_at', '<=', $toDate);

        }

        if($request->payment_method != "ALL"){
            $orders =   $orders->whereHas('payment', function($q) use ($request){
                $q->where('payment_method_id', $request->payment_method);
            });

        }
        $orders =   $orders->get();

        return view('admin.report.collectedPaymentOrdersAjax', ['orders' => $orders, 'deliveryCharge' => $deliveryCharge]);
    }

    public function pendingOrderReportAjax(Request $request)
    {
        $fromDate = $request->fromDate;
        $toDate = $request->toDate;

        // $orders = OrderModel::where(function ($q) {
        //         $q->where('is_approve', 0)
        //         ->orWhere('is_shipment', 0);
        // })->where('status', 0)->where('soft_delete',0)->whereDate('created_at', '>=', $fromDate)->whereDate('created_at', '<=', $toDate)->get();

        $orders = OrderModel::where('is_shipment', 0)
                                ->where('status',0)
                                ->where('is_rejected', 0)
                                ->where('soft_delete',0)
                                ->whereDate('created_at', '>=', $fromDate)
                                ->whereDate('created_at', '<=', $toDate)
                                ->get();

        return view('admin.report.pendingOrderReportAjax', ['orders' => $orders]);
    }

    /**
     * === Helper Funtions ===
     */

    public function getDeliveryTeam()
    {
        // $deliveryTeam = UserRolesModel::where('role_id', DeliveryTeamRoleId)
        $deliveryTeam = UserRolesModel::where('role_id', env('DELIVERYMAN_ROLE'))
            ->where('soft_delete', 0)
            ->with('user')
            ->get();
        return $deliveryTeam;
    }

    /**
     * This function is return website viewer report by date
     */
    public function websiteVisitorReportAjax(Request $request)
    {
        $fromDate = $request->fromDate;
        $toDate = $request->toDate;
        $visitors = SiteVisit::whereDate('visited_at', '>=', $fromDate)
            ->whereDate('visited_at', '<=', $toDate)
            ->get();

        return view('admin.report.websiteVisitorReportAjax', ['visitors' => $visitors]);
    }

    /**
    * This function is returns expense report by date, category and subcategory
    */
    public function expenseReportAjax(Request $request)
    {
        // dd($request->all());
        
        $fromDate   = $request->_fromDate;
        $toDate     = $request->_toDate;
        $cat        = $request->_cat;
        $subCat     = $request->_subCat;
        

        $costs = CostInsert::where('soft_delete',0)
                            ->whereDate('date', '>=', $fromDate)
                            ->whereDate('date', '<=', $toDate);
                            
        
        if($cat == "null"){
            $costs = $costs->get();

        }else if($subCat == "null"){
            $costs = $costs->where('category_id', $cat)->get();

        }else{
            $costs = $costs->where('category_id', $cat)->where('subcategory_id', $subCat)->get();
            // dd($costs);

        }
        // dd($costs);
        
        // return view('admin.report.expenseReportAjax', ['costs' => $costs]);
        $totalAmount = $costs->sum('amount');
        return DataTables::of($costs)
        ->addColumn('data_category', function($cost){
            return $cost->category->name;
        })
        ->addColumn('data_subcategory', function($cost){
            return $cost->subcategory->name;
        })
        ->addColumn('data_description', function($cost){
            $description= '<div class="description"
            <span class="description-popover" data-toggle="popover" title="Full Description"
                    data-content="'. $cost->description .'" data-trigger="hover"
                    class="truncated-description"> '. \Illuminate\Support\Str::limit($cost->description, 30) .'</span>';
            
            if (strlen($cost->description) > 30) {
                
                $description.='<a href="#" class="see-more" data-toggle="modal"
                data-target="#descriptionModal'. $cost->id .'">See More</a>
                 <div class="modal fade" id="descriptionModal'. $cost->id .'" tabindex="-1" role="dialog">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Full Description</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body" style="white-space: normal;">'. $cost->description .'</div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>';
            
                
            }
            $description .= '</div>';  
            return $description;
        })
        ->with('totalAmount', $totalAmount)
        ->rawColumns(['data_category','data_subcategory','data_description'])
        ->make(true);
    }

    /**
    * This function is returns fund report by date, category and subcategory
    */
    public function fundReportAjax(Request $request)
    {
        $fromDate   = $request->fromDate;
        $toDate     = $request->toDate;
        $cat        = $request->cat;
        $subCat     = $request->subCat;

        $funds = FundInsert::where('soft_delete',0)
                            ->whereDate('date', '>=', $fromDate)
                            ->whereDate('date', '<=', $toDate);
        if($cat == "null"){
            $funds = $funds->get();

        }else if($subCat == "null"){
            $funds = $funds->where('category_id', $cat)->get();

        }else{
            $funds = $funds->where('category_id', $cat)->where('subcategory_id', $subCat)->get();

        }
        return view('admin.report.fundReportAjax', ['funds' => $funds]);
    }


    /**
    * This function is returns fund report by date, category and subcategory
    */
    public function endingBalanceReportAjax(Request $request)
    {
        $fromDate   = $request->fromDate;
        $toDate     = $request->toDate;

        $endingBalances = CashStoragePlatform::where('soft_delete',0)
                            ->whereDate('created_at', '>=', $fromDate)
                            ->whereDate('created_at', '<=', $toDate)
                            ->get();

        return view('admin.report.endingBalanceReportAjax', ['endingBalances' => $endingBalances]);
    }
    


}
