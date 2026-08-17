<?php

namespace App\Http\Controllers;
use App\CostInsert\CostInsert;
use Illuminate\Http\Request;
use App\OrderModel;
use App\item\ItemModel;
use App\vendor\VendorModel;
use App\delivery\deliveryTeamModel;
use App\category\CategoryModel;
use App\shipment\ShipmentModel;
use App\PaymentCollectionModel;
use App\CashWithdraw\CashWithDrawModel;
use App\AdvancePayment\AdvancePayment;
use Illuminate\Support\Facades\DB;
use App\purchase\PurchaseDetailsModel;
use App\purchase\PurchaseModel;
use App\purchase\PurchaseItemBarcode;
use App\sales\SalesModel;
use App\sales\SalesDetailsModel;
use App\SalesDuePayment\SalesDuePayment;
use App\CostManagement\CashInsert;
use App\stock\StockModel;
use App\Reinvestment\Reinvestment;
use App\FundInsert\FundInsert;
use App\purchase\PurchaseDraft;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $orderCount         = OrderModel::where('soft_delete', 0)->where('delivery_type','!=','shop')->count();
        $saleCount          = OrderModel::where('soft_delete', 0)->where('delivery_type','shop')->count();
        $itemCount          = PurchaseDetailsModel::where('soft_delete', 0)->distinct()->count('item_id');

        // $totalPurchase   = PurchaseDetailsModel::where('soft_delete', 0)->selectRaw('sum(cost_price * quantity) as total')->first()['total'];
        $totalPurchase      = PurchaseModel::where('soft_delete', 0)->sum('total_amount')
                                + PurchaseDraft::where(['soft_delete' => 0, 'is_purchased' => 0])->sum('amount');

        $vendorCount        = VendorModel::where('soft_delete', 0)->count();
        $deliveryTeamCount  = deliveryTeamModel::where('soft_delete', 0)->count();

        /* paymentcollectionmodel total amount holds every completed order's, And Collected payment at sale which gets updated every time due is paid.
            AdvancePayment holds the amount received during booking.
        */
        $paymentCollection   = PaymentCollectionModel::where('soft_delete', 0)->sum('total_amount')
                                + AdvancePayment::where('soft_delete', 0)->sum('paid_amount')
                                + FundInsert::where('soft_delete',0)->sum('amount')
                                + Reinvestment::where('soft_delete',0)->sum('amount');

        /* In accounts module, costs are inserted */
        $insertedCost = CostInsert::where('soft_delete',SOFT_DELETE_NO)->sum('amount');

        $outsourceCosts = SalesDetailsModel::select("*")
                                    ->selectRaw('sum(cost_price*quantity) as sum')
                                    ->groupBy('sales_id')
                                    ->where('soft_delete',0)
                                    ->with(['sales'])
                                    ->whereHas('sales', function($q){
                                        $q->where('company_name', '=', 'outsource')
                                            ->where('is_cancelled',0);
                                            // ->where('is_due_paid',1);
                                    })->orderBy('id', 'DESC')->get();

        $totalOutsourcedCost = $outsourceCosts->sum('sum');
        
        /* Deduct inserted costs, total purchased costs, total outsourced costs from total cash */
        // $totalCashCollected  = $paymentCollection - ($insertedCost + $totalPurchase);
        $totalCashCollected  = $paymentCollection - ($insertedCost + $totalPurchase + $totalOutsourcedCost);



        // $paymentCollection   = PaymentCollectionModel::where('soft_delete', 0)->sum('total_amount')
        // + AdvancePayment::where('soft_delete', 0)->sum('paid_amount')
        // + CashInsert::where('soft_delete', 0)->sum('cash_amount')
        // + FundInsert::where('soft_delete',0)->sum('amount')
        // + Reinvestment::where('soft_delete',0)->sum('amount');

        // $withdraw     = CashWithDrawModel::sum('amount');
        // $insertedCost = CostInsert::where('is_approved_by_all',IS_APPROVED)->where('soft_delete',SOFT_DELETE_NO)->sum('amount');
        // $totalCashCollected  = $paymentCollection - $withdraw;




        $categoryCount       = CategoryModel::where('soft_delete', 0)->count();
        $cancelledOrderCount = OrderModel::where('is_rejected', 1)->where('delivery_type','!=','shop')->count();
        $pendingOrderCount   = OrderModel::where('is_approve', 0)->where('delivery_type','!=','shop')->count();
        $totalStockPrice     = StockModel::where('soft_delete',0)->selectRaw('sum(cost_price * quantity) as total')->first()['total'];
        $totalDeliveryCharge = SalesModel::where('soft_delete',0)->selectRaw('sum(is_shipment_charge_applied) as SC')->first()['SC'];


        $completedOrderCount = OrderModel::where('is_approve', 1)
            ->where('is_rejected', 0)
            ->where('shipment_assigned', 1)
            ->where('status', 1)
            ->where('is_shipment', 1)
            ->where('is_payment', 1)
            ->where('delivery_type','!=','shop')
            ->count();

        $averageDeliveryTimes   =  DB::select(DB::raw('SELECT AVG(difference) As difference,created_at from (select TIMESTAMPDIFF(Hour,orders.created_at,shipment.completed_at)AS difference,orders.id,date(orders.created_at) AS created_at from `orders` inner join `shipment` on `orders`.`id` = `shipment`.`order_id`) AS t1  GROUP BY created_at'));
        $averageDeliveryTimes   =  json_encode($averageDeliveryTimes);
        $total_site_visits      =  DB::table('site_visits')->count(DB::raw('DISTINCT visitor_ip'));
        $shipmentTimes          =  ShipmentModel::select(DB::raw('AVG(TIMESTAMPDIFF(Hour,created_at,completed_at)) As difference,date(created_at) as created'))->where(DB::raw('TIMESTAMPDIFF(Hour,created_at,completed_at)'),'>',0)->groupBy(DB::raw('date(created_at)'))->get()->toArray();

        $shipmentTimes = json_encode($shipmentTimes);


        /**
         * Dashboard cash card details data
         */
        // $bookingAndsales = DB::select("(SELECT pc.`id`,CASE WHEN ord.delivery_type = 'shop' THEN CONCAT('#0202',pc.`order_id`) ELSE CONCAT('#0101',pc.`order_id`) END AS order_id, pc.`total_amount` AS amount,DATE(pc.`updated_at`) AS pay_date FROM `payment_collection` AS pc RIGHT JOIN `orders` As ord ON pc.order_id = ord.id WHERE pc.`soft_delete` =0 AND pc.`total_amount` > 0) UNION ALL (SELECT `id`,CONCAT('#0303',`booking_id`) AS order_id,`paid_amount` AS amount,DATE(`updated_at`) AS pay_date FROM `advance_payments` WHERE `soft_delete` =0)");
        $sales = DB::select("SELECT pc.`id`, ord.id AS pk,CASE WHEN ord.delivery_type = 'shop' THEN CONCAT('#0202',pc.`order_id`) ELSE CONCAT('#0101',pc.`order_id`) END AS order_id, pc.`total_amount` AS amount,DATE(pc.`created_at`) AS pay_date FROM `payment_collection` AS pc RIGHT JOIN `orders` As ord ON pc.order_id = ord.id WHERE pc.`soft_delete` =0 AND pc.`total_amount` > 0 ORDER BY pk DESC");
        $bookings = DB::select("SELECT `id`,CONCAT('#0303',`booking_id`) AS booking_id,`paid_amount` AS amount,DATE(`created_at`) AS pay_date FROM `advance_payments` WHERE `soft_delete` =0 ORDER BY `advance_payments`.`id` DESC");
        $funds = FundInsert::where('soft_delete',0)->orderBy('id', 'DESC')->get();
        $reinvestments = Reinvestment::where('soft_delete',0)->orderBy('id', 'DESC')->get();
        $costs = CostInsert::where('soft_delete',0)->orderBy('id', 'DESC')->get();
        $purchases = PurchaseModel::where('soft_delete', 0)->orderBy('id', 'DESC')->get();
        $drafts = PurchaseDraft::where(['soft_delete' => 0, 'is_purchased' => 0])->orderBy('id', 'DESC')->get();


        $data = [
            'orderCount'           => $orderCount,
            'itemCount'            => $itemCount,
            'totalPurchase'        => $totalPurchase,
            'vendorCount'          => $vendorCount,
            'deliveryTeamCount'    => $deliveryTeamCount,
            'categoryCount'        => $categoryCount,
            'cancelledOrderCount'  => $cancelledOrderCount,
            'pendingOrderCount'    => $pendingOrderCount,
            'completedOrderCount'  => $completedOrderCount,
            'averageDeliveryTimes' => $averageDeliveryTimes,
            'total_site_visits'    => $total_site_visits,
            'shipmentTimes'        => $shipmentTimes,
            'totalCashCollected'   => $totalCashCollected,
            'totalStockPrice'      => $totalStockPrice,
            'saleCount'            => $saleCount,
            'totalDeliveryCharge'  => $totalDeliveryCharge,
            'sales'                => $sales,
            'bookings'             => $bookings,
            'funds'                => $funds,
            'reinvestments'        => $reinvestments,
            'costs'                => $costs,
            'purchases'            => $purchases,
            'drafts'               => $drafts,
            'outsourceCosts'       => $outsourceCosts
        ];

        return view('admin.dashboardView', $data);
    }


}
