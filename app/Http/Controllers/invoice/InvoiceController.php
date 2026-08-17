<?php

namespace App\Http\Controllers\invoice;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\OrderModel;
use App\OrderDetailsModel;
use App\sales\SalesDetailsModel;
use App\sales\SalesModel;
use App\stock\StockModel;
use App\deliveryCharge\DeliveryChargeModel;
use App\SalesDuePayment\SalesDuePayment;
use App\User;



class InvoiceController extends Controller
{


     /**
     * @name invoicePrintView
     * @role invoiceView view
     * @param
     * @return view with compact array
     *
     */
    public function invoicePrintView($id){
         $orderInfo           = OrderModel::findOrFail($id);
         $orderDetailsInfo    = OrderDetailsModel::where('order_id',$id)->where('soft_delete',0)->get();
         $shippingCharge      = DeliveryChargeModel::where('name','shippingcharge')->first();

         $data = [
          'orderInfo'         => $orderInfo,
          'orderDetailsInfo'  => $orderDetailsInfo,
          'shippingCharge'    => $shippingCharge
         ];

         return view('admin.invoice.invoiceView',$data);
    }


    public function invoicePrintViewUser($id){
     $orderInfo           = OrderModel::findOrFail($id);

     $orderDetailsInfo    = OrderDetailsModel::where('order_id',$id)->where('soft_delete',0)->get();

     $shippingCharge      = DeliveryChargeModel::where('name','shippingcharge')->first();

     $salesDetails = SalesModel::where('order_id',$id)->select('invoice_date')->first();

     $invoiceDate = null;
     if($salesDetails){
         $invoiceDate = $salesDetails['invoice_date'];
     }
     if($orderInfo->sales){

          $totalPaid = SalesDuePayment::where('sales_id',$orderInfo->sales->id)->sum('paid_amount');
          $payment_due = $orderInfo->payment_due - $totalPaid ;

     }

     $data = [
      'orderInfo'         => $orderInfo,
      'orderDetailsInfo'  => $orderDetailsInfo,
      'shippingCharge'    => $shippingCharge,
      'totalPaid'         => @$totalPaid,
      'payment_due'       => @$payment_due,
      'invoice_date'       => $invoiceDate,
     ];

     return view('shop.invoice',$data);
     }



     //admin_sales-invoice
    public function salesInvoicePrintViewUser($id){
     $orderInfo           = OrderModel::findOrFail($id);
     $orderDetailsInfo    = OrderDetailsModel::where('order_id',$id)->where('soft_delete',0)->get();
     $shippingCharge      = DeliveryChargeModel::where('name','shippingcharge')->first();

     $data = [
      'orderInfo'         => $orderInfo,
      'orderDetailsInfo'  => $orderDetailsInfo,
      'shippingCharge'    => $shippingCharge
     ];

     return view('shop.salesInvoiceView',$data);
     }




    public function searchInvoiceAdmin(Request $request){

          $search = $request->term;

          $invoices = OrderModel::where('phone_number', 'LIKE', '%' . $search . '%')
                              ->orWhere('first_name', 'LIKE', '%' . $search . '%')
                              ->orWhere('last_name', 'LIKE', '%' . $search . '%')
                              ->orWhere('email', 'LIKE', '%' . $search . '%')
                              ->orWhere('car_no', 'LIKE', '%' . $search . '%')
                              ->orWhere('order_code', 'LIKE', '%' . $search . '%')
                              ->orWhere('id', 'LIKE', '%' . ltrim($search, '0') . '%')
                              ->where('soft_delete', 0)
                              ->OrderBy('id','DESC')
                              ->get();




		if (!$invoices->isEmpty()) {
			// dd($invoices);
			foreach ($invoices as $invoice) {

				$new_row['id']    = $invoice->id;

                    if($invoice->status == 0){
                         $new_row['status'] = "Ongoing";
                    }
                    else{
                         $new_row['status'] = "Completed";
                    }

                    $new_row['order_code'] = sprintf('%04s', $invoice->id);
				$new_row['name'] = $invoice->first_name.' '.$invoice->last_name;
                    $new_row['url'] = url('orderDetailsView/' . $invoice->id);
                    $new_row['created_at'] = $invoice->created_at;
                    $new_row['address'] = "";

                    $new_row['address'] .= $invoice->area ? $invoice->area . ", " : '';
                    $new_row['address'] .= $invoice->city ? $invoice->city : '';
                    rtrim($new_row['address'], ',');
                    $new_row['address'] .= ".";


				$row_set[] = $new_row; //build an array
			}
		}

		return response()->json($row_set);

    }


    //autofill user information on the sale page
    public function autoFill(Request $request){

          $users = User::where('email', '=', $request->input('email'))->first();
          if ($users === null) {
               // User does not exist
          } else {
               // User exits
          }

    }


    //EINVOICE 
    public function eInvoiceView($id){

     $orderInfo           = OrderModel::findOrFail($id);

     $orderDetailsInfo    = OrderDetailsModel::where('order_id',$id)->where('soft_delete',0)->get();

     $shippingCharge      = DeliveryChargeModel::where('name','shippingcharge')->first();

     $salesDetails = SalesModel::where('order_id',$id)->select('invoice_date')->first();

     $invoiceDate = null;
     if($salesDetails){
         $invoiceDate = $salesDetails['invoice_date'];
     }
     if($orderInfo->sales){

          $totalPaid = SalesDuePayment::where('sales_id',$orderInfo->sales->id)->sum('paid_amount');
          $payment_due = $orderInfo->payment_due - $totalPaid ;

     }

     $data = [
      'orderInfo'         => $orderInfo,
      'orderDetailsInfo'  => $orderDetailsInfo,
      'shippingCharge'    => $shippingCharge,
      'totalPaid'         => @$totalPaid,
      'payment_due'       => @$payment_due,
      'invoice_date'      => $invoiceDate,
     ];

     return view('admin.invoice.eInvoice',$data);
     }






}
