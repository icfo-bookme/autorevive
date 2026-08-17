<?php

namespace App\Http\Controllers\order;

use App\Helper\SmsHelper;
use App\purchase\PurchaseItemBarcode;
use Illuminate\Support\Facades\DB;
use App\OrderModel;
use App\Booking\Booking;
use App\BookingDetail\BookingDetail;
use App\AdvancePayment\AdvancePayment;
use App\reasonModel;
use App\item\ItemModel;
use App\sales\SalesModel;
use App\sales\SaleLogModel;
use App\sales\SaleLogDetailModel;
use App\sales\SalesNewLog;
use App\sales\SalesDetailNewLog;
use App\stock\StockModel;
use App\OrderDetailsModel;
use App\PaymentMethodModel;
use App\Mail\OrderApproved;
use App\Mail\OrderShippedMail;
use App\Mail\OrderUpdateMail;
use Illuminate\Http\Request;
use App\admin\UserRolesModel;
use App\customer\CustomerModel;
use App\shipment\ShipmentModel;
use App\sales\SalesDetailsModel;
use App\delivery\deliveryTeamModel;
use App\delivery\TeamLeader;
use App\PaymentCollectionModel;
use App\CustomersReferralsDetailsModel;
use App\Mail\OrderConfirmationMail;
use App\Mail\PosSaleMail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use App\deliveryCharge\DeliveryChargeModel;
use App\User;
use App\order\OrderWarningMessage;
use App\Events\ShipmentCompleted;
use App\Events\ShipmentAssigned;
use App\ReferralModel;
use Carbon\Carbon;
use App\shipmentComments;
use App\highlights\HighlightsModel;
use Ramsey\Uuid\Codec\OrderedTimeCodec;
use App\SalesDuePayment\SalesDuePayment;
use App\SalesDuePayment\SalesDuePaymentLog;
use App\pickup\PickupModel;
use App\welcomeCall\WelcomeCallModel;
use App\sale\salesLogData;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Log;
use OrderDetails;
use SalesDetails;
use App\SMS\SmsSetting;
use App\SMS\SmsLog;
use App\Http\Helpers\UtilityHelper;


class OrderController extends Controller
{
    const DELIVERY_MAN_ROLE_ID = 3;
    const TEAM_LEADER_ROLE_ID = 5;


    /**
     *
     * @internal edited by - Usama
     * @internal changes list
     *              - made the query multiline (previously, it was single lined)
     *              - added this in the query
     *                      ->where('is_rejected', 0)
     */

    //pending order view//
    public function allOrderView()
    {
        $orders = OrderModel::where('is_approve', 0)
            ->where('is_rejected', 0)
            ->where('delivery_type', '!=', 'shop')
            ->orderBy('id', 'DESC')
            ->get();
        $data = [
            'orders' => $orders
        ];
        return view('admin.order.orderView', $data);
    }
    // public function allOrderViewold()
    // {
    //     $orders = OrderModel::where('is_approve', 0)
    //         ->where('is_rejected', 0)
    //         ->where('delivery_type', '!=', 'shop')
    //         ->orderBy('id', 'DESC')
    //         ->get();
    //     $data = [
    //         'orders' => $orders
    //     ];
    //     return view('admin.order.orderViewold', $data);
    // }


    // public function orderDetailsView($id)
    // {
    //     $allProducts = ItemModel::where('soft_delete', 0)->get();

    //     $deliveryMan = UserRolesModel::where('role_id', 3)
    //         ->where('soft_delete', 0)
    //         ->with('user')
    //         ->get();

    //     $order = OrderModel::findOrFail($id);
    //     $orderDetails = OrderDetailsModel::where('order_id', $id)->where('soft_delete', 0)->get();
    //      $shippingCharge = DeliveryChargeModel::where('soft_delete', 0)->where('name', 'shippingcharge')->first();

    //     $teamLeaders = UserRolesModel::where('role_id', self::TEAM_LEADER_ROLE_ID)
    //         ->where('soft_delete', 0)
    //         ->with('user')
    //         ->get();

    //     $data = [
    //         'order' => $order,
    //         'orderDetails' => $orderDetails,
    //         'shippingCharge' => $shippingCharge,
    //         'deliveryMan' => $deliveryMan,
    //         'teamLeaders' => $teamLeaders,
    //         'allProducts' => $allProducts,
    //     ];

    //     return view('admin.order.orderDetailsView', $data);
    // }

    public function orderDetailsView($id)
    {
        $master = PurchaseItemBarcode::where('soft_delete',SOFT_DELETE_NO)->with('item');

        $allProducts = $master->where(function($subQuery){
            $subQuery->whereHas('stock', function ( $query ) {
                $query->where('quantity','>',0);
            });
        })->get();

        $deliveryMan = UserRolesModel::where('role_id', 3)
            ->where('soft_delete', 0)
            ->with('user')
            ->get();

        $order = OrderModel::findOrFail($id);
        $paymentMethods = PaymentMethodModel::all();
        $referrals = ReferralModel::all();
        $bookingData = Booking::where('status', BOOKING__STATUS_READY_TO_DELIVER)->where('status', '!=', BOOKING__STATUS_INACTIVE)->select(['id'])->get();
        $lastInsertedRow = OrderModel::orderBy('id', 'desc')->select(['id'])->first();

        $orderDetails = OrderDetailsModel::where('order_id', $id)->where('soft_delete', 0)->get();
        $shippingCharge = DeliveryChargeModel::where('soft_delete', 0)->where('name', 'shippingcharge')->first();

        // $teamLeaders = UserRolesModel::where('role_id', self::TEAM_LEADER_ROLE_ID)
        $teamLeaders = UserRolesModel::where('role_id', env('TEAMLEADER_ROLE'))
            ->where('soft_delete', 0)
            ->with('user')
            ->get();

        if(!$lastInsertedRow){
            $lastInsertedRow['id'] = 0;
        }

        $data = [
            'order' => $order,
            'orderDetails' => $orderDetails,
            'shippingCharge' => $shippingCharge,
            'deliveryMan' => $deliveryMan,
            'teamLeaders' => $teamLeaders,
            'paymentMethods' => $paymentMethods,
            'referrals' => $referrals,
            'bookingData' => $bookingData,
            'lastInsertedRow' => $lastInsertedRow,
            'allProducts' => $allProducts,
        ];

        return view('admin.order.orderDetailsView', $data);
    }


    public function allOngoingOrderView()
    {
        $orders = OrderModel::where('is_shipment', 0)
                                ->where('status', 0)
                                ->where('is_rejected', 0)
                                ->where('delivery_type', '!=', 'shop')
                                ->where('soft_delete', 0)
                                ->orderBy('id', 'DESC')
                                ->get();
        $data = [
            'orders' => $orders
        ];
        return view('admin.order.allOngoingOrderView', $data);
    }


    public function orderHistoryView()
    {
        $orders = OrderModel::where('soft_delete', 0)->orderBy('id', 'DESC')->get();
        $data = [
            'orders' => $orders
        ];
        return view('admin.order.orderHistoryView', $data);
    }


    public function orderHistory(Request $request)
    {
        $orders = OrderModel::where('id', $request->id)->with('shipment.user')->first();

        return response()->json(["data" => $orders]);
    }


    public function orderDeadLineWarningSms(Request $request)
    {
        $notifications = OrderWarningMessage::where('init_warning', '<', 2)->get();

        foreach ($notifications as $notification) {

            $remainingTime = (Carbon::parse(($notification->deadline))->diffInHours(Carbon::now()));

            if ($remainingTime >= 0 && $remainingTime <= 3) {

                $message = "Dear Employee, your task invoice no " . sprintf("%04s", $notification->order_id) . " is close to the deadline. Your remaining time is almost " . $remainingTime . " hour";

                $number = $notification->user->phone;

                $message = urlencode($message);

                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, "http://sms.sslwireless.com/pushapi/dynamic/server.php?user=Technocore&pass=54N182s@&sid=cloudoneEng&sms=$message&msisdn=$number&csmsid=123456789");
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
                $data = curl_exec($ch);
                curl_close($ch);

                $result = OrderWarningMessage::where('id', $notification->id)->update(['init_warning' => $notification->init_warning + 1]);

            }
        }
        return response()->json(["data" => $notifications]);
    }


    public function approvedOrderView()
    {
        $users_roles = UserRolesModel::where('user_id', Auth::user()->id)->where('soft_delete', 0)->pluck('role_id')->toArray();

        if (Auth::user()->id == 1||(in_array(env('MAINTAINER_ROLE'), $users_roles))||(in_array(env('HOP_ROLE'), $users_roles))||(in_array(env('ACCOUNTS_ROLE'), $users_roles))) {
            $orders = OrderModel::where('is_approve', 1)
                ->where('is_rejected', 0)
                ->where('shipment_assigned', 0)
                ->where('delivery_type', '!=', 'shop')
                ->orderBy('id', 'DESC')
                ->get();

            return view('admin.order.approvedOrderView', ['orders' => $orders]);
        }
        //pickup
        // if (Auth::user()->id == 1) {
        //     $orders = OrderModel::where('is_approve', 1)
        //         ->where('is_rejected', 0)
        //         ->where('shipment_assigned', 0)
        //         ->orderBy('id', 'DESC')
        //         ->get();

        //     return view('admin.order.pickupOrderView', ['orders' => $orders]);
        // }

        // if (in_array($this::TEAM_LEADER_ROLE_ID, $users_roles)) {
        if (in_array(env('TEAMLEADER_ROLE'), $users_roles)) {
            $orders = OrderModel::where('is_approve', 1)
                ->where('is_rejected', 0)
                ->where('shipment_assigned', 0)
                ->where('team_leader_id', Auth::user()->id)
                ->orderBy('id', 'DESC')
                ->get();
        // } elseif (in_array($this::DELIVERY_MAN_ROLE_ID, $users_roles)) {
        } elseif (in_array(env('DELIVERYMAN_ROLE'), $users_roles)) {
            $orders = OrderModel::where('is_approve', 1)
                ->where('is_rejected', 0)
                ->where('shipment_assigned', 0)
                ->whereHas('shipment', function ($query) {
                    $query->where('delivery_team_id', Auth::user()->id);
                })
                ->orderBy('id', 'DESC')
                ->get();
        }

        $data = [
            'orders' => $orders
        ];

        return view('admin.order.approvedOrderView', $data);
    }


    public function approvedOrderDetailsView($id)
    {
        $deliveryManRole = 3;
        $order = OrderModel::where('id', $id)->with('shipment')->first();
        $orderDetails = OrderDetailsModel::where('order_id', $id)
            ->where('soft_delete', 0)
            ->get();

        // $deliveryMan = UserRolesModel::where('role_id', self::DELIVERY_MAN_ROLE_ID)
        $deliveryMan = UserRolesModel::where('role_id', env('DELIVERYMAN_ROLE'))
            ->where('soft_delete', 0)
            ->with('user')
            ->get();

        // $teamLeaders = UserRolesModel::where('role_id', self::TEAM_LEADER_ROLE_ID)
        $teamLeaders = UserRolesModel::where('role_id', env('TEAMLEADER_ROLE'))
            ->where('soft_delete', 0)
            ->with('user')
            ->get();

        $shippingCharge = DeliveryChargeModel::where('name', 'shippingcharge')
            ->where('soft_delete', 0)
            ->first();


        $data = [
            'order' => $order,
            'orderDetails' => $orderDetails,
            'deliveryMan' => $deliveryMan,
            'teamLeaders' => $teamLeaders,
            'shippingCharge' => $shippingCharge
        ];

        return view('admin.order.approvedOrderDetailsView', $data);
    }


    public function cancelShipmentAjax(Request $request)
    {
        $order = OrderModel::findOrFail($request->id);
        $order->is_rejected = 1;
        $order->rejected_by = Auth::user()->first_name;
        $order->rejected_at = date("Y-m-d H:i:s");
        $order->update();
        return response()->json('success');
    }



    public function orderApproveAjax(Request $request)
    {
        $attributeNames = array(
            'order_id' => $request->order_id,
            'team_leader_id' => $request->team_leader_id,
            'deadline_date' => $request->date,
            'deadline_time' => $request->date . ' ' . $request->deadlineTime
        );

        $validator = Validator::make($attributeNames, [
            'order_id' => 'required',
            'team_leader_id' => 'required',
            'deadline_date' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'data' => $validator->getMessageBag()->toArray(),
                'status' => 'validation-error',
                'message' => null
            ]);

        } else {
            DB::beginTransaction();
            try {
                $orderDetails = json_decode($request->get('orderDetail'), true);
                $customer_name = $orderDetails['customer_name'];
                $shippingCharge = $orderDetails['shippingChargeApplied'];

                OrderModel::where('id', $request->order_id)->update([
                    'is_approve' => 1,
                    'approved_at' => date('Y-m-d H:i:s'),
                    'approved_by' => Auth::user()->first_name,
                    'team_leader_id' => $request->team_leader_id,
                    'is_shipment_charge_applied' => $shippingCharge,
                    'discount_amount' => $orderDetails['discountAmount'],
                    'remarks' => $request->remarks,
                ]);

                $shipment = ShipmentModel::where('order_id', $request->order_id)->first();
                if ($shipment) {
                    $shipment->update([
                        'deadline_date' => $request->date,
                        'deadline_time' => $request->date . ' ' . $request->deadlineTime,
                        'created_by' => Auth::user()->first_name,
                        'updated_by' => Auth::user()->first_name

                    ]);
                } else {
                    ShipmentModel::create([
                        'order_id' => $request->order_id,
                        'deadline_date' => $request->date,
                        'deadline_time' => $request->date . ' ' . date('H:i', strtotime($request->deadlineTime)),
                        'created_by' => Auth::user()->first_name,
                        'updated_by' => Auth::user()->first_name,
                        'soft_delete' => 0
                    ]);
                }

                //Saving order details
                $this->saveOrderDetails($request, $request->order_id);

                //INSERT INTO highlights TABLE//
                if ($request->highlights == 1) {

                    $Info = new HighlightsModel();
                    $Info->type_id = $request->order_id;
                    $Info->type = "ORDER";
                    $Info->summary = "This order has been highlighted before approval";
                    $Info->created_by = Auth::user()->first_name;
                    $Info->save();
                }

                DB::commit();

                $orderInfo = OrderModel::findOrFail($request->order_id);
                $orderDetailsInfo = OrderDetailsModel::where('order_id', $request->order_id)->where('soft_delete', 0)->get();

                $orderInfo->is_approve = 1;
                $orderInfo->approved_at = date('Y-m-d H:i:s');
                $orderInfo->approved_by = Auth::user()->first_name != null ? Auth::user()->first_name : '';
                $orderInfo->is_shipment_charge_applied = $shippingCharge;
                $orderInfo->discount_amount = $orderDetails['discountAmount'];

                if ($orderInfo->email != null && $orderInfo->email != "") {
                    Mail::to($orderInfo->email)->send(new OrderApproved($orderInfo, $orderDetailsInfo, $shippingCharge));
                }

                // $message = 'Thank you, '.$customer_name.'. We’ve accepted your order and started the delivery process.';

                // $message = str_replace(' ', '%20', $message);
                // $ch = curl_init();
                // curl_setopt($ch, CURLOPT_URL, "http://sms.sslwireless.com/pushapi/dynamic/server.php?user=Technocore&pass=54N182s@&sid=cloudoneEng&sms=$message&msisdn=$number&csmsid=123456789");
                // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                // curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
                // $data = curl_exec($ch);
                // curl_close($ch);

                //SMS (After Approve Order)
                $smsSetting = SmsSetting::where(['type' => 'after_approve_order'])->first();
                if($smsSetting){
                    if($smsSetting['status']){
                        $message = UtilityHelper::personalizeReplace($smsSetting['sms_body'],$orderDetails,$request->order_id);

                        $number = $orderDetails['phone_number'];
                        if($number != null && $number != ''){
                            //Send SMS
                            $sms = new SmsHelper();
                            $response = $sms->singleSms($number,$message);
                            $response = json_decode($response,true);
                            // $smsinfo  = json_encode($response['smsinfo'],true);

                            // SmsLog::create([
                            //     'phone'         => $number,
                            //     'message'       => $message,
                            //     'status'        => $response['status'],
                            //     'status_code'   => $response['status_code'],
                            //     'error_message' => $response['error_message'],
                            //     'smsinfo'       => $smsinfo,
                            //     'created_by'    => auth()->user()->id
                            // ]);
                            if($response['status'] !== 'FAILED'){
                                $smsinfo  = json_encode($response['smsinfo'],true);

                                SmsLog::create([
                                    'phone'         => $number,
                                    'message'       => $message,
                                    'status'        => $response['status'],
                                    'status_code'   => $response['status_code'],
                                    'error_message' => $response['error_message'],
                                    'smsinfo'       => $smsinfo,
                                    'created_by'    => auth()->user()->id
                                ]);
                            }
                        }
                    }
                }

                return response()->json([
                    'data' => null,
                    'status' => true,
                    'message' => 'Order approved successfully'
                ]);
            } catch (\Exception $exception) {
                DB::rollback();
                return response()->json([
                    'data' => null,
                    'status' => false,
                    'message' => $exception->getMessage(),
                ]);
            }
        }
    }



    public function pickupApproveAjax(Request $request)
    {
        $attributeNames = array(
            'order_id' => $request->order_id,
            'team_leader_id' => $request->team_leader_id,
            'pickup_date' => $request->pickupDate,
            'pickup_time' => $request->pickupDate . ' ' . $request->pickupTime
        );

        $validator = Validator::make($attributeNames, [
            'order_id' => 'required',
            'team_leader_id' => 'required',
            'pickup_date' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'data' => $validator->getMessageBag()->toArray(),
                'status' => 'validation-error',
                'message' => null
            ]);
        } else {
            DB::beginTransaction();
            try {

                $orderDetails = json_decode($request->get('orderDetail'), true);
                $customer_name = $orderDetails['customer_name'];
                $shippingCharge = $orderDetails['shippingChargeApplied'];

                OrderModel::where('id', $request->order_id)->update([
                    'is_approve' => 1,
                    'approved_at' => date('Y-m-d H:i:s'),
                    'approved_by' => Auth::user()->first_name,
                    'team_leader_id' => $request->team_leader_id,
                    'is_shipment_charge_applied' => $shippingCharge,
                    'discount_amount' => $orderDetails['discountAmount'],
                    'remarks' => $request->remarks
                ]);

                PickupModel::create($attributeNames);

                //Saving order details
                $this->saveOrderDetails($request, $request->order_id);

                //INSERT INTO highlights TABLE//
                if ($request->highlights == 1) {

                    $Info = new HighlightsModel();
                    $Info->type_id = $request->order_id;
                    $Info->type = "ORDER";
                    $Info->summary = "This order has been highlighted before approval";
                    $Info->created_by = Auth::user()->first_name;
                    $Info->save();
                }

                DB::commit();

                $orderInfo = OrderModel::findOrFail($request->order_id);
                $orderDetailsInfo = OrderDetailsModel::where('order_id', $request->order_id)->where('soft_delete', 0)->get();

                $orderInfo->is_approve = 1;
                $orderInfo->approved_at = date('Y-m-d H:i:s');
                $orderInfo->approved_by = Auth::user()->first_name != null ? Auth::user()->first_name : '';
                $orderInfo->is_shipment_charge_applied = $shippingCharge;
                $orderInfo->discount_amount = $orderDetails['discountAmount'];

                if ($orderInfo->email != null && $orderInfo->email != "") {
                    Mail::to($orderInfo->email)->send(new OrderApproved($orderInfo, $orderDetailsInfo, $shippingCharge));
                }

                // $message = 'Thank you, '.$customer_name.'. We’ve accepted your order and started the delivery process.';

                // $message = str_replace(' ', '%20', $message);
                // $ch = curl_init();
                // curl_setopt($ch, CURLOPT_URL, "http://sms.sslwireless.com/pushapi/dynamic/server.php?user=Technocore&pass=54N182s@&sid=cloudoneEng&sms=$message&msisdn=$number&csmsid=123456789");
                // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                // curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
                // $data = curl_exec($ch);
                // curl_close($ch);

                //SMS (After Approve Order)
                $smsSetting = SmsSetting::where(['type' => 'after_approve_order'])->first();
                if($smsSetting){
                    if($smsSetting['status']){
                        $message = UtilityHelper::personalizeReplace($smsSetting['sms_body'],$orderDetails,$request->order_id);

                        $number = $orderDetails['phone_number'];
                        if($number != null && $number != ''){
                            //Send SMS
                            $sms = new SmsHelper();
                            $response = $sms->singleSms($number,$message);
                            $response = json_decode($response,true);
                            // $smsinfo  = json_encode($response['smsinfo'],true);

                            // SmsLog::create([
                            //     'phone'         => $number,
                            //     'message'       => $message,
                            //     'status'        => $response['status'],
                            //     'status_code'   => $response['status_code'],
                            //     'error_message' => $response['error_message'],
                            //     'smsinfo'       => $smsinfo,
                            //     'created_by'    => auth()->user()->id
                            // ]);
                            if($response['status'] !== 'FAILED'){
                                $smsinfo  = json_encode($response['smsinfo'],true);

                                SmsLog::create([
                                    'phone'         => $number,
                                    'message'       => $message,
                                    'status'        => $response['status'],
                                    'status_code'   => $response['status_code'],
                                    'error_message' => $response['error_message'],
                                    'smsinfo'       => $smsinfo,
                                    'created_by'    => auth()->user()->id
                                ]);
                            }
                        }
                    }
                }


                return response()->json([
                    'data' => null,
                    'status' => true,
                    'message' => 'Pickup approved successfully'
                ]);
            } catch (\Exception $exception) {
                DB::rollback();
                return response()->json([
                    'data' => null,
                    'status' => false,
                    'message' => $exception->getMessage(),
                ]);
            }
        }
    }



    //test comment
    public function directShipmentAssignAjax(Request $request)
    {

        $userName = Auth::user()->first_name;
        $defaultStatus = 0;

        //gettings attributes
        $attributeNames = array(
            'order_id' => $request->order_id,
            'team_leader' => $request->team_leader,
            'delivery_team_id' => $request->deliveryman,
            'deadline_date' => $request->date,
            'deadline_time' => $request->date . ' ' . $request->deadlineTime,
            'created_by' => $userName,
            'updated_by' => $userName,
            'soft_delete' => $defaultStatus
        );

        $deadlineWarning = [
            'delivery_man_id' => $request->deliveryman,
            'order_id' => $request->order_id,
            'deadline' => $request->date . ' ' . $request->deadlineTime,
            'team_lead' => $request->team_leader,
            'soft_delete' => $defaultStatus,
        ];

        //validating the attributes
        $validator = Validator::make($attributeNames, [
            'order_id' => 'required',
            'team_leader' => 'required',
            'delivery_team_id' => 'required',
            'deadline_date' => 'required',
            'deadline_time' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        } else {

            $orderInfo = OrderModel::findOrFail($request->order_id);
            $orderDetails = json_decode($request->get('orderDetail'), true);
            $customer_name = $orderDetails['customer_name'];
            $shippingCharge = $orderDetails['shippingChargeApplied'];

            $orderInfo->is_approve = 1;
            $orderInfo->approved_at = date('Y-m-d H:i:s');
            $orderInfo->approved_by = Auth::user()->first_name != null ? Auth::user()->first_name : '';

            $orderInfo->shipment_assigned = 1;
            $orderInfo->shipment_assigned_at = date("Y-m-d H:i:s");
            $orderInfo->shipment_assigned_by = Auth::user() != null ? Auth::user()->first_name : '';
            $orderInfo->team_leader_id = $request->team_leader ? $request->team_leader : null;

            $orderInfo->discount_amount = $orderDetails['discountAmount'];
            $orderInfo->is_shipment_charge_applied = $shippingCharge;
            $orderInfo->remarks = $request->remarks;
            $orderInfo->update();

            // Update order details //
            $this->saveOrderDetails($request, $request->order_id);
            ShipmentModel::create($attributeNames);
            OrderWarningMessage::create($deadlineWarning);

            $orderDetailsInfo = OrderDetailsModel::where('order_id', $request->order_id)->where('soft_delete', 0)->get();

            new ShipmentAssigned('You have got a new shipment of ID #01'.$orderInfo->id.'!', URL('shipmentOrderDetailsView', $orderInfo->id), Auth::user()->id, $request->deliveryman);

            if ($orderInfo->email != null && $orderInfo->email != "") {
                Mail::to($orderInfo->email)->send(new OrderApproved($orderInfo, $orderDetailsInfo, $shippingCharge));
            }

            //INSERT INTO highlights TABLE//
            if ($request->highlights == 1) {
                $Info = new HighlightsModel();
                $Info->type_id = $request->order_id;
                $Info->type = "ORDER";
                $Info->summary = "This order has been highlighted before went to shipment";
                $Info->created_by = Auth::user()->first_name . "website";
                $Info->save();
            }

            // $message = 'Thank you, '.$customer_name.'. We’ve accepted your order and started the delivery process.';

            // $message = str_replace(' ', '%20', $message);
            // $ch = curl_init();
            // curl_setopt($ch, CURLOPT_URL, "http://sms.sslwireless.com/pushapi/dynamic/server.php?user=Technocore&pass=54N182s@&sid=cloudoneEng&sms=$message&msisdn=$number&csmsid=123456789");
            // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            // curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            // $data = curl_exec($ch);
            // curl_close($ch);

            //SMS (After Approve Order)
            $smsSetting = SmsSetting::where(['type' => 'after_approve_order'])->first();
            if($smsSetting){
                if($smsSetting['status']){
                    $message = UtilityHelper::personalizeReplace($smsSetting['sms_body'],$orderDetails,$request->order_id);

                    $number = $orderDetails['phone_number'];
                    if($number != null && $number != ''){
                        //Send SMS
                        $sms = new SmsHelper();
                        $response = $sms->singleSms($number,$message);
                        $response = json_decode($response,true);
                        // $smsinfo  = json_encode($response['smsinfo'],true);

                        // SmsLog::create([
                        //     'phone'         => $number,
                        //     'message'       => $message,
                        //     'status'        => $response['status'],
                        //     'status_code'   => $response['status_code'],
                        //     'error_message' => $response['error_message'],
                        //     'smsinfo'       => $smsinfo,
                        //     'created_by'    => auth()->user()->id
                        // ]);
                        if($response['status'] !== 'FAILED'){
                            $smsinfo  = json_encode($response['smsinfo'],true);

                            SmsLog::create([
                                'phone'         => $number,
                                'message'       => $message,
                                'status'        => $response['status'],
                                'status_code'   => $response['status_code'],
                                'error_message' => $response['error_message'],
                                'smsinfo'       => $smsinfo,
                                'created_by'    => auth()->user()->id
                            ]);
                        }
                    }
                }
            }

            return response()->json('success');
            // return response()->json([
            //     'data'      => null,
            //     'status'    => true,
            //     'message'   => 'Order approved successfully'
            // ]);
        }

    }


    public function saveOrderDetails(Request $request, int $orderId)
    {
        //Deleting previous order entries
        OrderDetailsModel::where('order_id', $orderId)->delete();

        $productsArray = json_decode($request->get('orderDetail'), true);
        for ($i = 0; $i < count($productsArray['items_details_list']); $i++) {
            $barcodeId = $productsArray["items_details_list"][$i]["barcode_id"];
            $barcodeDetails = PurchaseItemBarcode::where('id',$barcodeId)->with(['item','purchase_details'])->first();

            $orderDetails = new OrderDetailsModel();
            $orderDetails->order_id     = $orderId;
            $orderDetails->product_id   = $barcodeDetails->item->id;
            $orderDetails->barcode_id   = $barcodeId;
            $orderDetails->product_name = $productsArray["items_details_list"][$i]["title"];
            $orderDetails->quantity     = $productsArray["items_details_list"][$i]["quantity"];
            $orderDetails->price        = $productsArray["items_details_list"][$i]["price"] * $productsArray["items_details_list"][$i]["quantity"];
            $orderDetails->unit_price   = $productsArray["items_details_list"][$i]["price"];
            $orderDetails->cost_price   = $barcodeDetails->purchase_details->cost_price;
            $orderDetails->created_by = Auth::user()->first_name;
            $orderDetails->updated_by = Auth::user()->first_name;
            $orderDetails->save();

            // $costPrice = ItemModel::where('id', $productsArray['items_details_list'][$i]["product_id"])->select('cost_price', 'sales_price')->first();

            // $orderDetails = new OrderDetailsModel();
            // $orderDetails->order_id = $orderId;
            // $orderDetails->product_id = $productsArray['items_details_list'][$i]["product_id"];
            // $orderDetails->product_name = $productsArray['items_details_list'][$i]["title"];
            // $orderDetails->quantity = $productsArray['items_details_list'][$i]["quantity"];
            // $orderDetails->unit_price = $productsArray['items_details_list'][$i]["unit_price"];
            // $orderDetails->price = $productsArray['items_details_list'][$i]["price"];
            // // $orderDetails->price        = $productsArray['items_details_list'][$i]["price"] * $productsArray['items_details_list'][$i]["quantity"];

            // $orderDetails->cost_price = $costPrice->cost_price;
            // // $orderDetails->unit_price   = $costPrice->sales_price;

            // $orderDetails->created_by = Auth::user()->first_name;
            // $orderDetails->updated_by = Auth::user()->first_name;
            // $orderDetails->save();

            // StockModel::where('item_id', $productsArray['items_details_list'][$i]["product_id"])
            //     ->decrement('quantity', $productsArray['items_details_list'][$i]["quantity"]);
        }
    }





    public function deliveryManAssignAjax(Request $request)
    {
        $userName = Auth::user()->first_name;

        $defaultStatus = 0;
        //gettings attributes
        $attributeNames = array(
            'order_id' => $request->order_id,
            'team_leader' => $request->team_leader,
            'delivery_team_id' => $request->deliveryman,
            'deadline_date' => $request->date,
            'deadline_time' => $request->date . ' ' . $request->deadlineTime,
            'created_by' => $userName,
            'updated_by' => $userName,
            'soft_delete' => $defaultStatus
        );

        $deadlineWarning = [
            'delivery_man_id' => $request->deliveryman,
            'order_id' => $request->order_id,
            'deadline' => $request->date . ' ' . $request->deadlineTime,
            'team_lead' => '',
            'soft_delete' => 0,
        ];

        //validating the attributes
        $validator = Validator::make($attributeNames, [
            'order_id' => 'required',
            'team_leader' => 'required',
            'delivery_team_id' => 'required',
            'deadline_date' => 'required',
            'deadline_time' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        } else {

            DB::beginTransaction();
            try {

                $shipmentNotification = ShipmentModel::create($attributeNames);
                $orderInfo = OrderModel::findOrFail($request->order_id);
                $orderInfo->shipment_assigned = 1;
                $orderInfo->shipment_assigned_at = date("Y-m-d H:i:s");
                $orderInfo->shipment_assigned_by = Auth::user() != null ? Auth::user()->first_name : '';
                $orderInfo->team_leader_id = $request->team_leader ? $request->team_leader : null;
                $orderInfo->update();

                OrderWarningMessage::create($deadlineWarning);

                new ShipmentAssigned('You have got a new shipment of ID #01'.$orderInfo->id.'!', URL('shipmentOrderDetailsView', $orderInfo->id), Auth::user()->id, $request->deliveryman);

                DB::commit();
                return response()->json("Success");
            } catch (\Exception $exception) {
                DB::rollback();
                return response()->json(array('dbErrors' => $exception->getMessage()));
            }
        }
    }


    public function pickupAjax(Request $request)
    {
        $userName = Auth::user()->first_name;

        //gettings attributes
        $attributeNames = array(
            'order_id' => $request->order_id,
            'team_leader' => $request->team_leader,
            'pickup_date' => $request->pickupDate,
            'pickup_time' => $request->pickupTime,
            'created_by' => $userName,
            'updated_by' => $userName
        );

        //validating the attributes
        $validator = Validator::make($attributeNames, [

        ]);

        if ($validator->fails()) {
            return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        } else {

            DB::beginTransaction();
            try {

                $data = [
                    'pickup_date' => $request->pickup_date,
                    'pickup_time' => $request->pickup_date . ' ' . $request->pickup_time
                ];
                PickupModel::where('order_id', $request->order_id)->update($data);


                $orderInfo = OrderModel::findOrFail($request->order_id);
                $orderInfo->shipment_assigned = 1;
                $orderInfo->shipment_assigned_at = date("Y-m-d H:i:s");
                $orderInfo->shipment_assigned_by = Auth::user() != null ? Auth::user()->first_name : '';
                $orderInfo->team_leader_id = $request->team_leader ? $request->team_leader : null;
                $orderInfo->update();

                DB::commit();
                return response()->json("Success");
            } catch (\Exception $exception) {
                DB::rollback();
                return response()->json(array('dbErrors' => $exception->getMessage()));
            }
        }
    }


    public function pickupOrderView()
    {
        $orders = PickupModel::whereHas('orders', function ($query) {
            $query->where('is_approve', 1)
                ->where('is_rejected', 0)
                ->where('shipment_assigned', 1)
                ->where('is_shipment', 0)
                ->where('delivery_type', '!=', 'shop');
        })->groupBy('order_id')->orderBy('order_id', 'DESC')->get();

        $data = [
            'orders' => $orders
        ];

        return view('admin.order.pickupOrderView', $data);
    }


    public function shipmentOrderView()
    {
        $orders = ShipmentModel::whereHas('orders', function ($query) {
            $query->where('is_approve', 1)
                ->where('is_rejected', 0)
                ->where('shipment_assigned', 1)
                ->where('is_shipment', 0)
                ->where('delivery_type', '!=', 'shop');
        })->groupBy('order_id')->orderBy('priority', 'ASC')->orderBy('order_id', 'DESC')->get();

        $data = [
            'orders' => $orders
        ];

        return view('admin.order.shipmentOrderView', $data);
    }


    public function pickupOrderDetailsView($id)
    {
        $order = OrderModel::findOrFail($id);
        $orderDetails = OrderDetailsModel::where('order_id', $id)->where('soft_delete', 0)->get();
        $shippingCharge = DeliveryChargeModel::where('name', 'shippingcharge')->where('soft_delete', 0)->first();
        $comments = shipmentComments::where('soft_delete', 0)
            ->where('order_id', $id)
            ->with(['user'])
            ->get();

        $data = [
            'order' => $order,
            'orderDetails' => $orderDetails,
            'shippingCharge' => $shippingCharge,
            'comments' => $comments
        ];

        return view('admin.order.pickupOrderDetailsView', $data);
    }


    public function shipmentOrderDetailsView($id)
    {
        $order = OrderModel::findOrFail($id);
        $orderDetails = OrderDetailsModel::where('order_id', $id)->where('soft_delete', 0)->get();
        $shippingCharge = DeliveryChargeModel::where('name', 'shippingcharge')->where('soft_delete', 0)->first();
        $comments = shipmentComments::where('soft_delete', 0)
            ->where('order_id', $id)
            ->with(['user'])
            ->get();

        $data = [
            'order' => $order,
            'orderDetails' => $orderDetails,
            'shippingCharge' => $shippingCharge,
            'comments' => $comments
        ];

        return view('admin.order.shipmentOrderDetailsView', $data);
    }


    public function insertComment(Request $request)
    {
        $attributeNames = [
            'order_id' => $request->order_id,
            'comment' => $request->comment,
        ];

        $validator = Validator::make($attributeNames, [
            'order_id' => 'required',
            'comment' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        } else {
            shipmentComments::create([
                'order_id' => $request->order_id,
                'comment' => $request->comment,
                'user_id' => Auth::user()->id,
                'created_by' => Auth::user()->first_name,
                'soft_delete' => 0
            ]);

            return response()->json("Success");
        }
    }


    public function pickupOrderApprovedAjax(Request $request)
    {
        // $order_code = $request->order_code;
        /**
         * added: shipment_completed_at
         * add this in code
         */

        $userName = Auth::user()->first_name;
        $order = OrderModel::findOrFail($request->id);
        $orderDetails = OrderDetailsModel::where('order_id', $request->id)->where('soft_delete', 0)->get();

        // if ($order->order_code == $order_code) { // ?? strlower and check
        DB::beginTransaction();
        try {

            $sale = new SalesModel();
            $sale->order_id = $order->id;
            $sale->first_name = $order->first_name;
            $sale->last_name = $order->last_name;
            $sale->phone_number = $order->phone_number;
            $sale->email = $order->email;
            $sale->city = $order->city;
            $sale->order_notes = $order->order_notes;
            $sale->status = $order->status; // this is payment status of website orders.
            $sale->sales_by = $userName;
            $sale->created_by = "website";
            $sale->updated_by = "website";
            $sale->soft_delete = $order->soft_delete;
            $sale->save();


            foreach ($orderDetails as $details) {

                $saleDetails = new SalesDetailsModel();
                $saleDetails->sales_id = $sale->id;
                $saleDetails->order_id = $details->order_id;
                $saleDetails->product_id = $details->product_id;
                $saleDetails->product_id = $details->barcode_id;
                $saleDetails->product_name = $details->product_name;
                $saleDetails->quantity = $details->quantity;
                $saleDetails->price = $details->price;
                $saleDetails->cost_price = $details->cost_price;
                $saleDetails->soft_delete = 0;
                $saleDetails->created_by = $userName;
                $saleDetails->updated_by = $userName;
                $saleDetails->save();

                $barcodeId = $details->barcode_id;
                StockModel::where('item_barcodes_id', $barcodeId)->decrement('quantity', $details->quantity);

                // if (StockModel::where('item_id', $details->product_id)->where('soft_delete', 0)->exists()) {

                //     $stock = StockModel::where('item_id', $details->product_id)->where('soft_delete', 0)->first();
                //     $stock->quantity = $stock->quantity - $details->quantity;
                //     $stock->update();
                // }
            }

            // set shipment completion time in orders table
            $order->is_shipment = 1;
            $order->shipment_completed_at = date("Y-m-d H:i:s");
            $order->update();

            // update completion data & time in shipment table
            PickupModel::where('order_id', $request->id)
                ->update([
                    'completed_at' => date("Y-m-d H:i:s"),
                    'completed_by' => Auth::user() != null ? Auth::user()->first_name : ''
                ]);

            DB::commit();

            return response()->json("Success");
        } catch (\Exception $exception) {
            DB::rollback();
            return response()->json(array('dbErrors' => $exception->getMessage()));
        }
    }


    public function shipmentOrderApprovedAjax(Request $request)
    {
        // $order_code = $request->order_code;
        /**
         * added: shipment_completed_at
         * add this in code
         */

        $userName = Auth::user()->first_name;
        $order = OrderModel::findOrFail($request->id);
        $orderDetails = OrderDetailsModel::where('order_id', $request->id)->where('soft_delete', 0)->get();

        // if ($order->order_code == $order_code) { // ?? strlower and check
        DB::beginTransaction();
        try {

            $sale = new SalesModel();
            $sale->order_id = $order->id;
            $sale->first_name = $order->first_name;
            $sale->last_name = $order->last_name;
            $sale->phone_number = $order->phone_number;
            $sale->email = $order->email;
            $sale->city = $order->city;
            $sale->order_notes = $order->order_notes;
            $sale->status = $order->status;  // this is payment status of website orders.
            $sale->sales_by = $userName;
            $sale->created_by = "website";
            $sale->updated_by = "website";
            $sale->soft_delete = $order->soft_delete;
            $sale->save();


            foreach ($orderDetails as $details) {

                $saleDetails = new SalesDetailsModel();
                $saleDetails->sales_id = $sale->id;
                $saleDetails->order_id = $details->order_id;
                $saleDetails->product_id = $details->product_id;
                $saleDetails->barcode_id = $details->barcode_id;
                $saleDetails->product_name = $details->product_name;
                $saleDetails->quantity = $details->quantity;
                $saleDetails->price = $details->price;
                $saleDetails->cost_price = $details->cost_price;
                $saleDetails->soft_delete = 0;
                $saleDetails->created_by = $userName;
                $saleDetails->updated_by = "website";  // kept this field data as website to keep a track/differentiate between sales from shop.
                $saleDetails->save();



                $barcodeId = $details->barcode_id;
                StockModel::where('item_barcodes_id', $barcodeId)->decrement('quantity', $details->quantity);

                // if (StockModel::where('item_id', $details->product_id)->where('soft_delete', 0)->exists()) {

                //     $stock = StockModel::where('item_id', $details->product_id)->where('soft_delete', 0)->first();
                //     $stock->quantity = $stock->quantity - $details->quantity;
                //     $stock->update();
                // }


                //keeping track of sold items
                // $sold = SoldItemTrack::where(['purchase_item_barcodes_id' => $barcodeId]);

                // if ($sold->exists()) {
                //     $query     = $sold->select('sold_quantity')->first();
                //     $sold_quan = $query['sold_quantity'] + $request->orderDetail["items_details_list"][$i]["quantity"];
                //     $sold->update([ 'sold_quantity' => $sold_quan ]);

                // } else {
                //     SoldItemTrack::create([
                //         'item_id' => $orderDetails->product_id,
                //         'purchase_item_barcodes_id' => $barcodeId,
                //         'sold_quantity' => $request->orderDetail["items_details_list"][$i]["quantity"]

                //     ]);
                // }




            }

            // set shipment completion time in orders table
            $order->is_shipment = 1;
            $order->shipment_completed_at = date("Y-m-d H:i:s");
            $order->update();

            // update completion data & time in shipment table
            ShipmentModel::where('order_id', $request->id)
                ->update([
                    'completed_at' => date("Y-m-d H:i:s"),
                    'completed_by' => Auth::user() != null ? Auth::user()->first_name : ''
                ]);


            event(new ShipmentCompleted('Order id no ' . $request->id . 'Shipment Completed', 'completedOrder'));
            DB::commit();

            Mail::to($order->email)->send(new OrderShippedMail($order));

            return response()->json("Success");
        } catch (\Exception $exception) {
            DB::rollback();
            return response()->json(array('dbErrors' => $exception->getMessage()));
        }
    }


    public function shipmentOrderRescheduleAjax(Request $request)
    {

        $userName = Auth::user()->first_name;

        $defaultStatus = 0;
        //gettings attributes
        $attributeNames = array(
            'order_id' => $request->id,
            'reason' => $request->reasonMessage,
            'created_by' => $userName,
            'updated_by' => $userName,
            'soft_delete' => $defaultStatus

        );


        //return dd($attributeNames);

        //validating the attributes
        $validator = Validator::make($attributeNames, [
            'order_id' => 'required',
            'reason' => 'required',
            'created_by' => 'required',
            'updated_by' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        } else {
            DB::beginTransaction();
            try {
                reasonModel::create($attributeNames);

                $order = OrderModel::findOrFail($request->id);
                $order->is_approve = 0;
                $order->is_rejected = 0;
                $order->is_shipment = 0;
                $order->is_payment = 0;
                $order->shipment_assigned = 0;
                $order->save();

                DB::commit();
                return response()->json("Success");
            } catch (\Exception $exception) {
                DB::rollback();
                return response()->json(array('dbErrors' => $exception->getMessage()));
            }
        }
    }


    public function cancelOrderView()
    {
        $orders = OrderModel::where('created_by','!=', 'shop')
                                ->orWhere('created_by','=',null)
                                ->where('is_rejected', 1)
                                ->orderBy('id', 'DESC')
                                ->get();
        $data = [
            'orders' => $orders
        ];
        return view('admin.order.cancelOrderView', $data);
    }


    public function CancelledDetailsView($id)
    {
        $order = OrderModel::findOrFail($id);
        $orderDetails = OrderDetailsModel::where('order_id', $id)->where('soft_delete', 0)->get();
        $shippingCharge = DeliveryChargeModel::where('name', 'shippingcharge')->where('soft_delete', 0)->first();
        $data = [
            'order' => $order,
            'orderDetails' => $orderDetails,
            'shippingCharge' => $shippingCharge
        ];

        return view('admin.order.CancelledDetailsView', $data);
    }


    public function orderDeliveryManAssign($id)
    {
        $deliveryManRole = 3;
        $order = OrderModel::findOrFail($id);
        $orderDetails = OrderDetailsModel::where('order_id', $id)
            ->where('soft_delete', 0)
            ->get();

        // $deliveryMan = UserRolesModel::where('role_id', self::DELIVERY_MAN_ROLE_ID)
        $deliveryMan = UserRolesModel::where('role_id', env('DELIVERYMAN_ROLE'))
            ->where('soft_delete', 0)
            ->with('user')
            ->get();

        // $teamLeaders = UserRolesModel::where('role_id', self::TEAM_LEADER_ROLE_ID)
        $teamLeaders = UserRolesModel::where('role_id', env('TEAMLEADER_ROLE'))
            ->where('soft_delete', 0)
            ->with('user')
            ->get();

        $shippingCharge = DeliveryChargeModel::where('name', 'shippingcharge')
            ->where('soft_delete', 0)
            ->first();

        $data = [
            'order' => $order,
            'orderDetails' => $orderDetails,
            'deliveryMan' => $deliveryMan,
            'teamLeaders' => $teamLeaders,
            'shippingCharge' => $shippingCharge
        ];

        return view('admin.order.orderDeliveryManAssign', $data);
    }


    public function pendingOrderDetailsView($id)
    {
        $order = OrderModel::findOrFail($id);
        $orderDetails = OrderDetailsModel::where('order_id', $id)->where('soft_delete', 0)->get();
        $shippingCharge = DeliveryChargeModel::where('name', 'shippingcharge')->where('soft_delete', 0)->first();
        $data = [
            'order' => $order,
            'orderDetails' => $orderDetails,
            'shippingCharge' => $shippingCharge
        ];

        return view('admin.order.pendingOrderDetailsView', $data);
    }


    public function saleDetailsView($id)
    {
        $order = OrderModel::findOrFail($id);
        $orderDetails = OrderDetailsModel::where('order_id', $id)->where('soft_delete', 0)->get();
        $shippingCharge = DeliveryChargeModel::where('name', 'shippingcharge')->where('soft_delete', 0)->first();
        $data = [
            'order' => $order,
            'orderDetails' => $orderDetails,
            'shippingCharge' => $shippingCharge
        ];

        return view('admin.order.saleDetailsView', $data);
    }


    public function removeItemFromOrderAjax(Request $request)
    {

        $orderItem = OrderDetailsModel::where('id', $request->item_id)->where('order_id', $request->order_id)->first();
        $orderItem->soft_delete = 1;
        $orderItem->update();
        return response()->json('success');
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * Returns POS sales view
     */
    public function salesView()
    {
        // $allProducts = PurchaseItemBarcode::where('soft_delete',SOFT_DELETE_NO)->with(['item','stock'])->get();
        $master = PurchaseItemBarcode::where('soft_delete',SOFT_DELETE_NO)->with('item');
        $allProducts = $master->where(function($subQuery){
            $subQuery->whereHas('stock', function ( $query ) {
                $query->where('quantity','>',0);
            });
        })->get();

        $shippingCharge = DeliveryChargeModel::where('soft_delete', '0')->where('name', 'shippingcharge')->first();
        $paymentMethods = PaymentMethodModel::all();
        $referrals = ReferralModel::all();
        $bookingData = Booking::where('status', BOOKING__STATUS_READY_TO_DELIVER)->where('status', '!=', BOOKING__STATUS_INACTIVE)->select(['id'])->get();
        $lastInsertedRow = OrderModel::orderBy('id', 'desc')->select(['id'])->first();
        if(!$lastInsertedRow){
            $lastInsertedRow['id'] = 0;
        }

         $data = [
            'allProducts' => $allProducts,
            'shippingCharge' => $shippingCharge,
            'paymentMethods' => $paymentMethods,
            'referrals' => $referrals,
            'bookingData' => $bookingData,
            'lastInsertedRow' => $lastInsertedRow,
            ];

        return view('admin.order.salesView', $data);
    }


    public function salesCompletedView()
    {
        return view('admin.order.salesCompletedView');
    }

    // Developed By Omar Hossain Parvez Start
    public function getCompletedOrders()
    {
        // $orders = SalesModel::orderBy('completed_at', 'DESC')
        // ->where('created_by', 'shop')
        // ->where('is_cancelled',0)
        // ->where('is_due_paid',1)
        // ->get();

        // return Datatables::of($orders)
        // ->addIndexColumn()
        // ->addColumn('order_notes', function ($order) {
        //     // Ensure order_notes is a string, even if it's null
        //     return (string) $order->order_notes;
        // })
        // ->editColumn('completed_at', function ($order) {
        //     return date('Y-m-d', strtotime($order->completed_at));  // Format the completed_at field
        // })
        // ->addColumn('action', function ($order) {
        //     $actions = '';

        //     if ($order->company_name !== 'outsource') {
        //         $actions .= '<a href="' . url('salesReturnView', $order->order->id) . '" class="btn badge badge-secondary" style="padding: 5px 10px;color: #fff;cursor: pointer;line-height: 10px">Return</a>';
        //     } else {
        //         $actions .= '<a href="' . url('outsourceReturnDetails', $order->order->id) . '" class="btn badge badge-secondary" style="padding: 5px 10px;color: #fff;cursor: pointer;line-height: 10px">Return</a>';
        //     }

        //     return $actions;
        // })
        // ->addColumn('invoice', function ($order) {
        //     return '<a onclick="invoiceModal(' . $order->order->id . ')" style="padding: 5px 10px;color: #fff;cursor: pointer;" class="btn badge badge-primary" data-toggle="tooltip" title="" data-original-title="Invoice">Invoice</a>';
        // })
        // ->addColumn('invoice_id', function ($order) {
        //     return $order->delivery_type == "delivery" || $order->delivery_type == "pickup" ? '#0101' . $order->order->id : '#0202' . $order->order->id;
        // })
        // ->addColumn('customer_name', function ($order) {
        //     return '<a class="custom_textDecoration" href="' . url('completedOrderDetailsView', $order->order->id) . '" style="cursor: pointer">' . $order->first_name . ' ' . $order->last_name . '</a>';
        // })
        // ->rawColumns(['action', 'invoice', 'invoice_id', 'customer_name'])
        // ->make(true);

        $orders = SalesModel::where([
            ['created_by', '=', 'shop'],
            ['is_cancelled', '=', 0],
            ['is_due_paid', '=', 1]
        ]);

        $datatable = Datatables::of($orders)
            ->addIndexColumn()
            ->addColumn('order_notes', function ($order) {
                // Ensure order_notes is a string, even if it's null
                return (string) $order->order_notes;
            })
            ->editColumn('completed_at', function ($order) {
                return date('Y-m-d', strtotime($order->completed_at));  // Format the completed_at field
            })
            ->addColumn('action', function ($order) {
                $actions = '';

                if ($order->company_name !== 'outsource') {
                    $actions .= '<a href="' . url('salesReturnView', $order->order_id) . '" class="btn badge badge-secondary" style="padding: 5px 10px;color: #fff;cursor: pointer;line-height: 10px">Return</a>';
                } else {
                    $actions .= '<a href="' . url('outsourceReturnDetails', $order->order_id) . '" class="btn badge badge-secondary" style="padding: 5px 10px;color: #fff;cursor: pointer;line-height: 10px">Return</a>';
                }

                return $actions;
            })
            ->addColumn('invoice', function ($order) {
                return '<a onclick="invoiceModal(' . $order->order_id . ')" style="padding: 5px 10px;color: #fff;cursor: pointer;" class="btn badge badge-primary" data-toggle="tooltip" title="" data-original-title="Invoice">Invoice</a>';
            })
            ->addColumn('invoice_id', function ($order) {
                return $order->delivery_type == "delivery" || $order->delivery_type == "pickup" ? '#0101' . $order->order_id : '#0202' . $order->order_id;
            })
            ->filterColumn('invoice_id', function($query, $keyword) {
                $query->whereRaw("CONCAT('#0202', sales.order_id) LIKE ?", ["%{$keyword}%"]);
            })
            
            ->addColumn('customer_name', function ($order) {
                return '<a class="custom_textDecoration" href="' . url('completedOrderDetailsView', $order->order_id) . '" style="cursor: pointer">' . $order->first_name . ' ' . $order->last_name . '</a>';
            })
            ->addColumn('customer_name_plain', function ($order) {
                return $order->first_name . ' ' . $order->last_name;
            })
            ->filterColumn('customer_name_plain', function ($query, $keyword) {
                $query->whereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ["%{$keyword}%"]);
            }) 
            ->rawColumns(['action', 'invoice', 'invoice_id', 'customer_name', 'customer_name_plain'])
            ->make(true);

        // Return the DataTable
        return $datatable;

    }
    // Developed By Omar Hossain Parvez End

    public function allSoldItemsView()
    {
        $orders = SalesDetailsModel::where('soft_delete', 0)
                                        ->with(['sales','barcode'])
                                        ->whereHas('sales', function($q){
                                            $q->where('created_by', 'shop')
                                                ->where('is_cancelled',0);
                                        })->orderBy('id','desc')->get();

        return view('admin.order.soldItemsView', ['orders' => $orders]);
    }

    public function listAllSoldItems(){
        $orders = SalesDetailsModel::where('soft_delete', 0)
                                        ->with(['sales','barcode'])
                                        ->whereHas('sales', function($q){
                                            $q->where('created_by', 'shop')
                                                ->where('is_cancelled',0);
                                        })->orderBy('id','desc')->get();

         return Datatables::of($orders)
         ->addColumn('data_item_name', function ($data) {
            return '<a class="custom_textDecoration"onclick="window.open(`'.url('completedOrderDetailsView', $data->order_id).'`)"style="cursor:pointer">'.$data->product_name.'</a>';
        })
         ->addColumn('data_qty', function ($data) {
            return $data->quantity ?? "";
        })
         ->addColumn('data_unit_price', function ($data) {
            return $data->unit_price ?? "";
        })
         ->addColumn('data_total', function ($data) {
            return number_format($data->price, 2) ?? "";
        })
         ->addColumn('data_cost_price', function ($data) {
            return number_format($data->cost_price, 2) ?? "";
        })
         ->addColumn('data_invoice_id', function ($data) {
            return $data->order_id ?? "";
        })
         ->addColumn('data_invoice_date', function ($data) {
            return $data->sales->invoice_date ?? "";
        })
         ->addColumn('data_barcode', function ($data) {
            return $data->barcode ? $data->barcode->barcode : "Not found";
        })
         ->addColumn('data_invoice', function ($data) {
            return '<a onclick="invoiceModal('.$data->order_id.')"
            style="padding: 5px 10px;color: #fff;cursor: pointer;" class="btn badge badge-primary"
            data-toggle="tooltip" title="" data-original-title="Invoice">
            Invoice
            </a>';
        })
        ->rawColumns(['data_item_name','data_invoice'])
        ->addIndexColumn()
        ->make(true);
    }

    // public function listAllSoldItems(){
    //     $orders = SalesDetailsModel::where('soft_delete', 0)->with(['sales','barcode'])->whereHas('sales', function($q){
    //                                     $q->where('created_by', 'shop')->where('is_cancelled',0)->where('is_due_paid',1);
    //                                 })->orderBy('id', 'DESC');

    //     return Datatables::of($orders)
    //     ->addColumn('item_name', function ($order) {
    //         return '<a class="custom_textDecoration" href="url("completedOrderDetailsView/>$order->order_id)" style="cursor: pointer">
    //                     '.$order->product->name.'
    //                 </a>';
    //                 '<a class="btn btn-primary btn-xs" href="'.$stock->purchase_item_barcode->barcode_image.'" download><i class="fa fa-download"></i> Barcode</a>'
    //         // return $order->product->name;
    //         })
    //     ->addColumn('invoice_id', function ($order) {
    //         return '#0202'.$order->order_id;
    //     })
    //     ->addColumn('invoice_date', function ($order) {
    //         return $order->sales->invoice_date;
    //     })
    //     ->addColumn('barcode', function ($order) {
    //         if($order->barcode == null){
    //             return "Not found";
    //         } else{
    //         return $order->barcode->barcode;
    //         }
    //     })
    //     ->addColumn('action',function($order){
    //         return '<a onclick="invoiceModal('.$order->order_id.')"
    //                     style="padding: 5px 10px;color: #fff;cursor: pointer;" class="btn badge badge-primary"
    //                     data-toggle="tooltip" title="" data-original-title="Invoice">
    //                     Invoice
    //                 </a>';
    //     })
    //     ->rawColumns(['action','data_category_name','data_subcategory_name'])
    //     ->make(true);
    // }

    public function cancelledSalesView()
    {
        $orders = SalesModel::orderBy('id', 'DESC')
            ->where('created_by', 'shop')
            ->where('is_cancelled',1)
            // ->where('is_due_paid',1)
            ->get();
        $data = [
            'orders' => $orders
        ];
        return view('admin.order.cancelledSalesView', $data);
    }


    /**
     * Sales Return View Is Displayed
     */
    public function salesReturnView($id)
    {
        $master         = PurchaseItemBarcode::where('soft_delete',SOFT_DELETE_NO)->with('item');
        $allProducts    = $master->where(function($subQuery){
            $subQuery->whereHas('stock', function ( $query ) {
                $query->where('quantity','>',0);
            });
        })->get();

        $order      = OrderModel::where('id', $id)->first();
        $sale       = SalesModel::select('id', 'payment_due', 'collected_payment','invoice_date')->where('order_id', $id)->first();
        $due        = SalesModel::where('order_id', $id)->where('payment_due', '>', 0)->where('is_due_paid', '0')->orderBy('id', 'DESC')->get();
        $referrals  = ReferralModel::all();
        $customerId = CustomerModel::where('phone', $order->phone_number)->first();
        $customerreferrals  = CustomersReferralsDetailsModel::select('referral_id')->where('customer_id', $customerId->id)->get();
        $paymentMethods     = PaymentMethodModel::all();
        $paymentDetails     = PaymentCollectionModel::where('order_id', $id)->where('soft_delete',0)->latest()->first();
        $orderDetails       = OrderDetailsModel::where('order_id', $id)->where('soft_delete', 0)->with(['purchase_item_barcodes','stocks'])->get();
        $orderedProductBarcodes = [];
        foreach ($orderDetails as $singleOrder)
        {
            array_push($orderedProductBarcodes,$singleOrder->purchase_item_barcodes->barcode);
        }

        $data = [
            'order'             => $order,
            'allProducts'       => $allProducts,
            'orderDetails'      => $orderDetails,
            'sale'              => $sale,
            'due'               => $due,
            'referrals'         => $referrals,
            'paymentMethods'    => $paymentMethods,
            'paymentDetails'    => $paymentDetails,
            'customerreferrals'         => $customerreferrals,
            'orderedProductBarcodes'    => $orderedProductBarcodes,
        ];

        return view('admin.order.salesReturnDetails', $data);
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * Sales Due View blade
     */
    public function salesDueView()
    {

        // $sales = SalesModel::where('payment_due', '>', 0)->where('is_due_paid', '0')->where('is_cancelled',0)->orderBy('id', 'DESC')->get();

        // $data = [
        //     'sales' => $sales
        // ];
        // return view('admin.order.salesDueView', $data);
        return view('admin.order.salesDueView');
    }

    public function dueViewDatatable(Request $request)
    {
        if ($request->ajax()) {
            $sales = SalesModel::where('payment_due', '>', 0)
                ->where('is_due_paid', '0')
                ->where('is_cancelled', 0)
                ->orderBy('id', 'DESC')
                ->get();

                return Datatables::of($sales)
                ->addIndexColumn()
                ->addColumn('action', function ($sale) {
                    $button = '<button style="padding: 5px 10px;" class="btn btn-default btn-xs border ml-1" onclick="dueCollection(' . $sale->id . ')">
                                    <i class="fa fa-check"></i>
                                </button>';

                    $button .= '<a onclick="invoiceModal(' . $sale->order_id . ')" 
                                    style="padding: 5px 10px;color: #fff;cursor: pointer;" class="btn badge badge-primary ml-1" 
                                    data-toggle="tooltip" title="" data-original-title="Invoice">
                                    invoice
                                </a>';

                    if ($sale->company_name !== 'outsource') {
                        $button .= '<a href="' . url('salesReturnView', $sale->order_id) . '" class="btn badge badge-secondary ml-1" style="padding: 5px 10px;color: #fff;cursor: pointer;line-height: 10px"> Edit </a>';
                    } else {
                        $button .= '<a href="' . url('outsourceReturnDetails', $sale->order_id) . '" class="btn badge badge-secondary ml-1" style="padding: 5px 10px;color: #fff;cursor: pointer;line-height: 10px">Edit</a>';
                    }

                    return $button;
                })
                ->addColumn('due', function ($sale) {
                    return $sale->payment_due - $sale->sales_due_payment->sum('paid_amount');
                })
                ->addColumn('customer_name', function ($sale) {
                    return '<a class="custom_textDecoration" href="' . url('completedOrderDetailsView', $sale->order_id) . '" style="cursor: pointer">' . $sale->first_name . ' ' . $sale->last_name . '</a>';
                })
                ->addColumn('invoice_id', function ($sale) {
                    return '#0202' . $sale->order->id;
                })
                ->rawColumns(['action', 'due', 'customer_name', 'invoice_id'])
                ->make(true);
        }
    }


    public function dueCollected(Request $request)
    {
        $attributeNames = [
            "sales_id" => $request->id,
            "paid_amount" => $request->collected_amount,
            "collected_by" => Auth::user()->id,
        ];

        $validator = Validator::make($attributeNames, [
            'sales_id' => 'required',
            'paid_amount' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        } else {
            DB::beginTransaction();
            try {

            SalesDuePayment::create(
                [
                    "sales_id" => $request->id,
                    "paid_amount" => $request->collected_amount,
                    "collected_by" => Auth::user()->id,
                ]
            );

            $salesData = SalesModel::where('id',$request->id)->select('order_id')->first();
            $payment_collection = PaymentCollectionModel::where('order_id',$salesData->order_id)->where('soft_delete',0)->first();
            $total_amount = $payment_collection->total_amount + $request->collected_amount;
            PaymentCollectionModel::where('order_id',$salesData->order_id)->where('soft_delete',0)->update(['total_amount' => $total_amount]);


            $totalPaid = SalesDuePayment::where('sales_id', $request->id)->sum('paid_amount');
            $dueAmount = SalesModel::where('id', $request->id)->select('payment_due')->first();

            if ($dueAmount->payment_due <= $totalPaid) {

                $salesUpdate = SalesModel::where('id', $request->id);

                $orderUpdate = $salesUpdate->first();
                $salesUpdate->update([
                    'is_due_paid'  => 1,
                    'completed_at' => now()->toDateTimeString()
                ]);

                OrderModel::where('id', $orderUpdate->order_id)->update(['is_due_paid' => 1]);
            }

            DB::commit();
            return response()->json('Success', 200);
            } catch (\Exception $exception) {
                DB::rollback();
                return response()->json(array('dbErrors' => $exception->getMessage()));
            }
        }

    }


    public function getDueDetails(Request $request)
    {
        $id = $request->id;
        $category = SalesModel::where('id', $id)->select('payment_due')->first();
        $totalPaid = SalesDuePayment::where('sales_id', $id)->sum('paid_amount');

        $payment_due = $category->payment_due - $totalPaid;

        return response()->json(["payment_due" => $payment_due]);
    }


    public function bookingView()
    {
        // $allProducts = PurchaseItemBarcode::where('soft_delete',SOFT_DELETE_NO)->with('item')->get();
        $master = PurchaseItemBarcode::where('soft_delete',SOFT_DELETE_NO)->with('item');
        $allProducts = $master->where(function($subQuery){
            $subQuery->whereHas('stock', function ( $query ) {
                $query->where('quantity','>',0);
            });
        })->get();

        $shippingCharge = DeliveryChargeModel::where('soft_delete', '0')->where('name', 'shippingcharge')->first();
        $paymentMethods = PaymentMethodModel::all();
        $referrals = ReferralModel::all();
        $lastInsertedRow = Booking::orderBy('id', 'desc')->select(['id'])->first();

        $data = [
            'allProducts' => $allProducts,
            'shippingCharge' => $shippingCharge,
            'paymentMethods' => $paymentMethods,
            'referrals' => $referrals,
            'lastInsertedRow' => $lastInsertedRow,
        ];

        return view('admin.order.bookingView', $data);
    }


    /**
     * Saving booking details
     */
    public function bookingInsert(Request $request)
    {
        //Check validation
        $validator = Validator::make($request->bookingDetail, [
            'first_name' => 'required|min:1|max:256|regex:/^[A-Za-z\s]+$/',
            'phone_number' => 'required|regex:/(01)[0-9]{9}/',
            'advancePayment' => 'required|numeric|min:1'
        ],[ 'first_name.regex' => 'Please input letters only.']);

        if ($validator->fails()) {
            return response()->json([
                'data' => $validator->getMessageBag()->toArray(),
                'status' => 'validation-error',
                'message' => null
            ]);
        } else if (!(array_key_exists('items_details_list',$request->bookingDetail))) {
            return response()->json([
                'data'      => null,
                'status'    => false,
                'message'   => ''
            ]);

        }

        $attributeNames = array(
            'first_name' => $request->bookingDetail["first_name"],
            'last_name' => $request->bookingDetail["last_name"],
            'phone_number' => $request->bookingDetail["phone_number"],
            'email' => isset($request->bookingDetail['email']) ? $request->bookingDetail['email'] : null,
            'country' => isset($request->bookingDetail['country']) ? $request->bookingDetail['country'] : null,
            'district' => isset($request->bookingDetail['district']) ? $request->bookingDetail['district'] : null,
            'city' => isset($request->bookingDetail['city']) ? $request->bookingDetail['city'] : null,
            'thana' => isset($request->bookingDetail['thana']) ? $request->bookingDetail['thana'] : null,
            'area' => isset($request->bookingDetail['area']) ? $request->bookingDetail['area'] : null,
            'road_no' => isset($request->bookingDetail['road_no']) ? $request->bookingDetail['road_no'] : null,
            'house_no' => isset($request->bookingDetail['house_no']) ? $request->bookingDetail['house_no'] : null,
            'flat_no' => isset($request->bookingDetail['flat_no']) ? $request->bookingDetail['flat_no'] : null,
            'car_no' => isset($request->bookingDetail['car_no']) ? $request->bookingDetail['car_no'] : null,
            'advance_payment' => $request->bookingDetail['advancePayment'],
            'discount_amount' => isset($request->bookingDetail['discountAmount']) ? $request->bookingDetail['discountAmount'] : null,
            'shipping_amount' => isset($request->bookingDetail['shippingAmount']) ? $request->bookingDetail['shippingAmount'] : null,
            'status' => BOOKING__STATUS_ADVANCE_CASH_RECEIVED,
            'booking_notes' => isset($request->bookingDetail['order_notes']) ? $request->bookingDetail['order_notes'] : null,
            // 'customer_notes' => isset($request->bookingDetail['customer_notes']) ? $request->bookingDetail['customer_notes'] : null,
            'created_by' => isset($request->bookingDetail['created_by']) ? $request->bookingDetail['created_by'] : null,
            'updated_by' => isset($request->bookingDetail['updated_by']) ? $request->bookingDetail['updated_by'] : null,
            'invoice_date' => isset($request->bookingDetail['invoiceDate']) ? $request->bookingDetail['invoiceDate'] : null,
            'remarks' => isset($request->bookingDetail['remarks']) ? $request->bookingDetail['remarks'] : null,
        );


        DB::beginTransaction();

        try {
            //Insert data in bookings table
            $bookingData = Booking::create($attributeNames);
            $bookingId = $bookingData['id'];
            //Insert data in booking details table
            for ($i = 0; $i < count($request->bookingDetail["items_details_list"]); $i++) {
                $barcodeId = $request->bookingDetail["items_details_list"][$i]["barcode_id"];
                $barcodeDetails = PurchaseItemBarcode::where('id',$barcodeId)->with(['item','purchase_details'])->first();
                $data = [
                    'booking_id' => $bookingId,
                    'product_id' => $barcodeDetails->item->id,
                    'barcode_id' => $barcodeId,
                    'product_name' => $request->bookingDetail["items_details_list"][$i]["title"],
                    'quantity' => $request->bookingDetail["items_details_list"][$i]["quantity"],
                    'total_price' => $request->bookingDetail["items_details_list"][$i]["price"] * $request->bookingDetail["items_details_list"][$i]["quantity"],
                    'unit_price' => $request->bookingDetail["items_details_list"][$i]["price"],
                    'cost_price' => $barcodeDetails->purchase_details->cost_price
                ];

                BookingDetail::create($data);
            }

            //Insert data in advance payments table
            $data = [
                'booking_id' => $bookingId,
                'payment_method_id' => $request->payment_method,
                'paid_amount' => $request->bookingDetail['advancePayment'],
                'payable_amount' => $request->bookingDetail['totalAmountWithShipping'],
                'payment_collected_by' => Auth::user()->first_name,
            ];
            AdvancePayment::create($data);


            $customerMailPhoneExists = CustomerModel::where('phone', '=', $request->bookingDetail["phone_number"])->first();
            if (isset($customerMailPhoneExists->id)) {
                $customer_id = $customerMailPhoneExists->id;
            }

            if ($customerMailPhoneExists === null) {

                $newCustomer = new CustomerModel();
                $newCustomer->first_name = $request->bookingDetail["first_name"];
                $newCustomer->last_name = $request->bookingDetail["last_name"];
                $newCustomer->email = $request->bookingDetail["email"];
                $newCustomer->phone = $request->bookingDetail["phone_number"];
                $newCustomer->country = $request->bookingDetail["country"];
                $newCustomer->district = $request->bookingDetail["district"];
                $newCustomer->city = $request->bookingDetail["city"];
                $newCustomer->thana = $request->bookingDetail["thana"];
                $newCustomer->area = $request->bookingDetail["area"];
                $newCustomer->road_no = $request->bookingDetail["road_no"];
                $newCustomer->house_no = $request->bookingDetail["house_no"];
                $newCustomer->flat_no = $request->bookingDetail["flat_no"];
                $newCustomer->car_no = $request->bookingDetail['car_no'];
                // $newCustomer->address = $request->bookingDetail["address"];
                $newCustomer->created_by = Auth::user()->first_name;
                $newCustomer->updated_by = Auth::user()->first_name;
                $newCustomer->save();

                if (isset($request->referral_method)) {
                    for ($i = 0; $i < count($request->referral_method); $i++) {

                        $refferalDetails = new CustomersReferralsDetailsModel();
                        $refferalDetails->customer_id = $newCustomer->id;
                        $refferalDetails->referral_id = $request->referral_method[$i];
                        $refferalDetails->save();
                    }
                }

                WelcomeCallModel::create([
                    'customer_id' => $newCustomer->id,
                    'created_by' => Auth::user()->first_name
                ]);

            }

            DB::commit();

            return response()->json([
                'data' => null,
                'status' => true,
                'message' => 'Booking saved successfully'
            ]);

        } catch (\Exception $exception) {
            DB::rollback();

            return response()->json([
                'data' => null,
                'status' => false,
                'message' => $exception->getMessage(),
            ]);
        }
    }


    /**
     * Updates booking data
     */
    public function bookingUpdate(Request $request)
    {
        //Check validation
        $validator = Validator::make($request->bookingDetail, [
            'first_name' => 'required|min:1|max:256',
            'phone_number' => 'required|regex:/(01)[0-9]{9}/',
            'advancePayment' => 'required|numeric|min:1'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'data' => $validator->getMessageBag()->toArray(),
                'status' => 'validation-error',
                'message' => null
            ]);
        }

        $attributeNames = array(
            'first_name' => $request->bookingDetail["first_name"],
            'last_name' => $request->bookingDetail["last_name"],
            'phone_number' => $request->bookingDetail["phone_number"],
            'email' => isset($request->bookingDetail['email']) ? $request->bookingDetail['email'] : null,
            'country' => isset($request->bookingDetail['country']) ? $request->bookingDetail['country'] : null,
            'district' => isset($request->bookingDetail['district']) ? $request->bookingDetail['district'] : null,
            'city' => isset($request->bookingDetail['city']) ? $request->bookingDetail['city'] : null,
            'thana' => isset($request->bookingDetail['thana']) ? $request->bookingDetail['thana'] : null,
            'area' => isset($request->bookingDetail['area']) ? $request->bookingDetail['area'] : null,
            'road_no' => isset($request->bookingDetail['road_no']) ? $request->bookingDetail['road_no'] : null,
            'house_no' => isset($request->bookingDetail['house_no']) ? $request->bookingDetail['house_no'] : null,
            'flat_no' => isset($request->bookingDetail['flat_no']) ? $request->bookingDetail['flat_no'] : null,
            'car_no' => isset($request->bookingDetail['car_no']) ? $request->bookingDetail['car_no'] : null,
            'advance_payment' => $request->bookingDetail['advancePayment'],
            'discount_amount' => isset($request->bookingDetail['discountAmount']) ? $request->bookingDetail['discountAmount'] : null,
            'shipping_amount' => isset($request->bookingDetail['shippingChargeApplied']) ? $request->bookingDetail['shippingChargeApplied'] : null,
            'status' => BOOKING__STATUS_ADVANCE_CASH_RECEIVED,
            'booking_notes' => isset($request->bookingDetail['order_notes']) ? $request->bookingDetail['order_notes'] : null,
            // 'customer_notes' => isset($request->bookingDetail['customer_notes']) ? $request->bookingDetail['customer_notes'] : null,
            // 'created_by' => isset($request->bookingDetail['created_by']) ? $request->bookingDetail['created_by'] : null,
            'remarks' => isset($request->bookingDetail['remarks']) ? $request->bookingDetail['remarks'] : null,
            'updated_by' => isset($request->bookingDetail['updated_by']) ? $request->bookingDetail['updated_by'] : null,
        );

        DB::beginTransaction();

        try {
            //Update data in bookings table
            $bookingId = $request->bookingDetail['bookingId'];
            $where = [
                'id' => $bookingId
            ];
            Booking::where($where)->update($attributeNames);

            //Delete previous data from booking details table
            BookingDetail::where('booking_id', $bookingId)->delete();

            //Insert data in booking details table
            for ($i = 0; $i < count($request->bookingDetail["items_details_list"]); $i++) {
                $barcodeId = $request->bookingDetail["items_details_list"][$i]["barcode_id"];
                $barcodeDetails = PurchaseItemBarcode::where('id',$barcodeId)->with(['item','purchase_details'])->first();

                $data = [
                    'booking_id' => $bookingId,
                    'product_id' => $barcodeDetails->item->id,
                    'barcode_id' => $barcodeId,
                    'product_name' => $request->bookingDetail["items_details_list"][$i]["title"],
                    'quantity' => $request->bookingDetail["items_details_list"][$i]["quantity"],
                    'total_price' => $request->bookingDetail["items_details_list"][$i]["price"] * $request->bookingDetail["items_details_list"][$i]["quantity"],
                    'unit_price' => $request->bookingDetail["items_details_list"][$i]["price"],
                    'cost_price' => $barcodeDetails->purchase_details->cost_price
                ];

                BookingDetail::create($data);
            }

            //Update data in advance payments table
            $data = [
                'booking_id' => $bookingId,
                'payment_method_id' => $request->payment_method,
                'paid_amount' => $request->bookingDetail['advancePayment'],
                'payable_amount' => $request->bookingDetail['totalAmountWithShipping'],
                'payment_collected_by' => Auth::user()->first_name
            ];

            $where = [
                'id' => $request->bookingDetail['advancePaymentId']
            ];
            AdvancePayment::where($where)->update($data);

            //customers table update
            CustomerModel::findOrFail($request->bookingDetail['customerId'])->update([
                'country'    =>  $request->bookingDetail['country'],
                'district'   =>  $request->bookingDetail['district'],
                'city'       =>  $request->bookingDetail['city'],
                'thana'      =>  $request->bookingDetail['thana'],
                'area'       =>  $request->bookingDetail['area'],
                'road_no'    =>  $request->bookingDetail['road_no'],
                'house_no'   =>  $request->bookingDetail['house_no'],
                'flat_no'    =>  $request->bookingDetail['flat_no'],
                'car_no'     =>  $request->bookingDetail['car_no'],
                'updated_by' =>  Auth::user()->first_name
            ]);



            DB::commit();

            return response()->json([
                'data' => null,
                'status' => true,
                'message' => 'Booking updated successfully'
            ]);

        } catch (\Exception $exception) {
            DB::rollback();

            return response()->json([
                'data' => null,
                'status' => false,
                'message' => 'Something went wrong! Please try again'
            ]);
        }
    }

    /**
     * Returns booked orders display page
     */
    public function bookedOrdersView()
    {
        $bookings = Booking::with(['payment_in_advance'])->orderBy('id', 'DESC')->get();
        $data = [
            'bookings' => $bookings
        ];

        return view('admin.order.bookedOrdersView', $data);
    }

    /**
     * Returns booking details
     */
    public function getBookingDetails(Request $request)
    {
        $bookingId = $request->get('id');
        $bookingDetails = Booking::where('id', $bookingId)->select(['id', 'status'])->first();

        if ($bookingDetails) {

            return response()->json([
                'data' => $bookingDetails,
                'status' => true,
                'message' => null
            ]);
        }

        return response()->json([
            'data' => null,
            'status' => false,
            'message' => "Booking data not found!"
        ]);
    }

    public function getBookingInfoForSale(Request $request)
    {
        $bookingId = $request->get('id');
        $bookingData = Booking::where('id', $bookingId)->first();
        $bookingDetailsData = BookingDetail::where('booking_id', $bookingId)->with(['product_detail','purchase_item_barcodes','stocks'])->get();
        $advancePaymentData = AdvancePayment::where('booking_id', $bookingId)->first();
        $customerId = CustomerModel::where('phone', $bookingData->phone_number)->first();

        $customerreferrals = null;
        if (isset($customerId->id)) {
            $customerreferrals = CustomersReferralsDetailsModel::select('referral_id')->where('customer_id', $customerId->id)->get();
        }


        $data = [
            'bookingData' => $bookingData,
            'bookingDetailsData' => $bookingDetailsData,
            'advancePaymentData' => $advancePaymentData,
            'customerreferrals' => $customerreferrals,
        ];

        return response()->json([
            'data' => $data,
            'status' => true,
            'message' => null
        ]);
    }

    /**
     * Change booking status
     */
    public function changeBookingStatus(Request $request)
    {
        DB::beginTransaction();
        try {

            $response = Booking::where(['id' => $request->get('booking_id')])
                ->update(['status' => $request->get('booking_status')]);

            if ($request->get('booking_status') == 4) {
                $bookingId = $request->get('booking_id');

                //cancelling the booking from bookings table with soft_delete 1
                $bookingCancel = Booking::where('id', $bookingId)->first();
                $bookingCancel->soft_delete = 1;
                $bookingCancel->update();

                //cancelling the booking detail from booking_details table with soft_delete 1
                $bookingCancel = BookingDetail::where('booking_id', $bookingId)->update(['soft_delete' => 1]);

                //removing from advance_payments table
                $paymentCancel = AdvancePayment::where('booking_id', $bookingId)->first();
                $paymentCancel->soft_delete = 1;
                $paymentCancel->update();
            }

            DB::commit();
            return response()->json([
                'data' => null,
                'status' => true,
                'message' => 'Status Changed Successfully'
            ]);
        } catch (\Exception $exception) {
            DB::rollback();
            return response()->json([
                'data' => $exception->getMessage(),
                'status' => false,
                'message' => 'Could not update status! Please try again'
            ]);
        }
    }

    public function editBooking($id)
    {
        // $allProducts = PurchaseItemBarcode::where('soft_delete',SOFT_DELETE_NO)->with('item')->get();
        $master = PurchaseItemBarcode::where('soft_delete',SOFT_DELETE_NO)->with('item');
        $allProducts = $master->where(function($subQuery){
            $subQuery->whereHas('stock', function ( $query ) {
                $query->where('quantity','>',0);
            });
        })->get();

        $bookingData = Booking::where('id', $id)->first();
        $bookingDetailsData = BookingDetail::where('booking_id', $id)->with(['purchase_item_barcodes','stocks'])->get();
        $bookedProductBarcodes = [];
        foreach ($bookingDetailsData as $booking)
        {
           array_push($bookedProductBarcodes,$booking->purchase_item_barcodes->barcode);
        }

        $paymentMethods = PaymentMethodModel::all();
        $advancePaymentData = AdvancePayment::where('booking_id', $id)->first();
        $referrals = ReferralModel::all();
        $customerreferrals = null;
        $customerId = CustomerModel::where('phone', $bookingData->phone_number)->first();
        if (isset($customerId->id)) {
            $customerreferrals = CustomersReferralsDetailsModel::select('referral_id')->where('customer_id', $customerId->id)->get();
        }

        $data = [
            'bookingData' => $bookingData,
            'bookingDetailsData' => $bookingDetailsData,
            'advancePaymentData' => $advancePaymentData,
            'allProducts' => $allProducts,
            'referrals' => $referrals,
            'paymentMethods' => $paymentMethods,
            'customerId' => $customerId,
            'customerreferrals' => $customerreferrals,
            'bookedProductBarcodes' => $bookedProductBarcodes,
        ];

        return view('admin.order.editBooking', $data);
    }

    //When sales is happened from POS sales panel
    public function salesInsert(Request $request)
    {
        // dd($request->all());

        // Log request data using the custom channel
        Log::channel('sales_insert_log')->info('Request Data: ' . json_encode($request->all()));

        $attributeNames = array(
            'first_name'    => $request->orderDetail["first_name"],
            'last_name'     => $request->orderDetail["last_name"],
            'order_notes'   => $request->orderDetail["order_notes"],
            'phone_number'  => $request->orderDetail["phone_number"],
            'email'         => $request->orderDetail['email'],
            'country'       => $request->orderDetail['country'],
            'district'      => $request->orderDetail['district'],
            'city'          => $request->orderDetail['city'],
            'thana'         => $request->orderDetail['thana'],
            'area'          => $request->orderDetail['area'],
            'road_no'       => $request->orderDetail['road_no'],
            'house_no'      => $request->orderDetail['house_no'],
            'flat_no'       => $request->orderDetail['flat_no'],
            'car_no'        => $request->orderDetail['car_no']
        );

        $validator = Validator::make($attributeNames, [
            'first_name'    => 'required|min:1|max:256',
            'phone_number'  => 'required|regex:/(01)[0-9]{9}/'
        ]);


        if ($validator->fails()) {
            return response()->json(array('errors' => $validator->getMessageBag()->toArray()));

        } else if (!(array_key_exists('items_details_list',$request->orderDetail))) {
            return response()->json([
                'data'      => null,
                'status'    => false,
                'message'   => ''
            ]);

        } else {

            $uniqueId = uniqid('ORD');

            DB::beginTransaction();

            try {
                $order = new OrderModel();
                $order->first_name = $request->orderDetail["first_name"];
                $order->last_name = $request->orderDetail["last_name"];
                $order->phone_number = $request->orderDetail["phone_number"];
                $order->email = $request->orderDetail["email"];
                $order->country = $request->orderDetail["country"];
                $order->district = $request->orderDetail["district"];
                $order->city = $request->orderDetail["city"];
                $order->thana = $request->orderDetail["thana"];
                $order->area = $request->orderDetail["area"];
                $order->road_no = $request->orderDetail["road_no"];
                $order->house_no = $request->orderDetail["house_no"];
                $order->flat_no = $request->orderDetail["flat_no"];
                $order->car_no = $request->orderDetail["car_no"];
                $order->order_code = $uniqueId;            // ORD = Order
                $order->order_notes = $request->orderDetail["order_notes"];
                // $order->customer_notes = $request->orderDetail["customer_notes"];
                $order->delivery_type = "shop";
                $order->is_approve = 1;    // ORD = Order
                $order->shipment_assigned       = 1;    // ORD = Order
                $order->shipment_assigned_by = Auth::user()->first_name;
                $order->shipment_assigned_at = date('Y-m-d H:i:s');
                $order->is_shipment = 1;    // ORD = Order
                $order->is_rejected = 0;    // ORD = Order
                $order->status = 1;    // ORD = Order, this is payment status of website orders.
                $order->is_payment = 1;    // ORD = Order

                $order->is_shipment_charge_applied = $request->orderDetail["shippingChargeApplied"];
                $order->discount_amount = $request->orderDetail["discountAmount"];     // ORD = Order
                $order->advance_payment = $request->orderDetail['advancePayment'];
                $order->collected_payment = $request->orderDetail['collectedPayment'];
                $order->payment_due = $request->orderDetail['paymentDue'];
                if ($order->payment_due > 0) {
                    $order->is_due_paid = 0;
                }

                $order->sales_by = Auth::user()->first_name;
                $order->remarks  = $request->orderDetail['remarks'];
                $order->created_by = "shop";
                $order->updated_by = "shop";
                $order->save();

                $lastId = $order->id;

                $sale = new SalesModel();
                $sale->order_id = $order->id;
                $sale->first_name = $order->first_name;
                $sale->last_name = $order->last_name;
                $sale->phone_number = $order->phone_number;
                $sale->email = $order->email;
                $sale->city = $order->city;
                $sale->order_notes = $order->order_notes;
                $sale->status = $order->status;   // this is payment status of website orders.
                $sale->is_shipment_charge_applied = $order->is_shipment_charge_applied;
                $sale->discount_amount = $order->discount_amount;
                $sale->advance_payment = $order->advance_payment;
                $sale->collected_payment = $order->collected_payment;
                if ($order->payment_due > 0) {
                    $sale->is_due_paid  = 0;
                }else{
                    $sale->completed_at = now()->toDateTimeString();
                }
                $sale->payment_due = $order->payment_due;
                $sale->sales_by = Auth::user()->first_name;
                $sale->invoice_date = $request->orderDetail["invoiceDate"];
                $sale->created_by = "shop";
                $sale->updated_by = "shop";
                $sale->soft_delete = 0;

                $sale->save();


                for ($i = 0; $i < count($request->orderDetail["items_details_list"]); $i++) {
                    $barcodeId = $request->orderDetail["items_details_list"][$i]["barcode_id"];
                    $barcodeDetails = PurchaseItemBarcode::where('id',$barcodeId)->with(['item','purchase_details'])->first();

                    $orderDetails = new OrderDetailsModel();
                    $orderDetails->order_id = $order->id;
                    $orderDetails->product_id = $barcodeDetails->item->id;
                    $orderDetails->barcode_id = $barcodeId;
                    $orderDetails->product_name = $request->orderDetail["items_details_list"][$i]["title"];
                    $orderDetails->quantity = $request->orderDetail["items_details_list"][$i]["quantity"];
                    $orderDetails->price = $request->orderDetail["items_details_list"][$i]["price"] * $request->orderDetail["items_details_list"][$i]["quantity"];
                    $orderDetails->unit_price = $request->orderDetail["items_details_list"][$i]["price"];
                    $orderDetails->cost_price = $barcodeDetails->purchase_details->cost_price;

                    $orderDetails->created_by = "shop";
                    $orderDetails->updated_by = "shop";
                    $orderDetails->save();

                    $saleDetails = new SalesDetailsModel();
                    $saleDetails->sales_id = $sale->id;
                    $saleDetails->order_id = $orderDetails->order_id;
                    $saleDetails->product_id = $orderDetails->product_id;
                    $saleDetails->barcode_id = $orderDetails->barcode_id;
                    $saleDetails->product_name = $orderDetails->product_name;
                    $saleDetails->quantity = $orderDetails->quantity;
                    $saleDetails->unit_price = $orderDetails->unit_price;
                    $saleDetails->price = $orderDetails->price;
                    $saleDetails->cost_price = $orderDetails->cost_price;
                    $saleDetails->soft_delete = 0;
                    $saleDetails->created_by = Auth::user()->first_name;
                    $saleDetails->updated_by = Auth::user()->first_name;
                    $saleDetails->save();

                    StockModel::where('item_barcodes_id', $barcodeId)
                        ->decrement('quantity', $request->orderDetail["items_details_list"][$i]["quantity"]);

                    //keeping track of sold items
                    // $sold = SoldItemTrack::where(['purchase_item_barcodes_id' => $barcodeId]);

                    // if ($sold->exists()) {
                    //     $query     = $sold->select('sold_quantity')->first();
                    //     $sold_quan = $query['sold_quantity'] + $request->orderDetail["items_details_list"][$i]["quantity"];
                    //     $sold->update([ 'sold_quantity' => $sold_quan ]);

                    // } else {
                    //     SoldItemTrack::create([
                    //         'item_id' => $orderDetails->product_id,
                    //         'purchase_item_barcodes_id' => $barcodeId,
                    //         'sold_quantity' => $request->orderDetail["items_details_list"][$i]["quantity"]

                    //     ]);
                    // }


                }

                // payment colletion at time of sale subtracting the advance payment if it had a booking //
                $insertA = [];
                $insertA['order_id'] = $order->id;
                $insertA['payment_method_id'] = $request->payment_method;
                $insertA['invoice_amount'] = $request->orderDetail["totalAmountWithShipping"];
                // $insertA['total_amount'] = $request->orderDetail["collectedPayment"] - $request->orderDetail["advancePayment"];
                $insertA['total_amount'] = $request->orderDetail["collectedPayment"];
                $insertA['payment_collected_by'] = Auth::user()->first_name . "(shop)";
                $insert = PaymentCollectionModel::create($insertA);


                //Update booking status if completed
                $bookingId = $request->orderDetail["hiddenBookingId"];
                if ($bookingId != 0) {
                    Booking::where(['id' => $bookingId])->update([
                        'status'    => BOOKING__STATUS_DELIVERED,
                        'sale_id'   => $sale->id
                    ]);
                }

                //INSERT INTO highlights TABLE//
                if ($request->highlights !== null) {

                    $Info = new HighlightsModel();
                    $Info->type_id = $order->id;
                    $Info->type = "SALE";
                    $Info->summary = "This Sale is highlighted";
                    $Info->created_by = Auth::user()->first_name;
                    $Info->save();

                }



                /*  NEW CUSTOMER INSERT INTO customers TABLE FROM SALE PANEL  */
                $customer_id = 0;
                $customerMailPhoneExists = CustomerModel::where('phone', '=', $request->orderDetail["phone_number"])->first();
                if (isset($customerMailPhoneExists->id)) {
                    $customer_id = $customerMailPhoneExists->id;
                }

                if ($customerMailPhoneExists === null) {

                    $newCustomer = new CustomerModel();
                    $newCustomer->first_name = $request->orderDetail["first_name"];
                    $newCustomer->last_name = $request->orderDetail["last_name"];
                    $newCustomer->email = $request->orderDetail["email"];
                    $newCustomer->phone = $request->orderDetail["phone_number"];
                    $newCustomer->country = $request->orderDetail["country"];
                    $newCustomer->district = $request->orderDetail["district"];
                    $newCustomer->city = $request->orderDetail["city"];
                    $newCustomer->thana = $request->orderDetail["thana"];
                    $newCustomer->area = $request->orderDetail["area"];
                    $newCustomer->road_no = $request->orderDetail["road_no"];
                    $newCustomer->house_no = $request->orderDetail["house_no"];
                    $newCustomer->flat_no = $request->orderDetail["flat_no"];
                    $newCustomer->car_no = $request->orderDetail["car_no"];
                    //$newCustomer->address = $request->orderDetail["address"];
                    $newCustomer->created_by = Auth::user()->first_name;
                    $newCustomer->updated_by = Auth::user()->first_name;
                    $newCustomer->save();

                    if (isset($request->referral_method)) {
                        for ($i = 0; $i < count($request->referral_method); $i++) {

                            $orderDetails = new CustomersReferralsDetailsModel();
                            $orderDetails->customer_id = $newCustomer->id;
                            $orderDetails->referral_id = $request->referral_method[$i];

                            $orderDetails->save();
                        }
                    }

                    WelcomeCallModel::create([
                        'customer_id' => $newCustomer->id,
                        'created_by' => Auth::user()->first_name
                    ]);

                }

                $attributeNames = array(
                    'order_id' => $order->id,
                    'delivery_team_id' => Auth::user()->id,
                    'deadline_date' => date('Y-m-d'),
                    'deadline_time' => date('Y-m-d H:i:s'),
                    'completed_by'  => 'shop',
                    'created_by'    => Auth::user()->first_name,
                    'updated_by'    => Auth::user()->first_name,
                    'soft_delete'   => 0
                );

                $deadlineWarning = [
                    'delivery_man_id' => $request->deliveryman,
                    'order_id' => $request->order_id,
                    'deadline' => $request->date . ' ' . $request->deadlineTime,
                    'team_lead' => '',
                    'soft_delete' => 0,
                ];


                ShipmentModel::create($attributeNames);
                // OrderWarningMessage::create($deadlineWarning);


                //SEND EMAIL
                $email = $request->orderDetail["email"];
                $firstName = $request->orderDetail["first_name"];
                $lastName = $request->orderDetail["last_name"];
                $number = $request->orderDetail["phone_number"];
                $orderId = sprintf("%04s", $order->id);

                $address = '';
                $address .= $request->orderDetail["flat_no"] ? 'Flat no - ' . $request->orderDetail["flat_no"] . ', ' : '';
                $address .= $request->orderDetail["house_no"] ? 'House no - ' . $request->orderDetail["house_no"] . ', ' : '';
                $address .= $request->orderDetail["road_no"] ? 'Road no - ' . $request->orderDetail["road_no"] . ', ' : '';
                $address .= $request->orderDetail["area"] ? $request->orderDetail["area"] . ', ' : '';
                $address .= $request->orderDetail["thana"] ? $request->orderDetail["thana"] . ', ' : '';
                $address .= $request->orderDetail["city"] ? $request->orderDetail["city"] . ', ' : '';


                $address .= $request->orderDetail["district"] ? $request->orderDetail["district"] . ', ' : '';
                $address .= $request->orderDetail["country"] ? $request->orderDetail["country"] . ', ' : '';
                $address = trim($address);

                // add the ending '.' according to need
                if ($address != '') {
                    if ($address[strlen($address) - 1] == ',') {
                        $address[strlen($address) - 1] = '.';
                    } elseif ($address[strlen($address) - 1] != '.') {
                        $address .= '.';
                    }
                }


                DB::commit();

                // $message = "Dear Subscriber, Your sale has been completed.";
                // $message = str_replace(' ', '%20', $message);
                // $ch = curl_init();
                // curl_setopt($ch, CURLOPT_URL, "http://sms.sslwireless.com/pushapi/dynamic/server.php?user=Technocore&pass=54N182s@&sid=cloudoneEng&sms=$message&msisdn=$mobileNumber&csmsid=123456789");
                // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                // curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
                // $data = curl_exec($ch);
                // curl_close($ch);

                // if ($email != null && $email != "") {
                //     Mail::to($email)->send(new OrderConfirmationMail($firstName, $lastName, $email, $number, $address, $orderId));
                // }

                // $orderInfo = OrderModel::findOrFail($request->order_id);
                // $orderDetailsInfo = OrderDetailsModel::where('order_id', $request->order_id)->where('soft_delete', 0)->get();

                // $orderInfo->is_approve = 1;
                // $orderInfo->approved_at = date('Y-m-d H:i:s');
                // $orderInfo->approved_by = Auth::user()->first_name != null ? Auth::user()->first_name : '';
                // $orderInfo->is_shipment_charge_applied = $shippingCharge;
                // $orderInfo->discount_amount = $orderDetails['discountAmount'];

                if ($email != null && $email != "") {
                    $orderInfo           = OrderModel::findOrFail($orderId);
                    $orderDetailsInfo    = OrderDetailsModel::where('order_id',$orderId)->where('soft_delete',0)->get();
                    Mail::to($email)->send(new PosSaleMail($firstName, $lastName, $email, $number, $address, $orderId, $orderInfo, $orderDetailsInfo));
                    // Mail::to($email)->send(new PosSaleMail($firstName, $lastName, $email, $number, $address, $orderId, $request->orderDetail));
                }

                //SMS
                if ($customer_id > 0) {
                    //old customer (After Sale)
                    $smsSetting = SmsSetting::where(['type' => 'after_sale'])->first();
                    if($smsSetting){
                        if($smsSetting['status']){

                            $message = UtilityHelper::personalizeReplace($smsSetting['sms_body'],$request->orderDetail,$orderId);

                            if($number != null && $number != ''){
                                //Send SMS
                                $sms = new SmsHelper();
                                $response = $sms->singleSms($number,$message);
                                $response = json_decode($response,true);
                                // // dd($response);
                                // $smsinfo  = json_encode($response['smsinfo'],true);

                                // SmsLog::create([
                                //     'phone'         => $number,
                                //     'message'       => $message,
                                //     'status'        => $response['status'],
                                //     'status_code'   => $response['status_code'],
                                //     'error_message' => $response['error_message'],
                                //     'smsinfo'       => $smsinfo,
                                //     'created_by'    => auth()->user()->id
                                // ]);
                                if($response['status'] !== 'FAILED'){
                                    $smsinfo  = json_encode($response['smsinfo'],true);

                                    SmsLog::create([
                                        'phone'         => $number,
                                        'message'       => $message,
                                        'status'        => $response['status'],
                                        'status_code'   => $response['status_code'],
                                        'error_message' => $response['error_message'],
                                        'smsinfo'       => $smsinfo,
                                        'created_by'    => auth()->user()->id
                                    ]);
                                }
                            }

                        }
                    }

                } else {
                    //new customer (After First Sale)
                    $smsSetting = SmsSetting::where(['type' => 'after_first_sale'])->first();
                    if($smsSetting){
                        if($smsSetting['status']){
                            $message = UtilityHelper::personalizeReplace($smsSetting['sms_body'],$request->orderDetail,$orderId);

                            if($number != null && $number != ''){
                                //Send SMS
                                $sms = new SmsHelper();
                                $response = $sms->singleSms($number,$message);
                                $response = json_decode($response,true);
                                // $smsinfo  = json_encode($response['smsinfo'],true);

                                // SmsLog::create([
                                //     'phone'         => $number,
                                //     'message'       => $message,
                                //     'status'        => $response['status'],
                                //     'status_code'   => $response['status_code'],
                                //     'error_message' => $response['error_message'],
                                //     'smsinfo'       => $smsinfo,
                                //     'created_by'    => auth()->user()->id
                                // ]);
                                if($response['status'] !== 'FAILED'){
                                    $smsinfo  = json_encode($response['smsinfo'],true);

                                    SmsLog::create([
                                        'phone'         => $number,
                                        'message'       => $message,
                                        'status'        => $response['status'],
                                        'status_code'   => $response['status_code'],
                                        'error_message' => $response['error_message'],
                                        'smsinfo'       => $smsinfo,
                                        'created_by'    => auth()->user()->id
                                    ]);
                                }
                            }

                        }
                    }
                }

                return response()->json([
                    'data' => [
                        'order_id' => $lastId
                    ],
                    'status' => true,
                    'message' => 'Sale completed successfully'
                ]);

            } catch (\Exception $exception) {
                DB::rollback();
                Log::error($exception->getMessage());
                return response()->json(array('dbErrors' => $exception->getMessage()));
            }
        }
    }

    public function outsourceView(){
        $shippingCharge = DeliveryChargeModel::where('soft_delete', '0')->where('name', 'shippingcharge')->first();
        $paymentMethods = PaymentMethodModel::all();
        $referrals = ReferralModel::all();
        $lastInsertedRow = OrderModel::orderBy('id', 'desc')->select(['id'])->first();
        if(!$lastInsertedRow){
            $lastInsertedRow['id'] = 0;
        }

         $data = [
            'shippingCharge' => $shippingCharge,
            'paymentMethods' => $paymentMethods,
            'referrals' => $referrals,
            'lastInsertedRow' => $lastInsertedRow,
            ];
        return view('admin.order.outsourceView',$data);
    }


    public function outsourceInsert(Request $request)
    {
        $attributeNames = array(
            'first_name'    => $request->orderDetail["first_name"],
            'last_name'     => $request->orderDetail["last_name"],
            'phone_number'  => $request->orderDetail["phone_number"],
            'email'         => $request->orderDetail['email'],
            'country'       => $request->orderDetail['country'],
            'district'      => $request->orderDetail['district'],
            'city'          => $request->orderDetail['city'],
            'thana'         => $request->orderDetail['thana'],
            'area'          => $request->orderDetail['area'],
            'road_no'       => $request->orderDetail['road_no'],
            'house_no'      => $request->orderDetail['house_no'],
            'flat_no'       => $request->orderDetail['flat_no'],
            'car_no'        => $request->orderDetail['car_no'],
            'order_notes'   => $request->orderDetail["order_notes"],
        );

        $validator = Validator::make($attributeNames, [
            'first_name'    => 'required|min:1|max:256',
            'phone_number'  => 'required|regex:/(01)[0-9]{9}/'
        ]);


        if ($validator->fails()) {
            return response()->json(array('errors' => $validator->getMessageBag()->toArray()));

        } else if (!(array_key_exists('items_details_list',$request->orderDetail))) {
            return response()->json([
                'data'      => null,
                'status'    => false,
                'message'   => 'Please Insert Item!'
            ]);

        } else {

            $uniqueId = uniqid('ORD');

            DB::beginTransaction();

            try {
                $order = new OrderModel();
                $order->first_name      = $request->orderDetail["first_name"];
                $order->last_name       = $request->orderDetail["last_name"];
                $order->phone_number    = $request->orderDetail["phone_number"];
                $order->email           = $request->orderDetail["email"];
                $order->country         = $request->orderDetail["country"];
                $order->district        = $request->orderDetail["district"];
                $order->city            = $request->orderDetail["city"];
                $order->thana           = $request->orderDetail["thana"];
                $order->area            = $request->orderDetail["area"];
                $order->road_no         = $request->orderDetail["road_no"];
                $order->house_no        = $request->orderDetail["house_no"];
                $order->flat_no         = $request->orderDetail["flat_no"];
                $order->car_no          = $request->orderDetail["car_no"];
                $order->company_name    = "outsource";
                $order->order_code      = $uniqueId;
                $order->order_notes     = $request->orderDetail["order_notes"];
                $order->delivery_type   = "shop";
                $order->is_approve      = 1;

                $order->shipment_assigned       = 1;
                $order->shipment_assigned_by    = Auth::user()->first_name;
                $order->shipment_assigned_at    = date('Y-m-d H:i:s');
                $order->is_shipment = 1;
                $order->is_rejected = 0;
                $order->status      = 1;  //this is payment status of website orders.
                $order->is_payment  = 1;

                $order->is_shipment_charge_applied  = $request->orderDetail["shippingChargeApplied"];
                $order->discount_amount             = $request->orderDetail["discountAmount"];
                $order->collected_payment           = $request->orderDetail['collectedPayment'];
                $order->payment_due                 = $request->orderDetail['paymentDue'];

                if ($order->payment_due > 0) {
                    $order->is_due_paid = 0;
                }

                $order->sales_by    = Auth::user()->first_name;
                $order->remarks     = $request->orderDetail['remarks'];
                $order->created_by  = "shop";
                $order->updated_by  = "shop";
                $order->save();

                $lastId = $order->id;

                $sale = new SalesModel();
                $sale->order_id     = $order->id;
                $sale->first_name   = $order->first_name;
                $sale->last_name    = $order->last_name;
                $sale->phone_number = $order->phone_number;
                $sale->email        = $order->email;
                $sale->city         = $order->city;
                $sale->company_name = "outsource";
                $sale->order_notes  = $order->order_notes;
                $sale->status       = $order->status;   // this is payment status of website orders.

                $sale->is_shipment_charge_applied   = $order->is_shipment_charge_applied;
                $sale->discount_amount              = $order->discount_amount;
                $sale->collected_payment            = $order->collected_payment;
                $sale->payment_due                  = $order->payment_due;

                if ($order->payment_due > 0) {
                    $sale->is_due_paid = 0;
                }else{
                    $sale->completed_at = now()->toDateTimeString();
                }

                $sale->invoice_date = $request->orderDetail["invoiceDate"];
                $sale->sales_by     = Auth::user()->first_name;
                $sale->created_by   = "shop";
                $sale->updated_by   = "shop";
                $sale->soft_delete  = 0;

                $sale->save();


                for ($i = 0; $i < count($request->orderDetail["items_details_list"]); $i++) {

                    $item =  new ItemModel();
                    $item->name                  = $request->orderDetail["items_details_list"][$i]["title"];
                    $item->cost_price            = $request->orderDetail["items_details_list"][$i]["costPrice"];
                    $item->sales_price           = $request->orderDetail["items_details_list"][$i]["salesPrice"];
                    $item->is_published          = 0;
                    $item->is_outsourced         = 1;
                    $item->created_by            = Auth::user()->first_name;
                    $item->updated_by            = Auth::user()->first_name;
                    $item->soft_delete           = 0;
                    $item->has_watermark         = 1;
                    $item->save();

                    $orderDetails = new OrderDetailsModel();
                    $orderDetails->order_id     = $order->id;
                    $orderDetails->product_id   = $item->id;
                    $orderDetails->product_name = $request->orderDetail["items_details_list"][$i]["title"];
                    $orderDetails->quantity     = $request->orderDetail["items_details_list"][$i]["quantity"];
                    $orderDetails->price        = $request->orderDetail["items_details_list"][$i]["totalPrice"];
                    $orderDetails->unit_price   = $request->orderDetail["items_details_list"][$i]["salesPrice"];
                    $orderDetails->cost_price   = $request->orderDetail["items_details_list"][$i]["costPrice"];
                    $orderDetails->created_by   = "shop";
                    $orderDetails->updated_by   = "shop";
                    $orderDetails->save();

                    $saleDetails = new SalesDetailsModel();
                    $saleDetails->sales_id      = $sale->id;
                    $saleDetails->order_id      = $orderDetails->order_id;
                    $saleDetails->product_id    = $orderDetails->product_id;
                    $saleDetails->product_name  = $orderDetails->product_name;
                    $saleDetails->quantity      = $orderDetails->quantity;
                    $saleDetails->unit_price    = $orderDetails->unit_price;
                    $saleDetails->price         = $orderDetails->price;
                    $saleDetails->cost_price    = $orderDetails->cost_price;
                    $saleDetails->created_by    = Auth::user()->first_name;
                    $saleDetails->updated_by    = Auth::user()->first_name;
                    $saleDetails->save();

                }

                // payment colletion at time of sale subtracting the advance payment if it had a booking //
                $insertA = [];
                $insertA['order_id'] = $order->id;
                $insertA['payment_method_id']    = $request->payment_method;
                $insertA['invoice_amount']       = $request->orderDetail["totalAmountWithShipping"];
                $insertA['total_amount']         = $request->orderDetail["collectedPayment"];
                $insertA['payment_collected_by'] = Auth::user()->first_name . "(shop)";
                PaymentCollectionModel::create($insertA);


                /*  NEW CUSTOMER INSERT INTO customers TABLE FROM SALE PANEL  */
                $customerMailPhoneExists = CustomerModel::where('phone', '=', $request->orderDetail["phone_number"])->first();

                if ($customerMailPhoneExists === null) {
                    $newCustomer = new CustomerModel();
                    $newCustomer->first_name    = $request->orderDetail["first_name"];
                    $newCustomer->last_name     = $request->orderDetail["last_name"];
                    $newCustomer->email         = $request->orderDetail["email"];
                    $newCustomer->phone         = $request->orderDetail["phone_number"];
                    $newCustomer->country       = $request->orderDetail["country"];
                    $newCustomer->district      = $request->orderDetail["district"];
                    $newCustomer->city          = $request->orderDetail["city"];
                    $newCustomer->thana         = $request->orderDetail["thana"];
                    $newCustomer->area          = $request->orderDetail["area"];
                    $newCustomer->road_no       = $request->orderDetail["road_no"];
                    $newCustomer->house_no      = $request->orderDetail["house_no"];
                    $newCustomer->flat_no       = $request->orderDetail["flat_no"];
                    $newCustomer->car_no        = $request->orderDetail["car_no"];

                    $newCustomer->created_by    = Auth::user()->first_name;
                    $newCustomer->updated_by    = Auth::user()->first_name;
                    $newCustomer->save();

                    if (isset($request->referral_method)) {
                        for ($i = 0; $i < count($request->referral_method); $i++) {
                            $orderDetails = new CustomersReferralsDetailsModel();
                            $orderDetails->customer_id = $newCustomer->id;
                            $orderDetails->referral_id = $request->referral_method[$i];
                            $orderDetails->save();
                        }
                    }
                    WelcomeCallModel::create([
                        'customer_id' => $newCustomer->id,
                        'created_by'  => Auth::user()->first_name
                    ]);

                }


                //INSERT INTO highlights TABLE//
                if ($request->highlights !== null) {
                    $Info = new HighlightsModel();
                    $Info->type_id      = $order->id;
                    $Info->type         = "SALE";
                    $Info->summary      = "This Sale is highlighted";
                    $Info->created_by   = Auth::user()->first_name;
                    $Info->save();

                }

                $attributeNames = array(
                    'order_id' => $order->id,
                    'delivery_team_id' => Auth::user()->id,
                    'deadline_date' => date('Y-m-d'),
                    'deadline_time' => date('Y-m-d H:i:s'),
                    'completed_by'  => 'shop',
                    'created_by'    => Auth::user()->first_name,
                    'updated_by'    => Auth::user()->first_name
                );
                ShipmentModel::create($attributeNames);


                //SEND EMAIL
                $email      = $request->orderDetail["email"];
                $firstName  = $request->orderDetail["first_name"];
                $lastName   = $request->orderDetail["last_name"];
                $number     = $request->orderDetail["phone_number"];
                $orderId    = sprintf("%04s", $order->id);

                $address = '';
                $address .= $request->orderDetail["flat_no"] ? 'Flat no - ' . $request->orderDetail["flat_no"] . ', ' : '';
                $address .= $request->orderDetail["house_no"] ? 'House no - ' . $request->orderDetail["house_no"] . ', ' : '';
                $address .= $request->orderDetail["road_no"] ? 'Road no - ' . $request->orderDetail["road_no"] . ', ' : '';
                $address .= $request->orderDetail["area"] ? $request->orderDetail["area"] . ', ' : '';
                $address .= $request->orderDetail["thana"] ? $request->orderDetail["thana"] . ', ' : '';
                $address .= $request->orderDetail["city"] ? $request->orderDetail["city"] . ', ' : '';


                $address .= $request->orderDetail["district"] ? $request->orderDetail["district"] . ', ' : '';
                $address .= $request->orderDetail["country"] ? $request->orderDetail["country"] . ', ' : '';
                $address = trim($address);

                // add the ending '.' according to need
                if ($address != '') {
                    if ($address[strlen($address) - 1] == ',') {
                        $address[strlen($address) - 1] = '.';
                    } elseif ($address[strlen($address) - 1] != '.') {
                        $address .= '.';
                    }
                }

                DB::commit();

                if ($email != null && $email != "") {
                    $orderInfo           = OrderModel::findOrFail($orderId);
                    $orderDetailsInfo    = OrderDetailsModel::where('order_id',$orderId)->where('soft_delete',0)->get();
                    Mail::to($email)->send(new PosSaleMail($firstName, $lastName, $email, $number, $address, $orderId, $orderInfo, $orderDetailsInfo));
                }

                // Dipra-20-07-2023
                // SMS
                if ($customerMailPhoneExists != '' && $customerMailPhoneExists != null ) {
                    //old customer (After Sale)
                    $smsSetting = SmsSetting::where(['type' => 'after_sale'])->first();
                    if($smsSetting){
                        if($smsSetting['status']){

                            $message = UtilityHelper::personalizeReplace($smsSetting['sms_body'],$request->orderDetail,$orderId);

                            if($number != null && $number != ''){
                                //Send SMS
                                $sms = new SmsHelper();
                                $response = $sms->singleSms($number,$message);
                                // dd($response);
                                $response = json_decode($response,true);
                                // $smsinfo  = json_encode($response['smsinfo'],true);

                                // SmsLog::create([
                                //     'phone'         => $number,
                                //     'message'       => $message,
                                //     'status'        => $response['status'],
                                //     'status_code'   => $response['status_code'],
                                //     'error_message' => $response['error_message'],
                                //     'smsinfo'       => $smsinfo,
                                //     'created_by'    => auth()->user()->id
                                // ]);
                                if($response['status'] !== 'FAILED'){
                                    $smsinfo  = json_encode($response['smsinfo'],true);

                                    SmsLog::create([
                                        'phone'         => $number,
                                        'message'       => $message,
                                        'status'        => $response['status'],
                                        'status_code'   => $response['status_code'],
                                        'error_message' => $response['error_message'],
                                        'smsinfo'       => $smsinfo,
                                        'created_by'    => auth()->user()->id
                                    ]);
                                }
                            }

                        }
                    }

                } else {
                    //new customer (After First Sale)
                    $smsSetting = SmsSetting::where(['type' => 'after_first_sale'])->first();
                    if($smsSetting){
                        if($smsSetting['status']){
                            $message = UtilityHelper::personalizeReplace($smsSetting['sms_body'],$request->orderDetail,$orderId);

                            if($number != null && $number != ''){
                                //Send SMS
                                $sms = new SmsHelper();
                                $response = $sms->singleSms($number,$message);
                                $response = json_decode($response,true);
                                // $smsinfo  = json_encode($response['smsinfo'],true);

                                // SmsLog::create([
                                //     'phone'         => $number,
                                //     'message'       => $message,
                                //     'status'        => $response['status'],
                                //     'status_code'   => $response['status_code'],
                                //     'error_message' => $response['error_message'],
                                //     'smsinfo'       => $smsinfo,
                                //     'created_by'    => auth()->user()->id
                                // ]);
                                if($response['status'] !== 'FAILED'){
                                    $smsinfo  = json_encode($response['smsinfo'],true);

                                    SmsLog::create([
                                        'phone'         => $number,
                                        'message'       => $message,
                                        'status'        => $response['status'],
                                        'status_code'   => $response['status_code'],
                                        'error_message' => $response['error_message'],
                                        'smsinfo'       => $smsinfo,
                                        'created_by'    => auth()->user()->id
                                    ]);
                                }
                            }

                        }
                    }
                }
                // Dipra-20-07-2023 End

                return response()->json([
                    'data'      => ['order_id' => $lastId],
                    'status'    => true,
                    'message'   => 'Sale completed successfully'
                ]);

            } catch (\Exception $exception) {
                DB::rollback();
                Log::error($exception->getMessage());
                return response()->json([
                    'data'      => $exception->getMessage(),
                    'status'    => false,
                    'message'   => 'dbErrors! Please try again'
                ]);
            }
        }
    }

    /**
     * Outsource Return View Is Displayed
     */
    public function outsourceReturnDetails($id)
    {

        $order      = OrderModel::where('id', $id)->first();
        $sale       = SalesModel::select('id', 'payment_due', 'collected_payment','invoice_date')->where('order_id', $id)->first();
        $due        = SalesModel::where('order_id', $id)->where('payment_due', '>', 0)->where('is_due_paid', '0')->orderBy('id', 'DESC')->get();
        $referrals  = ReferralModel::all();
        $customerId = CustomerModel::where('phone', $order->phone_number)->first();
        $customerreferrals  = CustomersReferralsDetailsModel::select('referral_id')->where('customer_id', $customerId->id)->get();
        $paymentMethods     = PaymentMethodModel::all();
        $paymentDetails     = PaymentCollectionModel::where('order_id', $id)->where('soft_delete',0)->latest()->first();
        $orderDetails       = OrderDetailsModel::where('order_id', $id)->where('soft_delete', 0)->with(['purchase_item_barcodes','stocks'])->get();

        $data = [
            'order'             => $order,
            'orderDetails'      => $orderDetails,
            'sale'              => $sale,
            'due'               => $due,
            'referrals'         => $referrals,
            'paymentMethods'    => $paymentMethods,
            'paymentDetails'    => $paymentDetails,
            'customerreferrals'         => $customerreferrals
        ];

        return view('admin.order.outsourceReturnDetails', $data);
    }

    /**
     * Update outsource data/ Outsource Return
     */
    public function outsourceUpdate(Request $request)
    {

        $attributeNames = array(
            'first_name'    => $request->orderDetail["first_name"],
            'last_name'     => $request->orderDetail["last_name"],
            'phone_number'  => $request->orderDetail["phone_number"],
            'email'         => $request->orderDetail['email'],
            'country'       => $request->orderDetail['country'],
            'district'      => $request->orderDetail['district'],
            'city'          => $request->orderDetail['city'],
            'thana'         => $request->orderDetail['thana'],
            'area'          => $request->orderDetail['area'],
            'road_no'       => $request->orderDetail['road_no'],
            'house_no'      => $request->orderDetail['house_no'],
            'flat_no'       => $request->orderDetail['flat_no'],
            'car_no'        => $request->orderDetail['car_no'],
            'order_notes'   => $request->orderDetail["order_notes"],
        );

        $validator = Validator::make($attributeNames, [
            'first_name'    => 'required|min:1|max:256',
            'phone_number'  => 'required|regex:/(01)[0-9]{9}/'
        ]);

        if ($validator->fails()) {
            return response()->json(array('errors' => $validator->getMessageBag()->toArray()));

        } else if (!(array_key_exists('items_details_list',$request->orderDetail))) {
            return response()->json([
                'data'      => null,
                'status'    => false,
                'message'   => 'Please Insert Item!'
            ]);

        } else {

            DB::beginTransaction();

            try {
                //Create log of sales data into sale_logs table
                $salesData = SalesModel::where('order_id', $request->orderDetail["hidden_order_id"])
                    ->with('sales_due_payment')
                    ->first();
                $createdBy = $salesData['sales_by'];

                $orderData = OrderModel::where('id',$request->orderDetail["hidden_order_id"])->first();

                    $saleslog = SalesNewLog::create([
                    'sales_id'          => $salesData['id'],
                    'order_id'          => $salesData['order_id'],
                    'first_name'        => $salesData['first_name'],
                    'last_name'         => $salesData['last_name'],
                    'phone_number'      => $salesData['phone_number'],
                    'email'             => $salesData['email'],
                    'company_name'      => $salesData['company_name'],
                    'address_1'         => $salesData['address_1'],
                    'remarks'           => $orderData['remarks'],
                    'country'           => $orderData['country'],
                    'district'          => $orderData['district'],
                    'city'              => $salesData['city'],
                    'thana'             => $orderData['thana'],
                    'area'              => $orderData['area'],
                    'road_no'           => $orderData['road_no'],
                    'house_no'          => $orderData['house_no'],
                    'flat_no'           => $orderData['flat_no'],
                    'car_no'            => $orderData['car_no'],
                    'order_notes'       => $salesData['order_notes'],
                    'status'            => $salesData['status'],
                    'price'             => $salesData['price'],
                    'cost_price'        => $salesData['cost_price'],
                    'is_shipment_charge_applied' => $salesData["is_shipment_charge_applied"],
                    'discount_amount'   => $salesData['discount_amount'],
                    'advance_payment'   => $salesData['advance_payment'],
                    'collected_payment' => $salesData['collected_payment'],
                    'is_due_paid'       => $salesData['is_due_paid'],
                    'payment_due'       => $salesData['payment_due'],
                    'total_price'       => $request->orderDetail['hiddenTotalPrice'],
                    'paid_amount'       => $request->orderDetail['hiddenPaidAmount'],
                    'payment_method'    => $request->orderDetail['hiddenPaymentMethodId'],
                    'is_cancelled'      => $salesData['is_cancelled'],
                    'cancelled_by'      => $salesData['cancelled_by'],
                    'cancelled_at'      => $salesData['cancelled_at'],
                    'invoice_date'      => $salesData['invoice_date'],
                    'completed_at'      => $salesData['completed_at'],
                    'sales_by'          => $salesData['sales_by'],
                    'sales_updated_by'  => $salesData['updated_by'],
                    'created_by'        => Auth::user()->id,
                    'soft_delete'       => $salesData['soft_delete'],
                ]);


                //Create log of sale detail data into sale_detail_logs table
                $saleDetailData = SalesDetailsModel::where('order_id', $request->orderDetail["hidden_order_id"])->get();

                foreach ($saleDetailData as $data) {

                    $salesDetailsLog =
                    SalesDetailNewLog::create([
                        'sales_log_id'   => $saleslog->id,
                        'sale_detail_id' => $data['id'],
                        'product_id'     => $data['product_id'],
                        'product_name'   => $data['product_name'],
                        'quantity'       => $data['quantity'],
                        'unit_price'     => $data['unit_price'],
                        'price'          => $data['price'],
                        'cost_price'     => $data['cost_price'],
                        'details_created_by'     => $data['created_by'],
                        'details_updated_by'     => $data['updated_by'],
                        'soft_delete'    => $data['soft_delete'],
                        'created_by'     => Auth::user()->id
                    ]);
                }

                //Update data in orders table
                $orderData = [
                    'first_name'        => $request->orderDetail["first_name"],
                    'last_name'         => $request->orderDetail["last_name"],
                    'phone_number'      => $request->orderDetail["phone_number"],
                    'email'             => $request->orderDetail["email"],
                    'country'           => $request->orderDetail["country"],
                    'district'          => $request->orderDetail["district"],
                    'city'              => $request->orderDetail["city"],
                    'thana'             => $request->orderDetail["thana"],
                    'area'              => $request->orderDetail["area"],
                    'road_no'           => $request->orderDetail["road_no"],
                    'house_no'          => $request->orderDetail["house_no"],
                    'flat_no'           => $request->orderDetail["flat_no"],
                    'car_no'            => $request->orderDetail["car_no"],
                    'order_notes'       => $request->orderDetail["order_notes"],
                    'remarks'           => $request->orderDetail["remarks"],
                    'is_shipment_charge_applied' => $request->orderDetail["shippingChargeApplied"],
                    'discount_amount'   => $request->orderDetail["discountAmount"],
                    'collected_payment' => $request->orderDetail['collectedPayment'],
                    'payment_due'       => $request->orderDetail["paymentDue"],
                    'updated_by'        => strstr(Auth::user()->email, '@', true)
                ];

                if ($request->orderDetail["paymentDue"] > 0) {
                    $orderData['is_due_paid'] = 0;
                } else {
                    $orderData['is_due_paid']  = 1;
                }

                OrderModel::where(['id' => $request->orderDetail["hidden_order_id"]])->update($orderData);

                //Update data in sales table
                $data = [
                    'order_id'          => $request->orderDetail["hidden_order_id"],
                    'first_name'        => $request->orderDetail["first_name"],
                    'last_name'         => $request->orderDetail["last_name"],
                    'phone_number'      => $request->orderDetail["phone_number"],
                    'email'             => $request->orderDetail["email"],
                    'city'              => $request->orderDetail["city"],
                    'order_notes'       => $request->orderDetail["order_notes"],
                    'discount_amount'   => $request->orderDetail["discountAmount"],
                    'payment_due'       => $request->orderDetail["paymentDue"],
                    'collected_payment' => $request->orderDetail['collectedPayment'],
                    'is_shipment_charge_applied' => $request->orderDetail["shippingChargeApplied"],
                    // 'updated_by'        => Auth::user()->id
                ];

                if ($request->orderDetail["paymentDue"] > 0) {
                    $data['is_due_paid'] = 0;
                    $data['completed_at'] = null;
                } else {
                    if($salesData['completed_at'])
                    {
                        $data['completed_at'] = $salesData['completed_at'];
                    } else {
                        $data['completed_at'] = now()->toDateTimeString();
                    }

                    $data['is_due_paid']  = 1;
                }

                SalesModel::where(['order_id' => $request->orderDetail["hidden_order_id"]])->update($data);

                //empty the paid_amount in sales_due_payment as they have included in collected payment of order & sale table already.
                $hasDue = SalesDuePayment::where('sales_id', $salesData['id'])->get();
                if ($hasDue !== null) {
                    foreach ($hasDue as $prev_dues) {
                        SalesDuePaymentLog::create(
                            [
                                "sales_id" => $salesData['id'],
                                "paid_amount" => $prev_dues['paid_amount'],
                                "collected_by" => $prev_dues['collected_by'],
                                "due_collected_at" => $prev_dues['created_at']
                            ]
                        );
                    }
                    SalesDuePayment::where('sales_id', $salesData['id'])->delete();
                }

                //Delete previous item,order details data and sale details data
                foreach ($saleDetailData as $data) {
                    $item = ItemModel::where('id', $data['product_id'])->update(['soft_delete' => 1]);
                }
                SalesDetailsModel::where('order_id', $request->orderDetail["hidden_order_id"])->delete();
                OrderDetailsModel::where('order_id', $request->orderDetail["hidden_order_id"])->delete();


                //Create new item, order details data and sale details data
                for ($i = 0; $i < count($request->orderDetail["items_details_list"]); $i++) {

                    $item =  new ItemModel();
                    $item->name                  = $request->orderDetail["items_details_list"][$i]["title"];
                    $item->cost_price            = $request->orderDetail["items_details_list"][$i]["costPrice"];
                    $item->sales_price           = $request->orderDetail["items_details_list"][$i]["salesPrice"];
                    $item->is_published          = 0;
                    $item->is_outsourced         = 1;
                    $item->soft_delete           = 0;
                    $item->has_watermark         = 1;
                    $item->created_by            = $createdBy;
                    $item->updated_by            = strstr(Auth::user()->email, '@', true);
                    $item->save();

                    $orderDetails = new OrderDetailsModel();
                    $orderDetails->order_id     = $request->orderDetail["hidden_order_id"];
                    $orderDetails->product_id   = $item->id;
                    $orderDetails->product_name = $request->orderDetail["items_details_list"][$i]["title"];
                    $orderDetails->quantity     = $request->orderDetail["items_details_list"][$i]["quantity"];
                    $orderDetails->price        = $request->orderDetail["items_details_list"][$i]["totalPrice"];
                    $orderDetails->unit_price   = $request->orderDetail["items_details_list"][$i]["salesPrice"];
                    $orderDetails->cost_price   = $request->orderDetail["items_details_list"][$i]["costPrice"];
                    $orderDetails->created_by   = $createdBy;
                    $orderDetails->updated_by   = strstr(Auth::user()->email, '@', true);
                    $orderDetails->save();

                    $saleDetails = new SalesDetailsModel();
                    $saleDetails->sales_id      = $salesData->id;
                    $saleDetails->order_id      = $orderDetails->order_id;
                    $saleDetails->product_id    = $orderDetails->product_id;
                    $saleDetails->product_name  = $orderDetails->product_name;
                    $saleDetails->quantity      = $orderDetails->quantity;
                    $saleDetails->unit_price    = $orderDetails->unit_price;
                    $saleDetails->price         = $orderDetails->price;
                    $saleDetails->cost_price    = $orderDetails->cost_price;
                    $saleDetails->created_by    = $createdBy;
                    $saleDetails->updated_by    = strstr(Auth::user()->email, '@', true);
                    $saleDetails->save();

                }

                // payment method, sub-total and total insert into payment_collection table //
                $previousPayment = PaymentCollectionModel::where('order_id', $request->orderDetail["hidden_order_id"])->where('soft_delete',0)->get();
                if ($previousPayment !== null) {
                    $previousPayment_id = [
                        'order_id' => $request->orderDetail["hidden_order_id"]
                    ];
                    PaymentCollectionModel::where($previousPayment_id)->update(['soft_delete' => 1]);

                    $userMail   = strstr(Auth::user()->email, '@', true);
                    $insertA    = [];
                    $insertA['order_id']             = $request->orderDetail["hidden_order_id"];
                    $insertA['payment_method_id']    = $request->payment_method;
                    $insertA['invoice_amount']       = $request->orderDetail["totalAmountWithShipping"];
                    $insertA['total_amount']         = $request->orderDetail["collectedPayment"];
                    $insertA['payment_collected_by'] = $userMail . "(shop)";
                    PaymentCollectionModel::create($insertA);
                }

                ShipmentModel::Where(['order_id' => $request->orderDetail["hidden_order_id"]])->update([
                    'updated_by'    => strstr(Auth::user()->email, '@', true)
                ]);


                //SEND EMAIL
                $email      = $request->orderDetail["email"];
                $firstName  = $request->orderDetail["first_name"];
                $lastName   = $request->orderDetail["last_name"];
                $number     = $request->orderDetail["phone_number"];
                $orderId    = sprintf("%04s", $request->orderDetail["hidden_order_id"]);

                $address = '';
                $address .= $request->orderDetail["flat_no"] ? 'Flat no - ' . $request->orderDetail["flat_no"] . ', ' : '';
                $address .= $request->orderDetail["house_no"] ? 'House no - ' . $request->orderDetail["house_no"] . ', ' : '';
                $address .= $request->orderDetail["road_no"] ? 'Road no - ' . $request->orderDetail["road_no"] . ', ' : '';
                $address .= $request->orderDetail["area"] ? $request->orderDetail["area"] . ', ' : '';
                $address .= $request->orderDetail["thana"] ? $request->orderDetail["thana"] . ', ' : '';
                $address .= $request->orderDetail["city"] ? $request->orderDetail["city"] . ', ' : '';


                $address .= $request->orderDetail["district"] ? $request->orderDetail["district"] . ', ' : '';
                $address .= $request->orderDetail["country"] ? $request->orderDetail["country"] . ', ' : '';
                $address = trim($address);

                // add the ending '.' according to need
                if ($address != '') {
                    if ($address[strlen($address) - 1] == ',') {
                        $address[strlen($address) - 1] = '.';
                    } elseif ($address[strlen($address) - 1] != '.') {
                        $address .= '.';
                    }
                }

                DB::commit();

                // if ($email != null && $email != "") {
                //     $orderInfo           = OrderModel::findOrFail($orderId);
                //     $orderDetailsInfo    = OrderDetailsModel::where('order_id',$orderId)->where('soft_delete',0)->get();
                //     Mail::to($email)->send(new PosSaleMail($firstName, $lastName, $email, $number, $address, $orderId, $orderInfo, $orderDetailsInfo));
                // }

                return response()->json(array("message" => "Success", 200));

            } catch (\Exception $exception) {
                DB::rollback();
                Log::error($exception->getMessage());
                return response()->json(array('dbErrors' => $exception->getMessage()));
            }
        }

    }


    public function testMail()
    {
        try{
            $response = Mail::to('mishu.das35bng@gmail.com')->send(new OrderConfirmationMail("Mishu", "Das", "mishu.das35bng@gmail.com", "01881642905", "Feringee Bazar", 1));
            return response()->json([
                'status' => true,
                'data' => $response
            ]);
        } catch (\Exception $exception)
        {
            Log::error($exception->getMessage());
            return response()->json(array('dbErrors' => $exception->getMessage()));
        }
    }

    //all information for matching user to autofill on the sale page
    public function getUserDataToAutofill(Request $request)
    {
        // $users = User::all();
        $users = CustomerModel::where('phone', '=', $request->mble_num)->first();
        $referrals = null;
        if (isset($users->id)) {
            $referrals = CustomersReferralsDetailsModel::select('referral_id')->where('customer_id', $users->id)->get();
        }

        $data = [
            'allUsers' => $users,
            'referrals' => $referrals,
        ];

        return response()->json(['data' => $data]);

    }

    /**
     * @param Request $request
     * Autocomplete phone number search
     */
    public function searchPhoneNumber(Request $request)
    {
        $search = $request->term;
        $phone_numbers = CustomerModel::where('phone', 'LIKE', '%' . $search . '%')
                            ->where('soft_delete', 0)
                            ->OrderBy('id','DESC')
                            ->get();

        if (!$phone_numbers->isEmpty()) {
            foreach ($phone_numbers as $phone) {
                $new_row['phone']    = $phone->phone;
                $row_set[] = $new_row; //build an array
            }

        }

        return response()->json($row_set);
    }




    public function getPriorityDetails(Request $request)
    {
        $priority = ShipmentModel::where('id', $request->id)->first();
        return response()->json($priority);
    }


    public function priorityUpdate(Request $request)
    {
        $priority_update = ShipmentModel::findOrFail($request->id);
        $attributeNames = array(
            'priority' => $request->priority
        );

        $validator = Validator::make($attributeNames, [

        ]);

        if ($validator->fails()) {
            return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        } else {
            $priority_update->priority = $request->priority;
            $priority_update->update();

            return response()->json("Success");
        }
    }


    public function refundView()
    {
        return view('admin.pos.refundDetails');
    }


    /**
     * Update sales data/ Sales Return
     */
    public function salesUpdate(Request $request)
    {
        // dd('all',$request->all());
        // dd($request->orderDetail["collectedPayment"]);
        $attributeNames     = array(
            'first_name'    => $request->orderDetail["first_name"],
            'last_name'     => $request->orderDetail["last_name"],
            'phone_number'  => $request->orderDetail["phone_number"],
            'email'         => $request->orderDetail['email'],
            'country'       => $request->orderDetail['country'],
            'district'      => $request->orderDetail['district'],
            'city'          => $request->orderDetail['city'],
            'thana'         => $request->orderDetail['thana'],
            'area'          => $request->orderDetail['area'],
            'road_no'       => $request->orderDetail['road_no'],
            'house_no'      => $request->orderDetail['house_no'],
            'flat_no'       => $request->orderDetail['flat_no'],
            'car_no'        => $request->orderDetail['car_no']
        );

        $validator = Validator::make($attributeNames, [
            'first_name'    => 'required|min:1|max:256',
            'phone_number'  => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        } else {
            $uniqueId = uniqid('ORD');
            DB::beginTransaction();

            try {

                //Create log of sales data into sale_logs table
                $salesData = SalesModel::where('order_id', $request->orderDetail["hidden_order_id"])
                    ->with('sales_due_payment')
                    ->first();

                $orderData = OrderModel::where('id',$request->orderDetail["hidden_order_id"])->first();

                    $saleslog = SalesNewLog::create([
                    'sales_id'          => $salesData['id'],
                    'order_id'          => $salesData['order_id'],
                    'first_name'        => $salesData['first_name'],
                    'last_name'         => $salesData['last_name'],
                    'phone_number'      => $salesData['phone_number'],
                    'email'             => $salesData['email'],
                    'company_name'      => $salesData['company_name'],
                    'address_1'         => $salesData['address_1'],
                    'remarks'           => $orderData['remarks'],
                    'country'           => $orderData['country'],
                    'district'          => $orderData['district'],
                    'city'              => $salesData['city'],
                    'thana'             => $orderData['thana'],
                    'area'              => $orderData['area'],
                    'road_no'           => $orderData['road_no'],
                    'house_no'          => $orderData['house_no'],
                    'flat_no'           => $orderData['flat_no'],
                    'car_no'            => $orderData['car_no'],
                    'order_notes'       => $salesData['order_notes'],
                    'status'            => $salesData['status'],
                    'price'             => $salesData['price'],
                    'cost_price'        => $salesData['cost_price'],
                    'is_shipment_charge_applied' => $salesData["is_shipment_charge_applied"],
                    'discount_amount'   => $salesData['discount_amount'],
                    'advance_payment'   => $salesData['advance_payment'],
                    'collected_payment' => $salesData['collected_payment'],
                    'is_due_paid'       => $salesData['is_due_paid'],
                    'payment_due'       => $salesData['payment_due'],
                    'total_price'       => $request->orderDetail['hiddenTotalPrice'],
                    'paid_amount'       => $request->orderDetail['hiddenPaidAmount'],
                    'payment_method'    => $request->orderDetail['hiddenPaymentMethodId'],
                    'is_cancelled'      => $salesData['is_cancelled'],
                    'cancelled_by'      => $salesData['cancelled_by'],
                    'cancelled_at'      => $salesData['cancelled_at'],
                    'invoice_date'      => $salesData['invoice_date'],
                    'completed_at'      => $salesData['completed_at'],
                    'sales_by'          => $salesData['sales_by'],
                    'sales_updated_by'  => $salesData['updated_by'],
                    'created_by'        => Auth::user()->id,
                    'soft_delete'       => $salesData['soft_delete'],
                ]);


                //Create log of sale detail data into sale_detail_logs table
                $saleDetailData = SalesDetailsModel::where('order_id', $request->orderDetail["hidden_order_id"])->get();

                foreach ($saleDetailData as $data) {

                    $salesDetailsLog =
                    SalesDetailNewLog::create([
                        'sales_log_id'   => $saleslog->id,
                        'sale_detail_id' => $data['id'],
                        'product_id'     => $data['product_id'],
                        'barcode_id'     => $data['barcode_id'],
                        'product_name'   => $data['product_name'],
                        'quantity'       => $data['quantity'],
                        'unit_price'     => $data['unit_price'],
                        'price'          => $data['price'],
                        'cost_price'     => $data['cost_price'],
                        'details_created_by'     => $data['created_by'],
                        'details_updated_by'     => $data['updated_by'],
                        'soft_delete'    => $data['soft_delete'],
                        'created_by'     => Auth::user()->id
                    ]);
                }

                //Update data in orders table
                $where = [
                    'id' => $request->orderDetail["hidden_order_id"]
                ];

                $previouseDuePaid = $salesData->sales_due_payment->sum('paid_amount');

                $data = [
                    'first_name'        => $request->orderDetail["first_name"],
                    'last_name'         => $request->orderDetail["last_name"],
                    'phone_number'      => $request->orderDetail["phone_number"],
                    'email'             => $request->orderDetail["email"],
                    'country'           => $request->orderDetail["country"],
                    'district'          => $request->orderDetail["district"],
                    'city'              => $request->orderDetail["city"],
                    'thana'             => $request->orderDetail["thana"],
                    'area'              => $request->orderDetail["area"],
                    'road_no'           => $request->orderDetail["road_no"],
                    'house_no'          => $request->orderDetail["house_no"],
                    'flat_no'           => $request->orderDetail["flat_no"],
                    'car_no'            => $request->orderDetail["car_no"],
                    'order_notes'       => $request->orderDetail["order_notes"],
                    'discount_amount'   => $request->orderDetail["discountAmount"],
                    'payment_due'       => $request->orderDetail["paymentDue"],
                    'collected_payment' => $request->orderDetail['collectedPayment'],
                    'remarks'           => $request->orderDetail["remarks"],
                    'is_shipment_charge_applied' => $request->orderDetail["shippingChargeApplied"],


                    // 'collected_payment' => $salesData['collected_payment'] + $previouseDuePaid, //(when sales with dues used to show at completed sales list)collected at sale + the total due paid before for this sale
                    // 'customer_notes'     => $request->orderDetail["customer_notes"],
                    // 'advance_payment'    => $request->orderDetail["advanced_payment"]
                ];

                if ($request->orderDetail["paymentDue"] > 0) {
                    $data['is_due_paid'] = 0;
                } else {
                    $data['is_due_paid']  = 1;
                }

                OrderModel::where($where)->update($data);

                //Update data in sales table
                $where = [
                    'order_id' => $request->orderDetail["hidden_order_id"]
                ];

                $data = [
                    'order_id'          => $request->orderDetail["hidden_order_id"],
                    'first_name'        => $request->orderDetail["first_name"],
                    'last_name'         => $request->orderDetail["last_name"],
                    'phone_number'      => $request->orderDetail["phone_number"],
                    'email'             => $request->orderDetail["email"],
                    'city'              => $request->orderDetail["city"],
                    'order_notes'       => $request->orderDetail["order_notes"],
                    'discount_amount'   => $request->orderDetail["discountAmount"],
                    'payment_due'       => $request->orderDetail["paymentDue"],
                    'collected_payment' => $request->orderDetail['collectedPayment'],
                    'is_shipment_charge_applied' => $request->orderDetail["shippingChargeApplied"],


                    // 'collected_payment' => $salesData['collected_payment'] + $previouseDuePaid, //(when sales with dues used to show at completed sales list)collected at sale + the total due paid before for this sale
                    // 'advance_payment'=> $request->orderDetail["advanced_payment"],

                ];

                if ($request->orderDetail["paymentDue"] > 0) {
                    $data['is_due_paid'] = 0;
                    $data['completed_at'] = null;
                } else {
                    if($salesData['completed_at'])
                    {
                        $data['completed_at'] = $salesData['completed_at'];
                    } else {
                        $data['completed_at'] = now()->toDateTimeString();
                    }

                    $data['is_due_paid']  = 1;
                }

                SalesModel::where($where)->update($data);

                //empty the paid_amount in sales_due_payment as they have included in collected payment of order & sale table already.
                $hasDue = SalesDuePayment::where('sales_id', $salesData['id'])->get();
                if ($hasDue !== null) {
                    foreach ($hasDue as $prev_dues) {
                        SalesDuePaymentLog::create(
                            [
                                "sales_id" => $salesData['id'],
                                "paid_amount" => $prev_dues['paid_amount'],
                                "collected_by" => $prev_dues['collected_by'],
                                "due_collected_at" => $prev_dues['created_at']
                            ]
                        );
                    }
                    SalesDuePayment::where('sales_id', $salesData['id'])->delete();
                }

                //increment previous items quantity in stock table
                $previousProducts = SalesDetailsModel::where('order_id', $request->orderDetail["hidden_order_id"])->get();
                foreach ($previousProducts as $product) {
                    $barcodeId = $product->barcode_id;
                    $quantity = $product->quantity;

                    StockModel::where('item_barcodes_id', $barcodeId)
                        ->increment('quantity', $quantity);

                    //keeping track of sold items
                    // $sold = SoldItemTrack::where(['purchase_item_barcodes_id' => $barcodeId]);
                    // if ($sold->exists()) {
                    //     $query     = $sold->select('sold_quantity')->first();
                    //     $sold_quan = $query['sold_quantity'] - $product->quantity;
                    //     $sold->update([ 'sold_quantity' => $sold_quan ]);

                    // }
                }

                //Delete previous order details data and sale details data
                SalesDetailsModel::where('order_id', $request->orderDetail["hidden_order_id"])->delete();
                OrderDetailsModel::where('order_id', $request->orderDetail["hidden_order_id"])->delete();


                //Create new order details data and sale details data
                for ($i = 0; $i < count($request->orderDetail["items_details_list"]); $i++) {
                    $barcodeId = $request->orderDetail["items_details_list"][$i]["barcode_id"];
                    $barcodeDetails = PurchaseItemBarcode::where('id',$barcodeId)->with(['item','purchase_details'])->first();

                    $orderDetails = new OrderDetailsModel();
                    $orderDetails->order_id = $request->orderDetail["hidden_order_id"];
                    $orderDetails->product_id = $barcodeDetails->item->id;
                    $orderDetails->barcode_id = $barcodeId;
                    $orderDetails->product_name = $request->orderDetail["items_details_list"][$i]["title"];
                    $orderDetails->quantity = $request->orderDetail["items_details_list"][$i]["quantity"];
                    $orderDetails->price = $request->orderDetail["items_details_list"][$i]["price"] * $request->orderDetail["items_details_list"][$i]["quantity"];
                    $orderDetails->unit_price = $request->orderDetail["items_details_list"][$i]["price"];
                    $orderDetails->cost_price = $barcodeDetails->purchase_details->cost_price;
                    $orderDetails->created_by = "shop";
                    $orderDetails->updated_by = "shop";
                    $orderDetails->save();

                    $saleDetails = new SalesDetailsModel();
                    $saleDetails->sales_id = $salesData['id'];
                    $saleDetails->order_id = $orderDetails->order_id;
                    $saleDetails->product_id = $orderDetails->product_id;
                    $saleDetails->barcode_id = $barcodeId;
                    $saleDetails->product_name = $orderDetails->product_name;
                    $saleDetails->quantity = $orderDetails->quantity;
                    $saleDetails->price = $orderDetails->price;
                    $saleDetails->unit_price = $orderDetails->unit_price;
                    $saleDetails->cost_price = $orderDetails->cost_price;
                    $saleDetails->soft_delete = 0;
                    $saleDetails->created_by = $salesData['created_by'];
                    $saleDetails->updated_by = Auth::user()->first_name;
                    $saleDetails->save();

                    StockModel::where('item_barcodes_id', $barcodeId)
                        ->decrement('quantity', $request->orderDetail["items_details_list"][$i]["quantity"]);

                    //keeping track of sold items
                    // $sold = SoldItemTrack::where(['purchase_item_barcodes_id' => $barcodeId]);

                    // if ($sold->exists()) {
                    //     $query     = $sold->select('sold_quantity')->first();
                    //     $sold_quan = $query['sold_quantity'] + $request->orderDetail["items_details_list"][$i]["quantity"];
                    //     $sold->update([ 'sold_quantity' => $sold_quan ]);

                    // } else {
                    //     SoldItemTrack::create([
                    //         'item_id' => $orderDetails->product_id,
                    //         'purchase_item_barcodes_id' => $barcodeId,
                    //         'sold_quantity' => $request->orderDetail["items_details_list"][$i]["quantity"]

                    //     ]);
                    // }

                    //create log of current stock
                    // SalesDetailNewLog::where('id',$salesDetailsLog->id)
                    //                     ->update([
                    //                         'stock' => $request->orderDetail["items_details_list"][$i]["stock_for_log"],
                    //                         'regular_price' => $request->orderDetail["items_details_list"][$i]["regular_price_for_log"]
                    //                     ]);

                }

                ShipmentModel::where('order_id', $request->orderDetail["hidden_order_id"])
                                ->where('soft_delete', 0)
                                ->update(['updated_by' => Auth::user()->first_name]);


                //SEND EMAIL
                $email = $request->orderDetail["email"];
                $firstName = $request->orderDetail["first_name"];
                $lastName = $request->orderDetail["last_name"];
                $number = $request->orderDetail["phone_number"];
                $orderId = sprintf("%04s", $salesData['order_id']);

                $address = '';
                $address .= $request->orderDetail["flat_no"] ? 'Flat no - ' . $request->orderDetail["flat_no"] . ', ' : '';
                $address .= $request->orderDetail["house_no"] ? 'House no - ' . $request->orderDetail["house_no"] . ', ' : '';
                $address .= $request->orderDetail["road_no"] ? 'Road no - ' . $request->orderDetail["road_no"] . ', ' : '';
                $address .= $request->orderDetail["area"] ? $request->orderDetail["area"] . ', ' : '';
                $address .= $request->orderDetail["thana"] ? $request->orderDetail["thana"] . ', ' : '';
                $address .= $request->orderDetail["city"] ? $request->orderDetail["city"] . ', ' : '';

                $address .= $request->orderDetail["district"] ? $request->orderDetail["district"] . ', ' : '';
                $address .= $request->orderDetail["country"] ? $request->orderDetail["country"] . ', ' : '';
                $address = trim($address);

                // add the ending '.' according to need
                if ($address != '') {
                    if ($address[strlen($address) - 1] == ',') {
                        $address[strlen($address) - 1] = '.';
                    } elseif ($address[strlen($address) - 1] != '.') {
                        $address .= '.';
                    }
                }


                // payment method, sub-total and total insert into payment_collection table //
                $previousPayMethod = PaymentCollectionModel::where('order_id', $salesData['order_id'])->where('soft_delete',0)->get();
                if ($previousPayMethod !== null) {
                    $prePayMethod_id = [
                        'order_id' => $salesData['order_id']
                    ];
                    PaymentCollectionModel::where($prePayMethod_id)->update(['soft_delete' => 1]);

                    $userName   = Auth::user()->first_name;
                    $insertA    = [];
                    $insertA['order_id']             = $salesData['order_id'];
                    $insertA['payment_method_id']    = $request->payment_method;
                    $insertA['invoice_amount']       = $request->orderDetail["totalAmountWithShipping"];
                    $insertA['total_amount']         = $request->orderDetail["collectedPayment"];
                    $insertA['payment_collected_by'] = $userName . "(shop)";
                    PaymentCollectionModel::create($insertA);

                    // $insertA['invoice_amount']    = $request->orderDetail['totalAmount'];
                    // $insertA['total_amount']      = $request->orderDetail['totalAmount'] + $request->orderDetail['shippingChargeApplied'];
                }


                DB::commit();
                $mobileNumber = $number;


                //                $message = "Dear Subscriber, Your sale has been updated successfully.";
                //                $message = str_replace(' ', '%20', $message);
                //                $ch = curl_init();
                //                curl_setopt($ch, CURLOPT_URL, "http://sms.sslwireless.com/pushapi/dynamic/server.php?user=Technocore&pass=54N182s@&sid=cloudoneEng&sms=$message&msisdn=$mobileNumber&csmsid=123456789");
                //                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                //                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
                //                $data = curl_exec($ch);
                //                curl_close($ch);

                // if ($email != null && $email != "") {
                //     $orderInfo           = OrderModel::findOrFail($orderId);
                //     $orderDetailsInfo    = OrderDetailsModel::where('order_id',$orderId)->where('soft_delete',0)->get();
                //     Mail::to($email)->send(new PosSaleMail($firstName, $lastName, $email, $number, $address, $orderId, $orderInfo, $orderDetailsInfo));
                // }

                return response()->json(array("message" => "Success", 200));
            } catch (\Exception $exception) {
                DB::rollback();
                return response()->json(array('dbErrors' => $exception->getMessage()));
            }
        }
    }

    public function cancelSale(Request $request)
    {
        DB::beginTransaction();
        try {
            //update in sales table
            $sale = SalesModel::where('order_id',$request->id)->first();
            $sale->is_cancelled = 1;
            $sale->cancelled_by = Auth::user()->first_name;
            $sale->cancelled_at = date("Y-m-d H:i:s");
            $sale->update();

            //update in orders table
            $order = OrderModel::findOrFail($request->id);
            $order->is_rejected = 1;
            $order->rejected_by = Auth::user()->first_name;
            $order->rejected_at = date("Y-m-d H:i:s");
            $order->update();

            //increment items quantity in stock table
            $products = SalesDetailsModel::where('order_id',$request->id)->get();

            foreach( $products as $product){

                $productId  = $product->product_id;

                $barcodeId  = $product->barcode_id;
                $quantity   = $product->quantity;

                StockModel::where([
                        'item_barcodes_id' => $barcodeId,
                        'item_id' => $productId,
                    ])->increment('quantity', $quantity);

                //keeping track of sold items
                // $sold = SoldItemTrack::where(['purchase_item_barcodes_id' => $barcodeId]);

                // if ($sold->exists()) {
                //     $query     = $sold->select('sold_quantity')->first();
                //     $sold_quan = $query['sold_quantity'] - $product->quantity;
                //     $sold->update([ 'sold_quantity' => $sold_quan ]);

                // }

            }

            //update in shipment table
            $shipment = ShipmentModel::where('order_id',$request->id)->first();
            $shipment->soft_delete = 1;
            $shipment->update();

            //removing from payment_collection table
            $paymentCancel = PaymentCollectionModel::where('order_id', $request->id)->where('soft_delete',0)->first();
            $paymentCancel->soft_delete = 1;
            $paymentCancel->update();

            //hamida check first if there is booking exists or not
            //cancelling the booking from bookings table
            if (Booking::where('sale_id', $request->saleId)->where('soft_delete', 0)->exists()){
                $bookingCancel = Booking::where('sale_id', $request->saleId)->first();
                $bookingCancel->status = 4;
                $bookingCancel->soft_delete = 1;
                $bookingCancel->update();

                //removing from advance_payments table
                $paymentCancel = AdvancePayment::where('booking_id', $bookingCancel->id)->where('soft_delete', 0)->first();
                $paymentCancel->soft_delete = 1;
                $paymentCancel->update();
            }


            DB::commit();
            return response()->json("Success");
        } catch (\Exception $exception) {
            DB::rollback();
            return response()->json(array('dbErrors' => $exception->getMessage()));
        }

    }


    public function salesLogView()
    {
        return view('admin.pos.saleLogView');
    }

    function listSalesView()
    {
        $salesLogData = SalesNewLog::orderBy('updated_at', 'desc');

        // $salesLogData = SalesNewLog::whereIn('id', function ($query) {
        //     $query->selectRaw('MAX(id)')
        //         ->from('sales_new_logs')
        //         ->groupBy('sales_id');
        // })
        // ->orderBy('updated_at', 'desc');

        return Datatables::of($salesLogData)
            ->addColumn('action', function ($saleNewLog) {
                return '<a target="_blank" href="' . route('sale_logs.view-details', $saleNewLog->id) . '"><button class="btn btn-success btn-xs">
                            <i class="fa fa-info-circle"></i> Show Details
                                </button></a>';

                        // <button class="btn btn-info btn-xs" title="Present Details" onclick="window.open(`'.url('completedOrderDetailsView/'.$saleNewLog->order_id).'`)"></i>Present</button>';
            })
            // ->addColumn('customer_name', function ($saleNewLog) {
            //     return $saleNewLog->first_name.' '.$saleNewLog->last_name;
            // })
            ->addColumn('created_by', function ($saleNewLog) {
                return $saleNewLog->user->first_name;
            })
            ->rawColumns(['action'])
            ->make(true);
        // return view('admin.pos.saleLogView',$data);
    }

    public function viewSalesLogsDetails($id)
    {
        $saleLog            = SalesNewLog::where('id', $id)->first();
        $saleDetailsLog     = SalesDetailNewLog::where('sales_log_id', $id)->with(['purchase_item_barcodes_log'])->get();
        $paymentMethods     = PaymentMethodModel::all();
        $referrals          = ReferralModel::all();
        $customerId         = CustomerModel::where('phone', $saleLog->phone_number)->first();
        $customerreferrals  = CustomersReferralsDetailsModel::select('referral_id')->where('customer_id', $customerId->id)->get();

        /**
         * for present sales view
         */
        $order              = OrderModel::where('id', $saleLog->order_id)->first();
        $sale               = SalesModel::select('id', 'payment_due', 'collected_payment','invoice_date','created_at','updated_at', 'sales_by', 'advance_payment')->where('order_id', $saleLog->order_id)->first();
        $due                = SalesModel::where('order_id', $saleLog->order_id)->where('payment_due', '>', 0)->where('is_due_paid', '0')->orderBy('id', 'DESC')->get();
        $paymentDetails     = PaymentCollectionModel::where('order_id', $saleLog->order_id)->where('soft_delete',0)->latest()->first();
        $orderDetails       = OrderDetailsModel::where('order_id', $saleLog->order_id)->where('soft_delete', 0)->with(['purchase_item_barcodes','stocks'])->get();
        $booking            = Booking::select('advance_payment','created_by', 'created_at')->where('sale_id', $saleLog->sales_id)->get();
        
        // $saleNewLogs = SalesNewLog::where('sales_id', $saleLog->sales_id)->orderBy('created_at', 'asc')->get();

        // $allPayments  = DB::table('sales_due_payment')
        //     ->where('sales_id', $sale->id)
        //     ->select('paid_amount','collected_by','created_at', DB::raw("'sales_due_payment' as source_table"), DB::raw('NULL as due_collected_at'))
        //     ->union(
        //         DB::table('sales_due_payment_log')
        //             ->where('sales_id', $sale->id)
        //             ->select(
        //                 'paid_amount','collected_by','created_at', DB::raw("'sales_due_payment_log' as source_table"),'due_collected_at'
        //             )
        //     )
        //     ->orderBy('created_at', 'asc') 
        //     ->get();
        
        // $userIds = $allPayments->pluck('collected_by')->unique()->filter();
        // $users = User::whereIn('id', $userIds)->select('id', 'first_name', 'last_name')->get()->keyBy('id');

        // $allPayments->transform(function ($payment) use ($users) {
        //     $payment->collected_by_user = $users[$payment->collected_by] ?? null;
        //     return $payment;
        // });

        $data = [
            'saleLog'           => $saleLog,
            'saleDetailsLog'    => $saleDetailsLog,
            'referrals'         => $referrals,
            'paymentMethods'    => $paymentMethods,
            'customerreferrals' => $customerreferrals,


            'order'             => $order,
            'orderDetails'      => $orderDetails,
            'sale'              => $sale,
            'due'               => $due,
            'paymentDetails'    => $paymentDetails,
            // 'allPayments'       => $allPayments,
            // 'saleNewLogs'       => $saleNewLogs,
            // 'booking'           => $booking
        ];

        return view('admin.pos.saleLogDetails', $data);

    }

    public function dueCollectionHistoryView()
    {
        return view('admin.pos.salesPaymentHistoryView');
    }

    function listAllDueSalesView()
    {
        $allSalesData = SalesModel::with('sales_due_payment')
            ->where('payment_due', '>', 0)
            ->where('is_cancelled', 0)
            // ->orderBy('updated_at', 'desc')
            ->select([
                'id',
                'order_id',
                'first_name',
                'last_name',
                'phone_number',
                'city',
                'is_due_paid',
                'payment_due'

            ]);
        
        return Datatables::of($allSalesData)
        
            ->addIndexColumn()
            ->addColumn('customer_name', function ($allSales) {
                return '<a class="custom_textDecoration" href="' . route('due_collection_history.view-details', $allSales->id) . '" style="cursor: pointer;">' 
                       . e($allSales->first_name . ' ' . $allSales->last_name) . 
                       '</a>';
            })
            ->filterColumn('customer_name', function($query, $keyword) {
                $query->whereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ["%$keyword%"])
                      ->orWhere('first_name', 'LIKE', "%$keyword%")
                      ->orWhere('last_name', 'LIKE', "%$keyword%");
            })           
            ->addColumn('invoice_id', function ($allSales) {
                return '#0202' . $allSales->order_id;
            })
            ->filterColumn('invoice_id', function($query, $keyword) {
                $query->whereRaw("CONCAT('#0202', sales.order_id) LIKE ?", ["%{$keyword}%"]);
            })
            ->orderColumn('invoice_id', function ($query, $order) {
                $query->orderByRaw("CAST(order_id AS UNSIGNED) $order");
            })
            ->addColumn('due', function ($allSales) {
                return $allSales->payment_due - $allSales->sales_due_payment->sum('paid_amount');
            })
            ->orderColumn('due', function ($query, $direction) {
                $query->orderByRaw("(payment_due - (SELECT COALESCE(SUM(paid_amount), 0) FROM sales_due_payment WHERE sales_due_payment.sales_id = sales.id)) $direction");
            })
            ->addColumn('is_due_paid', function ($allSales) {
                return $allSales->is_due_paid ? "completed" : "pending";
            })
            ->orderColumn('is_due_paid', function ($query, $order) {
                $query->orderBy('is_due_paid', $order);
            })
            ->addColumn('invoice', function ($allSales) {
                return '<a onclick="invoiceModal(' . $allSales->order_id . ')" style="padding: 5px 10px;color: #fff;cursor: pointer;" class="btn badge badge-primary" data-toggle="tooltip" title="" data-original-title="Invoice">Invoice</a>';
            })
            ->addColumn('action', function ($allSales) {
                return '<a target="_blank" href="' . route('due_collection_history.view-details', $allSales->id) . '"><button class="btn btn-secondary" btn-xs">
                            <i class="fa fa-info-circle"></i> Details
                                </button></a>';
            })
            ->rawColumns(['action','customer_name','invoice'])
            ->make(true);
    }

    public function viewDueSalesPaymentHistory($id)
    {
        $sale               = SalesModel::where('id', $id)->first();
        $booking            = Booking::select('advance_payment','created_by', 'created_at')->where('sale_id', $sale->id)->get();
        $saleNewLogs        = SalesNewLog::where('sales_id', $sale->id)->orderBy('created_at', 'asc')->get();
        $order              = OrderModel::where('id', $sale->order_id)->first();

        $allPayments  = DB::table('sales_due_payment')
            ->where('sales_id', $sale->id)
            ->select('paid_amount','collected_by','created_at', DB::raw("'sales_due_payment' as source_table"), DB::raw('NULL as due_collected_at'))
            ->union(
                DB::table('sales_due_payment_log')
                    ->where('sales_id', $sale->id)
                    ->select(
                        'paid_amount','collected_by','created_at', DB::raw("'sales_due_payment_log' as source_table"),'due_collected_at'
                    )
            )
            ->orderBy('created_at', 'asc') 
            ->get();

        $userIds = $allPayments->pluck('collected_by')->unique()->filter();
        $users = User::whereIn('id', $userIds)->select('id', 'first_name', 'last_name')->get()->keyBy('id');

        $allPayments->transform(function ($payment) use ($users) {
            $payment->collected_by_user = $users[$payment->collected_by] ?? null;
            return $payment;
        });

        $data = [
            'order'             => $order,
            'sale'              => $sale,
            'allPayments'       => $allPayments,
            'saleNewLogs'       => $saleNewLogs,
            'booking'           => $booking
        ];
        return view('admin.pos.viewSalesPaymentHistory', $data);

    }









    public function CreateDataForSoldItemTrackTableOfAlreadyPlacedSale(){
        $alreadyCompletedOrders = OrderDetailsModel::where('soft_delete',0)->whereNotNull('barcode_id')->get();
        dd("hello");
        $count = 0;
        foreach ($alreadyCompletedOrders as $order) {
            $barcodeId = $order->barcode_id;
            $alreadySoldQuanity = $order->quantity;
            $itemId = $order->product_id;

            //keeping track of sold items
            // $sold = SoldItemTrack::where(['purchase_item_barcodes_id' => $barcodeId]);

            // if ($sold->exists()) {
            //     $query     = $sold->select('sold_quantity')->first();
            //     $sold_quan = $query['sold_quantity'] + $alreadySoldQuanity;
            //     $sold->update([ 'sold_quantity' => $sold_quan ]);

            // } else {
            //     SoldItemTrack::create([
            //         'item_id' => $itemId,
            //         'purchase_item_barcodes_id' => $barcodeId,
            //         'sold_quantity' => $alreadySoldQuanity

            //     ]);
            // }
            $count++;
        }
        return response()->json([
            'data' => $count,
            'status' => true,
            'message' => 'Successful'
        ]);

    }

}
