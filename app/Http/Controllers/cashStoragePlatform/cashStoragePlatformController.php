<?php

namespace App\Http\Controllers\cashStoragePlatform;

use Illuminate\Http\Request;
use App\CashStoragePlatform\CashStoragePlatform;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\PaymentCollectionModel;
use App\purchase\PurchaseDetailsModel;
use App\purchase\PurchaseModel;
use App\purchase\PurchaseDraft;
use App\CashWithdraw\CashWithDrawModel;
use App\AdvancePayment\AdvancePayment;
use App\CostInsert\CostInsert;
use App\CostManagement\CashInsert;
use App\Reinvestment\Reinvestment;
use App\FundInsert\FundInsert;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\DataTables;
use App\sales\SalesDetailsModel;
use Exception;

class cashStoragePlatformController extends Controller
{
    /**
     * VIEWS CASH STORAGE PLATFORMS WITH DETAILS 
     */
    public function cashStoragePlatformView() {

        /* paymentcollectionmodel total amount holds every completed order's, And Collected payment at sale which gets updated every time due is paid.
           AdvancePayment holds the amount received during booking.
        */
        $puchasedAmount       = PurchaseModel::where('soft_delete', 0)->sum('paid_amount');
        $puchaseDraftedAmount = PurchaseDraft::where(['soft_delete' => 0, 'is_purchased' => 0])->sum('amount');
        $totalPurchase        = $puchasedAmount + $puchaseDraftedAmount;
                                
        $PaymentCollectionAmount = PaymentCollectionModel::where('soft_delete', 0)->sum('total_amount');
        $AdvancePaymentAmount    = AdvancePayment::where('soft_delete', 0)->sum('paid_amount');
        $FundAmount              = FundInsert::where('soft_delete',0)->sum('amount');
        $ReinvestmentAmount      = Reinvestment::where('soft_delete',0)->sum('amount');
        $paymentCollection       = $PaymentCollectionAmount + $AdvancePaymentAmount + $FundAmount + $ReinvestmentAmount;

        /* In accounts module, costs are inserted */
        $costAmount   = CostInsert::where('soft_delete',SOFT_DELETE_NO)->sum('amount');
        $insertedCost = CostInsert::where('soft_delete',SOFT_DELETE_NO)->sum('amount');

        $outsourceCosts = SalesDetailsModel::select("*")
                                    ->selectRaw('sum(cost_price*quantity) as sum')
                                    ->groupBy('sales_id')
                                    ->where('soft_delete',0)
                                    ->whereHas('sales', function($q){
                                        $q->where('company_name', '=', 'outsource')
                                            ->where('is_cancelled',0);
                                    })->orderBy('id', 'DESC')->get();

        $totalOutsourcedCost = $outsourceCosts->sum('sum');
        
        // dd("Debugging from developer:paymentCollection",$paymentCollection, "insertedCost", $insertedCost, "totalPurchase", $totalPurchase, "totalOutsourcedCost", $totalOutsourcedCost);
        $totalCashCalculationData = [
            'PaymentCollectionAmount' => $PaymentCollectionAmount,
            'AdvancePaymentAmount' => $AdvancePaymentAmount,
            'FundAmount' => $FundAmount,
            'ReinvestmentAmount' => $ReinvestmentAmount,
            
            'costAmount' => $costAmount,
            'puchasedAmount' => $puchasedAmount,
            'puchaseDraftedAmount' => $puchaseDraftedAmount,
            'totalOutsourcedCost' => $totalOutsourcedCost,                      
        ];

        /* Deduct inserted costs, total purchased costs, total outsourced costs from total cash */
        $total_cash  = round($paymentCollection - ($insertedCost + $totalPurchase + $totalOutsourcedCost), 2);

        // //old
        // /* Deduct inserted costs from total cash */
        // $total_cash  = number_format($paymentCollection - ($insertedCost + $totalPurchase),2);

        $all_platforms = CashStoragePlatform::where('soft_delete', 0)->with('user_name')->get();

        //last edit info show on the top of the page
        $last_edit = CashStoragePlatform::where('soft_delete',0)->latest()->first();
        $name = $last_edit->user_name->first_name.' '.$last_edit->user_name->last_name;
        $dt = Carbon::parse($last_edit->updated_at);
        $dt = $dt->diffForHumans();

        $data   = [
            'all_platforms' => $all_platforms,
            'total_cash'    => $total_cash, 
            'name'          => $name,
            'update_time'   => $dt,
            'totalCashCalculationData' => $totalCashCalculationData
        ];
        return view('admin.cashStoragePlatform.cashStoragePlatformView',$data);
    }


      public function cashStoragePlatformViewInactive() {

        /* paymentcollectionmodel total amount holds every completed order's, And Collected payment at sale which gets updated every time due is paid.
           AdvancePayment holds the amount received during booking.
        */
        $puchasedAmount       = PurchaseModel::where('soft_delete', 0)->sum('paid_amount');
        $puchaseDraftedAmount = PurchaseDraft::where(['soft_delete' => 0, 'is_purchased' => 0])->sum('amount');
        $totalPurchase        = $puchasedAmount + $puchaseDraftedAmount;
                                
        $PaymentCollectionAmount = PaymentCollectionModel::where('soft_delete', 0)->sum('total_amount');
        $AdvancePaymentAmount    = AdvancePayment::where('soft_delete', 0)->sum('paid_amount');
        $FundAmount              = FundInsert::where('soft_delete',0)->sum('amount');
        $ReinvestmentAmount      = Reinvestment::where('soft_delete',0)->sum('amount');
        $paymentCollection       = $PaymentCollectionAmount + $AdvancePaymentAmount + $FundAmount + $ReinvestmentAmount;

        /* In accounts module, costs are inserted */
        $costAmount   = CostInsert::where('soft_delete',SOFT_DELETE_NO)->sum('amount');
        $insertedCost = CostInsert::where('soft_delete',SOFT_DELETE_NO)->sum('amount');

        $outsourceCosts = SalesDetailsModel::select("*")
                                    ->selectRaw('sum(cost_price*quantity) as sum')
                                    ->groupBy('sales_id')
                                    ->where('soft_delete',0)
                                    ->whereHas('sales', function($q){
                                        $q->where('company_name', '=', 'outsource')
                                            ->where('is_cancelled',0);
                                    })->orderBy('id', 'DESC')->get();

        $totalOutsourcedCost = $outsourceCosts->sum('sum');
        
        // dd("Debugging from developer:paymentCollection",$paymentCollection, "insertedCost", $insertedCost, "totalPurchase", $totalPurchase, "totalOutsourcedCost", $totalOutsourcedCost);
        $totalCashCalculationData = [
            'PaymentCollectionAmount' => $PaymentCollectionAmount,
            'AdvancePaymentAmount' => $AdvancePaymentAmount,
            'FundAmount' => $FundAmount,
            'ReinvestmentAmount' => $ReinvestmentAmount,
            
            'costAmount' => $costAmount,
            'puchasedAmount' => $puchasedAmount,
            'puchaseDraftedAmount' => $puchaseDraftedAmount,
            'totalOutsourcedCost' => $totalOutsourcedCost,                      
        ];

        /* Deduct inserted costs, total purchased costs, total outsourced costs from total cash */
        $total_cash  = round($paymentCollection - ($insertedCost + $totalPurchase + $totalOutsourcedCost), 2);

        // //old
        // /* Deduct inserted costs from total cash */
        // $total_cash  = number_format($paymentCollection - ($insertedCost + $totalPurchase),2);

        $all_platforms = CashStoragePlatform::where('soft_delete', 1)->with('user_name')->get();

        //last edit info show on the top of the page
        $last_edit = CashStoragePlatform::where('soft_delete',1)->latest()->first();
        $name = $last_edit->user_name->first_name.' '.$last_edit->user_name->last_name;
        $dt = Carbon::parse($last_edit->updated_at);
        $dt = $dt->diffForHumans();

        $data   = [
            'all_platforms' => $all_platforms,
            'total_cash'    => $total_cash,
            'name'          => $name,
            'update_time'   => $dt,
            'totalCashCalculationData' => $totalCashCalculationData
        ];
        return view('admin.cashStoragePlatform.cashStoragePlatformViewInactive',$data);
    }

    public function totalCashCalculationDetails(Request $request)
    {
        $type = $request->type;
        $data = [];
    
        switch ($type) {
            case 'PaymentCollectionAmount':
                if (!$request->has('datatable')) {
                    return view('admin.cashStoragePlatform.details.PaymentCollection');
                }

                $query = PaymentCollectionModel::with(['payment_method', 'order'])
                ->where('soft_delete', 0)
                ->where('total_amount', '>', 0);

                return DataTables::of($query)
                    ->addIndexColumn()
                    ->addColumn('invoice_id', function ($row) {
                        if ($row->order) {
                            $prefix = ($row->order->delivery_type === 'delivery' || $row->order->delivery_type === 'pickup') ? '#0101' : '#0202';
                            return $prefix . $row->order->id;
                        }
                        return '-';
                    })
                    ->addColumn('customer_name', function($row) {
                        if ($row->order) {
                            $firstName = $row->order->first_name ?? '';
                            $lastName = $row->order->last_name ?? '';
                            return trim($firstName . ' ' . $lastName) ?: '';
                        }
                        return '-';
                    })
                    ->addColumn('payment_method', fn($row) =>
                        $row->payment_method->payment_method ?? ''
                    )
                    ->editColumn('invoice_amount', fn($row) =>
                        is_numeric($row->invoice_amount) ? number_format($row->invoice_amount, 2) : '0.00'
                    )
                    ->editColumn('total_amount', fn($row) =>
                        is_numeric($row->total_amount) ? number_format($row->total_amount, 2) : '0.00'
                    )
                    ->editColumn('created_at', fn($row) =>
                        $row->created_at ? $row->created_at->format('Y-m-d H:i:s') : ''
                    )
                    ->editColumn('updated_at', fn($row) =>
                        $row->updated_at ? $row->updated_at->format('Y-m-d H:i:s') : ''
                    )
                    ->rawColumns(['invoice_id'])
                    ->make(true);
    
            case 'AdvancePaymentAmount':
                if (!$request->has('datatable')) {
                    return view('admin.cashStoragePlatform.details.AdvancePayment');
                }

                $query = AdvancePayment::with('booking')->where('soft_delete', 0)->where('paid_amount', '>', 0);

                return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('order_reference', function($row) {
                    if ($row->order) {
                        $firstName = $row->order->first_name ?? '';
                        $lastName  = $row->order->last_name ?? '';
                        $fullName  = trim($firstName . ' ' . $lastName);
                        return trim($fullName);
                    }
                    return '';
                })
                ->addColumn('payment_method', fn($row) => $row->payment_method->payment_method ?? '')
                ->editColumn('invoice_amount', fn($row) => is_numeric($row->invoice_amount) ? number_format($row->invoice_amount, 2) : '0.00')
                ->editColumn('total_amount', fn($row) => is_numeric($row->total_amount) ? number_format($row->total_amount, 2) : '0.00')
                ->editColumn('created_at', fn($row) => $row->created_at ? $row->created_at->format('Y-m-d H:i:s') : '')
                ->editColumn('updated_at', fn($row) => $row->updated_at ? $row->updated_at->format('Y-m-d H:i:s') : '')
                ->make(true);

            case 'FundAmount':
                if (!$request->has('datatable')) {
                    return view('admin.cashStoragePlatform.details.Fund');
                }

                // DataTable AJAX request
                $query = FundInsert::with(['category','subcategory'])->where('soft_delete', 0)->where('amount', '>', 0);

                return DataTables::of($query)
                    ->addIndexColumn()
                    ->addColumn('category_id', function($row) {
                        return $row->category ? $row->category->name : '';
                    })
                    ->addColumn('subcategory_id', function($row) {
                        return $row->subcategory ? $row->subcategory->name : '';
                    })
                    ->editColumn('amount', function($row){
                        $amount = $row->amount;
                        if (is_numeric($amount)) {
                            return number_format($amount, 2);
                        }
                        return '0.00';
                    })
                    ->editColumn('date', function($row) {
                        return $row->created_at ? $row->created_at->format('Y-m-d') : '';
                    })
                    ->make(true);

            case 'ReinvestmentAmount':
                if (!$request->has('datatable')) {
                    return view('admin.cashStoragePlatform.details.Reinvestment');
                }

                $query = Reinvestment::with(['createdBy','updatedBy'])->where('soft_delete', 0)->where('amount', '>', 0);

                return DataTables::of($query)
                    ->addIndexColumn()
                    ->editColumn('amount', function($row){
                        return is_numeric($row->amount) ? number_format($row->amount, 2) : '0.00';
                    })
                    ->editColumn('date', function($row){
                        return $row->date ? \Carbon\Carbon::parse($row->date)->format('Y-m-d') : '';
                    })
                    ->editColumn('description', function($row){
                        return $row->description ?? '';
                    })
                    ->addColumn('created_by', function($row){
                        return $row->createdBy ? $row->createdBy->first_name : '';
                    })
                    ->addColumn('updated_by', function($row){
                        return $row->updatedBy ? $row->updatedBy->first_name : '';
                    })
                    ->editColumn('created_at', function($row){
                        return $row->created_at ? $row->created_at->format('Y-m-d H:i:s') : '';
                    })
                    ->make(true);
      
            case 'costAmount':
                if (!$request->has('datatable')) {
                    return view('admin.cashStoragePlatform.details.cost');
                }

                $query = CostInsert::with(['category', 'subcategory'])
                    ->where('soft_delete', SOFT_DELETE_NO)
                    ->where('amount', '>', 0);

                return DataTables::of($query)
                    ->addIndexColumn()
                    ->editColumn('amount', function ($row) {
                        return is_numeric($row->amount) ? number_format($row->amount, 2) : '0.00';
                    })
                    ->editColumn('date', function ($row) {
                        return $row->date ? \Carbon\Carbon::parse($row->date)->format('Y-m-d') : '';
                    })
                    ->addColumn('category_name', function ($row) {
                        return $row->category ? $row->category->name : ''; 
                    })
                    ->addColumn('subcategory_name', function ($row) {
                        return $row->subcategory ? $row->subcategory->name : ''; 
                    })
                    ->addColumn('created_by', function ($row) {
                        return $row->created_by ?? ''; 
                    })
                    ->addColumn('updated_by', function ($row) {
                        return $row->updated_by ?? '';
                    })
                    ->editColumn('created_at', function ($row) {
                        return $row->created_at ? $row->created_at->format('Y-m-d H:i:s') : '';
                    })
                    ->editColumn('updated_at', function ($row) {
                        return $row->updated_at ? $row->updated_at->format('Y-m-d H:i:s') : '';
                    })
                    ->make(true);

            case 'puchasedAmount':
                if (!$request->has('datatable')) {
                    return view('admin.cashStoragePlatform.details.puchased');
                }

                if ($type === 'puchasedAmount') {

                    if (!$request->has('datatable')) {
                        return view('admin.cashStoragePlatform.details.PurchaseAmount');
                    }
                
                    $query = PurchaseModel::with('vendor')
                        ->where('soft_delete', 0)
                        ->where('paid_amount', '>', 0);
                
                    return DataTables::of($query)
                        ->addIndexColumn()
                        ->addColumn('vendor_name', fn($row) => $row->vendor ? $row->vendor->name : '')
                        ->editColumn('purchase_date', fn($row) => $row->purchase_date ? \Carbon\Carbon::parse($row->purchase_date)->format('Y-m-d') : '')
                        ->editColumn('total_amount', fn($row) => is_numeric($row->total_amount) ? number_format($row->total_amount, 2) : '0.00')
                        ->editColumn('paid_amount', fn($row) => is_numeric($row->paid_amount) ? number_format($row->paid_amount, 2) : '0.00')
                        ->editColumn('due_amount', fn($row) => is_numeric($row->due_amount) ? number_format($row->due_amount, 2) : '0.00')
                        ->editColumn('completed_at', function($row){
                            return $row->completed_at ? \Carbon\Carbon::parse($row->completed_at)->format('Y-m-d H:i:s') : '';
                        })                        
                        ->editColumn('created_by', fn($row) => $row->created_by ?? '')
                        ->editColumn('updated_by', fn($row) => $row->updated_by ?? '')
                        ->editColumn('created_at', fn($row) => $row->created_at ? $row->created_at->format('Y-m-d H:i:s') : '')
                        ->editColumn('updated_at', fn($row) => $row->updated_at ? $row->updated_at->format('Y-m-d H:i:s') : '')
                        ->make(true);
                }
                

            case 'puchaseDraftedAmount':
                if (!$request->has('datatable')) {
                    return view('admin.cashStoragePlatform.details.puchaseDrafted');
                }

                $query = PurchaseDraft::where(['soft_delete' => 0, 'is_purchased' => 0])->where('amount', '>', 0);

                return DataTables::of($query)
                    ->addIndexColumn()
                    ->editColumn('amount', fn($row) => is_numeric($row->amount) ? number_format($row->amount, 2) : '0.00')
                    ->editColumn('note', fn($row) => $row->note ?? '')
                    ->editColumn('created_at', fn($row) => $row->created_at ? $row->created_at->format('Y-m-d H:i:s') : '')
                    ->editColumn('updated_at', fn($row) => $row->updated_at ? $row->updated_at->format('Y-m-d H:i:s') : '')
                    ->make(true);
    
            case 'totalOutsourcedCost':
                if (!$request->has('datatable')) {
                    return view('admin.cashStoragePlatform.details.totalOutsourcedCost');
                }

                $query = SalesDetailsModel::with('sales')
                    ->where('soft_delete', 0)
                    ->whereHas('sales', function($q) {
                        $q->where('company_name', 'outsource')
                        ->where('is_cancelled', 0);
                    });

                return DataTables::of($query)
                    ->addIndexColumn()
                    ->editColumn('product_name', fn($row) => $row->product_name ?? '')
                    ->editColumn('quantity', fn($row) => $row->quantity)
                    ->editColumn('unit_price', fn($row) => is_numeric($row->unit_price) ? number_format($row->unit_price, 2) : '0.00')
                    ->editColumn('price', fn($row) => is_numeric($row->price) ? number_format($row->price, 2) : '0.00')
                    ->editColumn('cost_price', fn($row) => is_numeric($row->cost_price) ? number_format($row->cost_price, 2) : '0.00')
                    ->editColumn('created_by', fn($row) => $row->created_by ?? '')
                    ->editColumn('updated_by', fn($row) => $row->updated_by ?? '')
                    ->editColumn('created_at', fn($row) => $row->created_at ? $row->created_at->format('Y-m-d H:i:s') : '')
                    ->editColumn('updated_at', fn($row) => $row->updated_at ? $row->updated_at->format('Y-m-d H:i:s') : '')
                    ->make(true);
        
            default:
                return '<p class="text-center text-muted my-3">No data available for this section.</p>';
        }
    }

    /**
     * INSERTS CASH STORAGE PLATFORM WITH AMOUNT 
     */
    public function cashStoragePlatformInsertAjax(Request $request) {

        $user_id = Auth::user()->id;
        $attributeNames = array(
            'name'       => $request->name,
            'amount'       => $request->amount
        );

        $validator = Validator::make($attributeNames, [
            'name'       => 'required',
            'amount'     => 'required',
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

                $cash_platform = new CashStoragePlatform();
                $cash_platform->name         = $request->name;
                $cash_platform->amount       = $request->amount;
                $cash_platform->created_by   = $user_id;
                $cash_platform->updated_by   = $user_id;
                $cash_platform->soft_delete  = SOFT_DELETE_NO;
                $cash_platform->save();

                DB::commit();
                return response()->json([
                    'data' => null,
                    'status' => true,
                    'message' => 'New Platform Inserted Successfully'
                ]);

            } catch (\Exception $exception) {

                DB::rollback();
                return response()->json([
                    'data' => $exception->getMessage(),
                    'status' => false,
                    'message' => 'Failed! Please try again'
                ]);

            }
        }
    }



    /**
     * UPDATES CASH STORAGE PLATFORM DETAILS
     */
    public function cashStoragePlatformUpdateAjax(Request $request){
        try{
            //Looping through all cash storage platforms and saving data into database
            foreach($request->balanceData as $singleData)
            {
                $response = CashStoragePlatform::where('name',$singleData['name'])->where('soft_delete',0)->update([
                    'amount' => $singleData['amount']
                ]);
            }
                if($response){
                    return response()->json([
                        'data' => $response,
                        'status'=> true,
                        'message' => "Records saved successfully"
                    ]);
                }
    
                return response()->json([
                    'data' => $response,
                    'status'=> false,
                    'message' => "Failed to update"
                ]);

        } catch(Exception $exception){
           
            return response()->json([
                'data' => $exception->getMessage(),
                'status' => false,
                'message' => 'Something went wrong!'
            ]);
        }
    }


    /**
     * INSERTS CASH STORAGE PLATFORM WITH AMOUNT 
     */
    public function cashStoragePlatformDeleteAjax(Request $request) {
        $id = $request->platformId;
        $delete = CashStoragePlatform::where('id',$id)->update([
            'soft_delete' => SOFT_DELETE_YES
        ]);

        if($delete){
            return response()->json([
                'data' => $delete,
                'status'=> true,
                'message' => "Records deleted successfully"
            ]);
        }

        return response()->json([
            'data' => $delete,
            'status'=> false,
            'message' => "Failed!"
        ]);
    }

       public function cashStoragePlatformRestoreAjax(Request $request) {
        $id = $request->platformId;
        $delete = CashStoragePlatform::where('id',$id)->update([
            'soft_delete' => SOFT_DELETE_NO
        ]);

        if($delete){
            return response()->json([
                'data' => $delete,
                'status'=> true,
                'message' => "Records restored successfully"
            ]);
        }

        return response()->json([
            'data' => $delete,
            'status'=> false,
            'message' => "Failed!"
        ]);
    }


    /**
     * GETS CASH STORAGE PLATFORM NAME 
     */
    public function getCashPlatformName(Request $request) {
        try{
            $id     = $request->id;
            $info   = CashStoragePlatform::where('id',$id)->first();

            if($info){
                return response()->json([
                    'data'      => $info,
                    'status'    => true,
                    'message'   => "Successful"
                ]);
            }

            return response()->json([
                'data' => $info,
                'status'=> false,
                'message' => "Failed to fetch data!"
            ]);

        } catch (Exception $exception) {
            return response()->json([
                'data' => $exception->getMessage(),
                'status' => false,
                'message' => 'Something went wrong! Please try again'
            ]);
        }
    }

    /**
     * UPDATES CASH STORAGE PLATFORM NAME 
     */
    public function cashPlatformNameUpdate(Request $request)
    {
        try {
            $id     = $request->platform_id;
            $name   = $request->platform_name;

            $attributeNames = array(
                'name' => $name
            );

            //validating the attributes
            $validator = Validator::make($attributeNames, [
                'name' => 'required'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'data' => $validator->getMessageBag()->toArray(),
                    'status' => "validation-error",
                    'message' => "Cost updating failed!"
                ]);
            }

            //Updating data
            $response = CashStoragePlatform::where('id',$id)->update([
                'name' => $name,
                'updated_by' => auth()->user()->id
            ]);

            if ($response) {
                return response()->json([
                    'data' => $response,
                    'status' => true,
                    'message' => 'Name updated succesfully'
                ]);
            }

            return response()->json([
                'data' => $response,
                'status' => false,
                'message' => 'Failed! Please try again'
            ]);

        } catch (Exception $exception) {
            return response()->json([
                'data' => $exception->getMessage(),
                'status' => false,
                'message' => 'Something went wrong! Please try again'
            ]);
        }
    }


}
