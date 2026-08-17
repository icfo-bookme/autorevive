<?php

namespace App\Http\Controllers\payment;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\OrderModel;
use App\OrderDetailsModel;
use App\PaymentMethodModel;
use App\PaymentCollectionModel;
use App\delivery\deliveryTeamModel;
use App\shipment\ShipmentModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use DB;
use App\sales\SalesDetailsModel;
use App\sales\SalesModel;
use App\deliveryCharge\DeliveryChargeModel;
use App\User;
use App\CashWithdraw\CashWithDrawModel;
use App\SalesDuePayment\SalesDuePayment;


class PaymentController extends Controller
{
    //Single comment
    //Another Comment
    //One another comment
    //Another comment added

    /**
     *
     * @var edited by - Usama
     * @var changes list
     *              - added this to the query
     *                          ->where('soft_delete', 0)
     */
    public function collectPayment(){
        $orders = OrderModel::where('is_approve',1)
                              ->where('is_rejected',0)
                              ->where('shipment_assigned',1)
                              ->where('is_shipment',1)
                              ->where('is_payment',0)
                              ->where('soft_delete', 0)
                              ->with('shipment')
                              ->with('total_price')
                              ->orderBy('id', 'DESC')->get();
        // ->where('soft_delete', 0) - is not added
        $shippingCharge =  DeliveryChargeModel::where('name','shippingcharge')->where('soft_delete', 0)->first();

        $data =[
            'orders'           => $orders,
            'shippingCharge'   => $shippingCharge
        ];

        return view('admin.payment.paymentCollection',$data);
    }




    public function paymentCollectionDetails($id){
        $order          = OrderModel::findOrFail($id);
        $orderDetails   = OrderDetailsModel::where('order_id',$id)->where('soft_delete',0)->get();

        $shippingCharge = DeliveryChargeModel::where('name','shippingcharge')->where('soft_delete', 0)->first();

        $paymentMethods = PaymentMethodModel::all();


        $data =[
            'order'             => $order,
            'orderDetails'      => $orderDetails,
            'shippingCharge'    => $shippingCharge,
            'paymentMethods'    => $paymentMethods
        ];

        return view('admin.payment.paymentCollectionDetails',$data);
    }



    public function paymentCollectedAjax(Request $request){
        $userName        = Auth::user()->first_name;

        $order        = OrderModel::findOrFail($request->id);
        $order->status      =  1;
        $order->is_payment  =  1;
        $order->payment_collected_at = date('Y-m-d H:i:s');
        $order->update();

        SalesModel::where(['order_id' => $request->id, 'created_by' => 'website'])->update(['invoice_date' => date('Y-m-d H:i:s')]);

        // payment method insert into payment_collection table //
        // $shippingCharge  = DeliveryChargeModel::where('name', 'shippingcharge')->where('soft_delete', 0)->first();
        $shippingCharge  = $order->is_shipment_charge_applied;
        $discount = $order->discount_amount;

        if ($order->delivery_type == "pickup") {
            $totalAmount = $order->total_price[0]->total;
        } else {
            $totalAmount = $order->total_price[0]->total + $shippingCharge - $discount;
        }
        

        $insertA = [];
        $insertA['order_id']                = $order->id;
        $insertA['payment_method_id']       = $request->payment_method;
        $insertA['invoice_amount']          = $order->total_price[0]->total;
        $insertA['total_amount']            = $totalAmount;
        $insertA['payment_collected_by']    = $userName;
        $insert = PaymentCollectionModel::create($insertA);


        return response()->json('success');



    }


    /**
     *
     * @var edited by - Usama
     * @var changes
     *              - made the query multiline (previously it was single lined)
     *              - added this to the query
     *                          ->where('soft_delete', 0)
     *              - removed this from the query
     *                          ->where('status',1)
     */
    public function completedOrder(){
        $orders = OrderModel::where('created_by','!=', 'shop')
                            ->orWhere('created_by','=',null)
                            ->where('delivery_type', '!=', 'shop')
                            ->where('is_approve',1)
                            ->where('is_rejected',0)
                            ->where('shipment_assigned',1)
                            ->where('is_shipment',1)
                            ->where('soft_delete', 0)
                            ->where('is_payment',1)
                            ->where('is_due_paid',1)
                            ->orderBy('id', 'DESC')
                            ->get();
        $data =[
            'orders' => $orders
        ];

        return view('admin.payment.completedOrderView',$data);
    }



    public function completedOrderDetailsView($id){

        $order          =  OrderModel::findOrFail($id);
        $orderDetails   =  OrderDetailsModel::where('order_id',$id)->where('soft_delete',0)->get();
        $shippingCharge =  DeliveryChargeModel::where('name','shippingcharge')->where('soft_delete', 0)->first();
        $dueAmount      =  SalesModel::where('order_id', $id)->select('is_cancelled','payment_due','id')->first();
        $totalPaid      =  SalesDuePayment::where('sales_id',$dueAmount->id)->sum('paid_amount');
        $paymentMethods =  PaymentMethodModel::all();
        $paymentDetails =  PaymentCollectionModel::where('order_id', $id)->where('soft_delete',0)->latest()->first();

        $data =[
            'order'             => $order,
            'orderDetails'      => $orderDetails,
            'shippingCharge'    => $shippingCharge,
            'totalPaid'         => $totalPaid,
            'dueAmount'         => $dueAmount->payment_due,
            'isCancelled'       => $dueAmount->is_cancelled,
            'paymentMethods'    => $paymentMethods,
            'paymentDetails'    => $paymentDetails,


        ];

        return view('admin.payment.completedOrderDetailsView',$data);

    }



    public function cashWithdraw(){

        $users  = User::WhereHas('roles', function ($q)  {
             $q->where('role_id',8);
        })->get();

        $withdrawls = CashWithDrawModel::get();

        $data = [
          'users'       => $users,
          'withdrawls'  => $withdrawls
        ];




        return view('admin.cashwithdraw.cashWithdraw',$data);

    }



    public function cashWithDrawInsert(Request $request){



        $attributeNames = array(
            'date'             => $request->date,

            'description'      => $request->description,
            'amount'           => $request->withdraw_amount,
            'withdraw_by'      => $request->username

        );


        //return dd($attributeNames);

        //validating the attributes
        $validator = Validator::make($attributeNames, [
            'date' => 'required',
            'description' => 'required',
            'amount' => 'required',
            'withdraw_by' => 'required'
        ]);
        try {
            CashWithDrawModel::create($attributeNames);

            return response()->json("Success");
        } catch (\Exception $exception) {
            return response()->json(array('dbErrors' => $exception->getMessage()));
        }





    }










}
