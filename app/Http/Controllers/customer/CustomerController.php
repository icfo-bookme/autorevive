<?php

namespace App\Http\Controllers\customer;

use App\Helper\SmsHelper;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Orders;
use App\User;
use App\OrderModel;
use App\ReferralModel;
use App\admin\UserRolesModel;
use App\customer\CustomerModel;
use App\welcomeCall\WelcomeCallModel;
use App\CustomersReferralsDetailsModel;
use App\SMS\SmsTemplate;
use App\SMS\SmsLog;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;


define('CUSTOMER_ROLE', 2);

class CustomerController extends Controller
{

    public function allCustomers()
    {
        $referrals = ReferralModel::all();
        $thanas = CustomerModel::select('thana')->whereNotNull('thana')->where('thana', '<>', '')->distinct()->get();
        // $customers = CustomerModel::where('soft_delete',0)->get();
        $smsTemplates = SmsTemplate::where('soft_delete',0)->get();
        $data = [
            // 'customers' => $customers,
            'thanas' => $thanas,
            'referrals' => $referrals,
            'smsTemplates' => $smsTemplates
        ];
        return view('admin.customer.allCustomers', $data);
    }



    public function getTemplateBody(Request $request){

        $id = $request->id;
        $smsBody = SmsTemplate::findOrFail($id);
        return response()->json($smsBody);

    }

    public function sendSmsAllUser(Request $request){

        $message    = $request->smsBody;
        $sendSmsJob = (new \App\Jobs\SendSms($request->recipients, $message));
        $response = dispatch($sendSmsJob);

        return response()->json([
            'data' => null,
            'status' => true,
            'message' => 'Successful'
        ]);
    }

    /*To view order details of any specific customer in  the action column*/

    public function getCustomerOrderHistoryAjax(Request $request)
    {
        $customer = CustomerModel::findOrFail($request->id);
        $orders   = OrderModel::where('soft_delete', 0)
                            ->where('phone_number', $customer->phone)
                            ->with('order_details')
                            ->get();

        return response()->json($orders, 200);
    }


    public function addCustomerView()
    {
        return view('admin.customer.addCustomerView');
    }


    /* customer insert to customers table  */
    public function addCustomer(Request $request)
    {
        for ($i=0; $i < count($request->first_name) ; $i++) {
            $attributeNames = array(
                'first_name'    =>  $request->first_name[$i],
                'phone'         =>  $request->phone_number[$i]
            );

            $validator = Validator::make($attributeNames,[
                'first_name'    => 'required|min:1|max:256',
                'phone'         => 'required|regex:/(01)[0-9]{9}/'
            ]);

            if($validator->fails()){
                return response()->json([
                    'data'      => $validator->getMessageBag()->toArray(),
                    'status'    => 'validation-error',
                    'message'   => null
                ]);
            }

            $phone = $request->phone_number[$i];
            $phoneNumberAlreadyExists = CustomerModel::where('phone', '=', $phone)->first();
            if($phoneNumberAlreadyExists) {
                return response()->json([
                    'data'      => null,
                    'status'    => 'customer-exists',
                    'message'   => 'Sorry! customer with phone '.$phone.' already exists.'
                ]);
            }
        }

        DB::beginTransaction();
        try {
            for ($i=0; $i < count($request->first_name); $i++) {
                $newCustomer = CustomerModel::create([
                    'first_name'    =>  $request->first_name[$i],
                    'last_name'     =>  $request->last_name[$i],
                    'email'         =>  $request->email[$i],
                    'phone'         =>  $request->phone_number[$i],
                    'car_no'        =>  $request->car_no[$i],
                    'created_by'    =>  Auth::user()->first_name,
                    'updated_by'    =>  Auth::user()->first_name
                ]);
                WelcomeCallModel::create([
                    'customer_id'   => $newCustomer->id,
                    'created_by'    => Auth::user()->first_name
                ]);
                DB::commit();
            }

            return response()->json([
                'data'      => null,
                'status'    => true,
                'message'   => 'Successful'
            ]);

        } catch (\Exception $exception) {
            DB::rollback();
            return response()->json([
                'data'      => null,
                'status'    => false,
                'message'   => $exception->getMessage()
            ]);
        }

    }


    public function getCustomerDetailsById(Request $request)
    {
        $customer = CustomerModel::where(['id' => $request->id,'soft_delete' => 0])->first();
        $customerreferrals = CustomersReferralsDetailsModel::select('referral_id')->where('customer_id', $request->id)->get();
        return response()->json([
            'data'      => [
                'customer' => $customer,
                'customerreferrals' => $customerreferrals
            ],
            'status'    => true,
            'message'   => null
        ]);
    }


    public function userInformationUpdate(Request $request)
    {
        $attributeNames = array(
            'first_name' =>  $request->update_first_name,
            'phone'      =>  $request->update_phone_number,
        );

        $validator = Validator::make($attributeNames,[
            'first_name'    => 'required|min:1|max:256',
            'phone'         => 'required|regex:/(01)[0-9]{9}/'
        ]);

        $phone = $request->update_phone_number;
        $phoneNumberAlreadyExists = CustomerModel::where('phone', '=', $phone)->where('id', '!=', $request->customer_id)->first();
        if($phoneNumberAlreadyExists) {
            return response()->json([
                'data'      => null,
                'status'    => 'customer-exists',
                'message'   => 'Sorry! customer with phone '.$phone.' already exists.'
            ]);
        }

        if($validator->fails()){
            return response()->json([
                'data'      => $validator->getMessageBag()->toArray(),
                'status'    => 'validation-error',
                'message'   => null
            ]);
        } else {
            DB::beginTransaction();
            try {
                CustomerModel::findOrFail($request->customer_id)->update([
                    'first_name' =>  $request->update_first_name,
                    'last_name'  =>  $request->update_last_name,
                    'email'      =>  $request->update_email,
                    'phone'      =>  $request->update_phone_number,
                    'address'    =>  $request->update_address,
                    'country'    =>  $request->update_country,
                    'district'   =>  $request->update_district,
                    'city'       =>  $request->update_city,
                    'thana'      =>  $request->update_thana,
                    'area'       =>  $request->update_area,
                    'road_no'    =>  $request->update_road_no,
                    'house_no'   =>  $request->update_house_no,
                    'flat_no'    =>  $request->update_flat_no,
                    'car_no'     =>  $request->update_car_no,
                    'updated_by' =>  Auth::user()->first_name
                ]);

                if(CustomersReferralsDetailsModel::where('customer_id',$request->customer_id)){
                    CustomersReferralsDetailsModel::where('customer_id',$request->customer_id)->delete();
                }
                if (isset($request->referral_method)) {
                    for ($i = 0; $i < count($request->referral_method); $i++) {
                        $referrals = new CustomersReferralsDetailsModel();
                        $referrals->customer_id = $request->customer_id;
                        $referrals->referral_id = $request->referral_method[$i];
                        $referrals->save();
                    }
                }
                DB::commit();
                return response()->json([
                    'data'    => null,
                    'status'  => true,
                    'message' => 'Updated Successfully'
                ]);

            } catch (\Exception $exception) {
                DB::rollBack();
                return response()->json([
                    'data'      => null,
                    'status'    => false,
                    'message'   => $exception->getMessage()
                ]);
            }
        }

    }




    //WELCOME CALL FOLLOWUP

    public function welcomeCallView()
    {
        $pendingCalls  = WelcomeCallModel::where('status',0)->where('soft_delete',0)->get();
        $approvedCalls = WelcomeCallModel::where('status',1)->where('soft_delete',0)->get();

        return view('admin.welcomeCall.welcomeCallView',
        [
            'pendingCalls'  => $pendingCalls,
            'approvedCalls' => $approvedCalls,
        ]);
    }


    public function approveWelcomeCall(Request $request)
    {
        WelcomeCallModel::where('id', $request->id)
                        ->update(['status' => 1]);

        return response()->json('Success', 200);
    }


    //script to merge cloudone users into customers table
    // should not run in server
    public function importNewCustomer()
    {
        $count=0;
        $c1users = DB::select(DB::raw('SELECT * FROM `cloudone_users` WHERE LENGTH(`contact`) = 11 AND `transfer_status` = 0 LIMIT 500'));

        DB::beginTransaction();
        try {

            foreach ($c1users as $user) {

                $id   = $user->id;
                $name = $user->name;

                // // PHP < 8
                // if ($name == trim($name) && strpos($name, ' ') !== false) {
                //     echo 'has spaces, but not at beginning or end';
                // }

                // PHP 8+
                if ($name == trim($name) && str_contains($name, ' ')) {

                    $name       = explode(' ', $user->name, 2);
                    $first_name = $name[0];
                    $last_name  = $name[1];

                }else {
                    $first_name = $name;
                    $last_name = NULL;
                }

                $phone      = $user->contact;
                $address    = $user->address;
                $thana      = $user->thana;

                $data = [
                    'first_name'    =>  $first_name,
                    'last_name'     =>  $last_name,
                    'phone'         =>  $phone,
                    'address'       =>  $address,
                    'thana'         =>  $thana,
                    'created_by'    =>  Auth::user()->first_name,
                    'updated_by'    =>  Auth::user()->first_name
                ];

                $newCustomer = CustomerModel::create($data);

                WelcomeCallModel::create([
                    'customer_id'   => $newCustomer->id,
                    'created_by'    => Auth::user()->first_name
                ]);

                DB::table('cloudone_users')->where('id',$id)->update(['transfer_status' => 1]);

                $count++;
            }
            DB::commit();
            return response()->json([
                'data'      => $count,
                'status'    => true,
                'message'   => 'Successful'
            ]);

        } catch (\Exception $exception) {
            DB::rollback();
            return response()->json([
                'data'      => $count,
                'status'    => false,
                'message'   => $exception->getMessage()
            ]);
        }

    }

    public function listAllCustomers(Request $request)
    {
        // dd($request->thana);
        $customers = CustomerModel::where('soft_delete',0);
        if ($request->thana != 'all') {
            $thana = $request->thana;
            $customers = $customers->where('thana', $thana);
        }

        // dd($customers);

        return Datatables::of($customers )
            ->addColumn('column_checkbox', function ($data) {
                return '<input type="checkbox" name="printcheck[]" class="printcheck" value='.$data->phone.' onclick="selectedUsers('.$data->phone.',this)">';
            })
            ->addColumn('data_first_name', function ($data) {
                return $data->first_name ?? "";
            })
            ->addColumn('data_last_name', function ($data) {
                return $data->last_name ?? "";
            })
            ->addColumn('data_email',function($data){
                return $data->email ?? "";
            })
            ->addColumn('data_phone',function($data){
                return $data->phone ?? "";
            })
            ->addColumn('data_thana',function($data){
                return $data->thana ?? "";
            })
            ->addColumn('data_car_no',function($data){
                return $data->car_no ?? "";
            })
            ->addColumn('created_at',function($data){
                return $data->created_at ?? "";

            })
            ->addColumn('action',function($data){
                return '<a href="javascript:void(0)"
                onclick="getCustomerOrderHistory('.$data->id.')"
                style="padding: 5px 10px;" class="btn btn-default btn-xs border"
                data-toggle="tooltip" title="" data-original-title="Edit">
                <i class="fa fa-info-circle"></i>
            </a>
            <a href="javascript:void(0)" onclick="editCustomerInfo('.$data->id.')"
                style="padding: 5px 10px;" class="btn btn-default btn-xs border"
                data-toggle="tooltip" title="" data-original-title="Edit">
                <i class="fa fa-pencil"></i>
            </a>';
            })

            ->rawColumns(['column_checkbox', 'action','data_first_name','data_last_name','created_at'])
            ->addIndexColumn()
            ->make(true);
    }
    public function listAllPendingWelcomeCallData(Request $request)
    {
        // // Capture start time for the SQL query execution
        // $startTimeSql = microtime(true);
        // $pendingCalls  = WelcomeCallModel::where('status',0)->where('soft_delete',0)->get();
        // // Capture end time for SQL query execution
        // \Log::info($pendingCalls );
        // $endTimeSql = microtime(true);
        // $sqlExecutionTime = $endTimeSql - $startTimeSql;
        // // Log the SQL execution time
        // \Log::info('SQL Query Execution Time: ' . $sqlExecutionTime . ' seconds');

        // // Capture start time for DataTable execution
        // $startTimeDatatable = microtime(true);
        // $datatable = Datatables::of($pendingCalls)
        //     ->addColumn('data_first_name', function ($data) {
        //         // dd($data->customer->id);
        //         return $data->customer->first_name ?? "";
        //     })
        //     ->addColumn('data_last_name', function ($data) {
        //         return $data->customer->last_name ?? "";
        //     })
        //     ->addColumn('data_email',function($data){
        //         return $data->customer->email ?? "";
        //     })
        //     ->addColumn('data_phone',function($data){
        //         return $data->customer->phone ?? "";
        //     })
        //     ->addColumn('created_by',function($data){
        //         return $data->created_by ?? "";

        //     })
        //     ->addColumn('created_at',function($data){
        //         return $data->created_at ?? "";

        //     })
        //     ->addColumn('action',function($data){
        //         return '<button class="btn btn-default btn-xs border"
        //         onclick="approve('.$data->customer->id.')">
        //         <i class="fa fa-check icon__size"></i>
        //     </button>';
        //     })

        //     ->rawColumns(['column_checkbox', 'action','data_first_name','data_last_name','created_at'])
        //     ->addIndexColumn()
        //     ->make(true);
        //     // Capture end time for DataTable execution
        //     $endTimeDatatable = microtime(true);
        //     $datatableExecutionTime = $endTimeDatatable - $startTimeDatatable;
        //     // Log the DataTable execution time
        //     \Log::info('DataTable Execution Time: ' . $datatableExecutionTime . ' seconds');
        //     // Return the DataTable
        //     return $datatable;


        // Eloquent ORM Without GET
        // Capture SQL execution time
        $pendingCalls = WelcomeCallModel::with('customer:id,first_name,last_name,email,phone')
            ->select(
                'welcome_call.id as welcome_call_id', 
                'welcome_call.customer_id', 
                'welcome_call.created_by', 
                'welcome_call.created_at'
            )
            ->where('welcome_call.status', 0)
            ->where('welcome_call.soft_delete', 0);

        $datatable = DataTables::of($pendingCalls)
            ->filter(function ($query) {
                if (request()->has('search') && !empty(request('search')['value'])) {
                    $search = strtolower(request('search')['value']);
                    
                    $query->whereHas('customer', function ($q) use ($search) {
                        $q->whereRaw('LOWER(customers.first_name) LIKE ?', ["%{$search}%"])
                        ->orWhereRaw('LOWER(customers.last_name) LIKE ?', ["%{$search}%"])
                        ->orWhereRaw('LOWER(customers.email) LIKE ?', ["%{$search}%"])
                        ->orWhereRaw('LOWER(customers.phone) LIKE ?', ["%{$search}%"]);
                    });

                    // Search in created_by and created_at
                    $query->orWhereRaw('LOWER(welcome_call.created_by) LIKE ?', ["%{$search}%"])
                          ->orWhereRaw("DATE_FORMAT(welcome_call.created_at, '%Y-%m-%d %H:%i:%s') LIKE ?", ["%{$search}%"]);
                }
            })

        ->orderColumn('created_by', function ($query, $order) {
            $query->orderBy('welcome_call.created_by', $order);
        })
        ->orderColumn('created_at', function ($query, $order) {
            $query->orderBy('welcome_call.created_at', $order);
        })
        ->addColumn('data_first_name', function ($data) {
            return optional($data->customer)->first_name ?? "";
        })
        ->addColumn('data_last_name', function ($data) {
            return optional($data->customer)->last_name ?? "";
        })
        ->addColumn('data_email', function ($data) {
            return optional($data->customer)->email ?? "";
        })
        ->addColumn('data_phone', function ($data) {
            return optional($data->customer)->phone ?? "";
        })
        ->addColumn('created_by', function ($data) {
            return $data->created_by ?? "";
        })
        ->addColumn('created_at', function ($data) {
            return $data->created_at ?? "";
        })
        ->addColumn('action', function ($data) {
            return '<button class="btn btn-default btn-xs border"
                    onclick="approve('.$data->customer_id.')">
                    <i class="fa fa-check icon__size"></i>
                    </button>';
        })
        ->rawColumns(['action'])
        ->addIndexColumn()
        ->make(true);

        return $datatable;
        
        // $endTimeSql = microtime(true);
        // $sqlExecutionTime = $endTimeSql - $startTimeSql;
        // \Log::info('SQL Query Execution Time: ' . $sqlExecutionTime . ' seconds');
        
        // Capture DataTable execution time
        // $startTimeDatatable = microtime(true);
        
        // $datatable = DataTables::of($pendingCalls)
        // ->filter(function ($query) {
        //     if (request()->has('search') && !empty(request('search')['value'])) {
        //         $search = strtolower(request('search')['value']);
        //         $query->whereHas('customer', function ($q) use ($search) {
        //             $q->whereRaw('LOWER(first_name) LIKE ?', ["%{$search}%"])
        //             ->orWhereRaw('LOWER(last_name) LIKE ?', ["%{$search}%"])
        //             ->orWhereRaw('LOWER(email) LIKE ?', ["%{$search}%"])
        //             ->orWhereRaw('LOWER(phone) LIKE ?', ["%{$search}%"]);
        //         });

        //         // Search in created_by and created_at
        //         $query->orWhereRaw('LOWER(created_by) LIKE ?', ["%{$search}%"])
        //               ->orWhereRaw("DATE_FORMAT(created_at, '%Y-%m-%d %H:%i:%s') LIKE ?", ["%{$search}%"]);
        //     }
        // })

        // ->orderColumn('data_first_name', function ($query, $order) {
        //     $query->join('customers', 'customers.id', '=', 'welcome_call.customer_id')
        //           ->orderBy('customers.first_name', $order);
        // })
        // ->orderColumn('data_last_name', function ($query, $order) {
        //     $query->join('customers', 'customers.id', '=', 'welcome_call.customer_id')
        //           ->orderBy('customers.last_name', $order);
        // })
        // ->orderColumn('data_email', function ($query, $order) {
        //     $query->join('customers', 'customers.id', '=', 'welcome_call.customer_id')
        //           ->orderBy('customers.email', $order);
        // })
        // ->orderColumn('data_phone', function ($query, $order) {
        //     $query->join('customers', 'customers.id', '=', 'welcome_call.customer_id')
        //           ->orderBy('customers.phone', $order);
        // })
        // ->orderColumn('created_by', function ($query, $order) {
        //     $query->orderBy('welcome_call.created_by', $order);
        // })
        // ->orderColumn('created_at', function ($query, $order) {
        //     $query->orderBy('welcome_call.created_at', $order);
        // })        
        // ->addColumn('data_first_name', function ($data) {
        //     return optional($data->customer)->first_name ?? "";
        // })
        // ->addColumn('data_last_name', function ($data) {
        //     return optional($data->customer)->last_name ?? "";
        // })
        // ->addColumn('data_email', function ($data) {
        //     return optional($data->customer)->email ?? "";
        // })
        // ->addColumn('data_phone', function ($data) {
        //     return optional($data->customer)->phone ?? "";
        // })
        // ->addColumn('created_by', function ($data) {
        //     return $data->created_by ?? "";
        // })
        // ->addColumn('created_at', function ($data) {
        //     return $data->created_at ?? "";
        // })
        // ->addColumn('action', function ($data) {
        //     return '<button class="btn btn-default btn-xs border"
        //             onclick="approve('.$data->customer_id.')">
        //             <i class="fa fa-check icon__size"></i>
        //             </button>';
        // })
        // ->rawColumns(['action'])
        // ->addIndexColumn()
        // ->make(true);
        
        // // $endTimeDatatable = microtime(true);
        // // $datatableExecutionTime = $endTimeDatatable - $startTimeDatatable;
        // // \Log::info('DataTable Execution Time: ' . $datatableExecutionTime . ' seconds');
        
        // return $datatable;
        
        
        // Query Builder
        // Capture SQL execution time
        // $startTimeSql = microtime(true);
        
        // $pendingCalls = DB::table('welcome_call as wc')
        //     ->join('customers as c', 'wc.customer_id', '=', 'c.id')
        //     ->select(
        //         'wc.id as welcome_call_id',
        //         'c.id as customer_id',
        //         'c.first_name',
        //         'c.last_name',
        //         'c.email',
        //         'c.phone',
        //         'wc.created_by',
        //         'wc.created_at'
        //     )
        //     ->where('wc.status', 0)
        //     ->where('wc.soft_delete', 0);
        
        // $endTimeSql = microtime(true);
        // $sqlExecutionTime = $endTimeSql - $startTimeSql;
        // \Log::info('SQL Query Execution Time: ' . $sqlExecutionTime . ' seconds');
        
        // // Capture DataTable execution time
        // $startTimeDatatable = microtime(true);
        
        // $datatable = DataTables::of($pendingCalls)
        //     ->filter(function ($query) {
        //         if (request()->has('search') && !empty(request('search')['value'])) {
        //             $search = strtolower(request('search')['value']);
        //             $query->where(function ($q) use ($search) {
        //                 $q->whereRaw('LOWER(c.first_name) LIKE ?', ["%{$search}%"])
        //                   ->orWhereRaw('LOWER(c.last_name) LIKE ?', ["%{$search}%"])
        //                   ->orWhereRaw('LOWER(c.email) LIKE ?', ["%{$search}%"])
        //                   ->orWhereRaw('LOWER(c.phone) LIKE ?', ["%{$search}%"]);
        //             });
        //         }
        //     })
        //     ->addColumn('data_first_name', function($data) {
        //         return $data->first_name ?? "";
        //     })
        //     ->addColumn('data_last_name', function($data) {
        //         return $data->last_name ?? "";
        //     })
        //     ->addColumn('data_email', function($data) {
        //         return $data->email ?? "";
        //     })
        //     ->addColumn('data_phone', function($data) {
        //         return $data->phone ?? "";
        //     })
        //     ->addColumn('created_by', function($data) {
        //         return $data->created_by ?? "";
        //     })
        //     ->addColumn('created_at', function($data) {
        //         return $data->created_at ?? "";
        //     })
        //     ->addColumn('action', function($data) {
        //         return '<button class="btn btn-default btn-xs border"
        //         onclick="approve('.$data->customer_id.')">
        //         <i class="fa fa-check icon__size"></i>
        //         </button>';
        //     })
        //     ->rawColumns(['action'])
        //     ->addIndexColumn()
        //     ->make(true);
        
        // $endTimeDatatable = microtime(true);
        // $datatableExecutionTime = $endTimeDatatable - $startTimeDatatable;
        // \Log::info('DataTable Execution Time: ' . $datatableExecutionTime . ' seconds');
        
        // return $datatable;

    }
    public function listAllApprovedWelcomeCallData(Request $request)
    {

        $approvedCalls = WelcomeCallModel::where('status',1)->where('soft_delete',0)->get();

        return Datatables::of($approvedCalls)
            ->addColumn('data_first_name', function ($data) {
                // dd($data->customer->id);
                return $data->customer->first_name ?? "";
            })
            ->addColumn('data_last_name', function ($data) {
                return $data->customer->last_name ?? "";
            })
            ->addColumn('data_email',function($data){
                return $data->customer->email ?? "";
            })
            ->addColumn('data_phone',function($data){
                return $data->customer->phone ?? "";
            })
            ->addColumn('created_by',function($data){
                return $data->created_by ?? "";

            })
            ->addColumn('created_at',function($data){
                return $data->created_at ?? "";

            })
            ->rawColumns(['column_checkbox','data_first_name','data_last_name','created_at'])
            ->addIndexColumn()
            ->make(true);
    }

}
