<?php

namespace App\Http\Controllers\test;

use App\OrderModel;
use App\PaymentCollectionModel;
use App\sales\SaleLogDetailModel;
use App\sales\SalesModel;
use App\sales\SalesDetailsModel;
use App\SalesDuePayment\SalesDuePayment;
use App\purchase\PurchaseDetailsModel;
use App\purchase\PurchaseLog;
use App\purchase\PurchaseDetailLog;
use App\purchase\PurchaseModel;
use App\purchase\PurchaseItemBarcode;
use App\stock\StockModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TestController extends Controller
{
    public function salesUpdateFix()
    {
        $saleDetailLogs = SaleLogDetailModel::get();
        $counter = 0;
        foreach($saleDetailLogs as $saleDetail)
        {
            $saleData = SalesModel::where('order_id',$saleDetail->order_id)->select('id','order_id','collected_payment','payment_due','is_shipment_charge_applied')->first();
            $dueCollectedPayments = SalesDuePayment::where('sales_id',$saleData->id)->sum('paid_amount');

            PaymentCollectionModel::where('order_id',$saleDetail->order_id)->where('soft_delete',0)->update([
                'invoice_amount' => $saleData['collected_payment'] + $saleData['payment_due'],
                'total_amount' => $saleData['collected_payment'] + $dueCollectedPayments
            ]);

            $counter++;
        }

        return response()->json([
            'status' => 200,
            'count' => $counter
        ]);
    }

    public function invoiceAmountFix()
    {
        $collectedPayments = PaymentCollectionModel::where('soft_delete',0)->get();
        $counter = 0;
        foreach($collectedPayments as $payment)
        {
            $orderData = OrderModel::where('id',$payment->order_id)->select('collected_payment','payment_due')->first();

            PaymentCollectionModel::where('id',$payment->id)->where('soft_delete',0)->update([
                'invoice_amount' => $orderData['collected_payment'] + $orderData['payment_due'],
            ]);

            $counter++;
        }

        return response()->json([
            'status' => 200,
            'count' => $counter
        ]);
    }

    //prepared and tested locally, didnot run at stage.
    // public function addInvoiceDateFromSaleToSalesdetails(){
    //     $sales = SalesModel::where('soft_delete',0)->get();
    //     $counter = 0;
    //     foreach ($sales as $sale) {
    //         SalesDetailsModel::where('sales_id',$sale->id)->update([
    //             'invoice_date' => $sale->invoice_date
    //         ]);
    //         $counter++;
    //     }

    //     return response()->json([
    //         'status' => 200,
    //         'count' => $counter
    //     ]);
    // }

    public function stockCrossFlaggedDataDelete(){

        $count=0;
        $crossFlagData = StockModel::where('cross_flag',1)->limit(50)->get();
        foreach ($crossFlagData as $flag) {

            $item_barcodes_id = $flag->item_barcodes_id;
            $barcodeTableData = PurchaseItemBarcode::where('id',$item_barcodes_id)->first();
            $purchase_id = $barcodeTableData->purchase_id;
            $purchase_detail_id =$barcodeTableData->purchase_detail_id;

            $purchaseDetailsTableData = PurchaseDetailsModel::where('id',$purchase_detail_id)->first();
            $cost_price = $purchaseDetailsTableData->cost_price;
            $quantity = $purchaseDetailsTableData->quantity;
            $amountToRemove = $cost_price * $quantity;

            $deletePurchaseDetail = $purchaseDetailsTableData->update(['quantity' => 0]);

            $purchaseCount = PurchaseDetailsModel::where(['purchase_id' => $purchase_id, 'soft_delete' => 0])->count();
            if($purchaseCount <= 1){
                $deletePurchase = PurchaseModel::where('id',$purchase_id)->update(['total_amount' => 0]);
                $count++;
            }else{
                $purchase = PurchaseModel::where('id',$purchase_id)->first();
                $totalAmount = $purchase->total_amount;
                $total_amount = $totalAmount - $amountToRemove;
                $updatePurchase = PurchaseModel::where('id',$purchase_id)->update(['total_amount' => $total_amount]);
                $count++;
            }
            $deleteStock = StockModel::where('id',$flag->id)->update(['quantity' => 0,'cross_flag' => 0]);

        }
        return response()->json([
            'status' => 200,
            'count' => $count
        ]);        

    }

    public function count(){
        $count = 0;
        $pur = PurchaseModel::whereColumn('paid_amount', '>', 'total_amount')->where('soft_delete',0)->get();
        
        foreach($pur as $p) {
            $bar = PurchaseItemBarcode::where([
                'soft_delete' => 0,
                'purchase_id' => $p->id
            ])->get();
            foreach ($bar as $b) {
                $st = StockModel::where([
                    'soft_delete' => 0,
                    'cross_flag' => 1,
                    'item_barcodes_id' => $b->id
                    ])->exists();
                if($st){
                    $count++;
                }
            }
        }
        return response()->json([
            'status' => 200,
            'count' => $count
        ]);
        
    }




}
