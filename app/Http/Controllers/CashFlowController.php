<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\User;
use App\CashFlowModel;
use Illuminate\Support\Facades\DB;
use App\CashWithdraw\CashWithDrawModel;
use App\CostManagement\CashInsert;

class CashFlowController extends Controller
{
    public function cashInsertView() {

        $username  = Auth::user()->first_name." ".Auth::user()->last_name;
        $all_cashes = CashInsert::where('soft_delete', 0)->with(['createdBY','updatedBY'])->orderBy('id', 'DESC')->get();

        $data   = [
            'username'   => $username,
            'all_cashes' => $all_cashes
        ];
        return view('admin.costmanagement.cashInsertView',$data);
    }


    public function cashInsertAjax(Request $request) {

        $user_id = Auth::user()->id;
        $attributeNames = array(
            'cash_amount'       => $request->cash_amount,
            'description'       => $request->description,
            'date'              => $request->date
        );

        $validator = Validator::make($attributeNames, [
            'cash_amount'       => 'required',
            'description'       => 'required',
            'date'              => 'required'
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
                $cash = new CashInsert();
                $cash->cash_amount  = $request->cash_amount;
                $cash->description  = $request->description;
                $cash->date         = $request->date;
                $cash->created_by   = Auth::user()->id;
                $cash->updated_by   = Auth::user()->id;
                $cash->soft_delete  = 0;
                $cash->save();

                DB::commit();
                return response()->json([
                    'data' => null,
                    'status' => true,
                    'message' => 'Cash Inserted Successfully'
                ]);
            } catch (\Exception $exception) {
                DB::rollback();
                return response()->json([
                    'data' => $exception->getMessage(),
                    'status' => false,
                    'message' => 'Could not insert CASH! Please try again'
                ]);
            }
        }
    }

    public function getCashInfo(Request $request) {
        $cashInfo = CashInsert::findOrFail($request->id);
        return response()->json($cashInfo);
    }

    public function cashUpdateAjax(Request $request){
        $user_id     = Auth::user()->id;
        $cash_update = CashInsert::findOrFail($request->cash_id);
        
        $attributeNames  = array(
            'cash_amount'     => $request->cash_amount,
            'description'     => $request->description,
            'date'            => $request->date,
            'updated_by'      => $user_id
        );
        $cashUpdate = CashInsert::where('id',$request->cash_id)->update($attributeNames);
        if($cashUpdate){
            return response()->json([
                'data' => null,
                'status' => true,
                'message' => 'Cash updated successfully'
            ]);
        } else{
            return response()->json([
                'data' => null,
                'status' => false,
                'message' => 'Something went wrong! Please try again'
            ]);
        }
    }


    public function cashFlowView()
    {

        $users  = User::all();
        //     $users  = User::WhereHas('roles', function ($q)  {
        //         $q->where('role_id',8);
        //    })->get();
        //Just a comment

        $allinfo  = CashFlowModel::where('is_approved_by_inventory', 0)
                            ->where('is_approved_by_supplychain', 0)
                            ->where('is_approved_by_ceo', 0)
                            ->get();

        $doneinfo  = CashFlowModel::where('is_approved_by_inventory', 1)
                            ->where('is_approved_by_supplychain', 1)
                            ->where('is_approved_by_ceo', 1)
                            ->get();

        $username  = Auth::user()->first_name." ".Auth::user()->last_name;

        
        $data   = [
            'users'     => $users,
            'allinfo'   => $allinfo,
            'doneinfo'  => $doneinfo,
            'username'  => $username

        ];
        return view('admin.costmanagement.cashFlow', $data);
    }



    public function cashflowInsertAjax(Request $request)
    {
        $user_id        = Auth::user()->id;
        
        $attributeNames = array(
            'date'                      => $request->date,
            'description'               => $request->description,
            'type'                      => $request->type,
            'payable_amount'            => $request->payable_amount,
        );
        // dd($attributeNames);

        $validator = Validator::make($attributeNames, [
            'date'                 => 'required',
            'description'          => 'required',
            'type'                 => 'required',
            'payable_amount'       => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'data'      => $validator->getMessageBag()->toArray(),
                'status'    => 'validation-error',
                'message'   => null
            ]);
        } else {
            DB::beginTransaction();
            try {

                $info =  new CashFlowModel;
                $info->user_id              = $user_id;
                $info->date                 = $request->date;
                $info->description          = $request->description;
                $info->type                 = $request->type;
                $info->payable_amount       = $request->payable_amount;
                $info->save();

                DB::commit();
                return response()->json([
                    'data'      => null,
                    'status'    => true,
                    'message'   => 'Success'
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
    }



    public function getCashFlowInfo(Request $request)
    {
        $cashflowInfo = CashFlowModel::findOrFail($request->id);
        return response()->json($cashflowInfo);
    }



    public function update(Request $request)
    {
        $user_id        = Auth::user()->id;
        $cashflow_update = CashFlowModel::findOrFail($request->cashflow_id);
        $attributeNames  = array(
            'date'                      => $request->date,
            'description'               => $request->description,
            'type'                      => $request->type,
            'payable_amount'            => $request->payable_amount
        );

        $validator = Validator::make($attributeNames, []);

        if ($validator->fails()) {
            return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        } else {
            $cashflow_update->user_id                       = $user_id;
            $cashflow_update->date                          = $request->date;
            $cashflow_update->description                   = $request->description;
            $cashflow_update->type                          = $request->type;
            $cashflow_update->payable_amount                = $request->payable_amount;
            $cashflow_update->update();

            return response()->json("Success");
        }
    }



    // INVENTORY
    public function approveInventoryView()
    {
        // $inventoryinfo  = CashFlowModel::where('is_approved_by_inventory', 0)
        //                     ->where('is_approved_by_ceo', 0)
        //                     ->get();
        $inventoryinfo  = CashFlowModel::where('is_approved_by_inventory', 0)
                            ->get();

        $inventoryapproved  = CashFlowModel::where('is_approved_by_inventory', 1)
                            // ->where('is_approved_by_supplychain', 0)
                            // ->where('is_approved_by_ceo', 0)
                            ->get();
        $data   = [
            'inventoryinfo'      => $inventoryinfo,
            'inventoryapproved'  => $inventoryapproved
        ];
        return view('admin.costmanagement.approveInventory', $data);
    }

    public function approveByInv(Request $request)
    {

        CashFlowModel::where('id', $request->id)
            ->update(['is_approved_by_inventory' => 1]);
        return response()->json('Success', 200);
    }



    //SUPPLYCHAIN
    public function approveBySupplyChainView()
    {

        $supplyChainInfo  = CashFlowModel::where('is_approved_by_supplychain', 0)
                            ->get();

        $supplyapproved  = CashFlowModel::where('is_approved_by_supplychain', 1)
                            ->get();

        $data   = [
            'supplyChainInfo'   => $supplyChainInfo,
            'supplyapproved'    => $supplyapproved
        ];
        return view('admin.costmanagement.approveBySupplyChain', $data);
    }

    public function approveBySupp(Request $request)
    {
        CashFlowModel::where('id', $request->id)
            ->update(['is_approved_by_supplychain' => 1]);
        return response()->json('Success', 200);
    }



    //HOP
    public function approveByHopView()
    {

        $hopInfo      = CashFlowModel::where('is_approved_by_hop', 0)
                            ->get();

        $hopapproved  = CashFlowModel::where('is_approved_by_hop', 1)
                            ->get();

        $data   = [
            'hopInfo'           => $hopInfo,
            'hopapproved'       => $hopapproved
        ];
        return view('admin.costmanagement.approveByHop', $data);
    }

    public function approvedByHop(Request $request)
    {
        CashFlowModel::where('id', $request->id)
            ->update(['is_approved_by_hop' => 1]);
        return response()->json('Success', 200);
    }



    //CEO
    public function approveByCeoView()
    {
        $ceoInfo  = CashFlowModel::where('is_approved_by_ceo', 0)
                            ->get();

        $ceoapproved  = CashFlowModel::where('is_approved_by_ceo', 1)
                            ->get();

        $data   = [
            'ceoInfo'       => $ceoInfo,
            'ceoapproved'   => $ceoapproved
        ];
        return view('admin.costmanagement.approveByCeo', $data);
    }



    public function approveByCeo(Request $request)
    {
        $userInfo = CashFlowModel::where('id', $request->id);

        $userInfo->update(['is_approved_by_ceo' => 1]);

        $userInfos = $userInfo->first();

            $attributeNames = array(
                'date'             => $userInfos->date,
                'description'      => $userInfos->description,
                'amount'           => $userInfos->payable_amount,
                'withdraw_by'      => $userInfos->user_id,
                'inserted_by'      => Auth::user()->first_name 
                
            );
            //validating the attributes
            $validator = Validator::make($attributeNames, [
                'date' => 'required',
                'description' => 'required',
                'amount' => 'required',
                'withdraw_by' => 'required'
            ]);
            try {
                CashWithDrawModel::create($attributeNames);

            } catch (\Exception $exception) {
                return response()->json(array('dbErrors' => $exception->getMessage()));
            }

        return response()->json('Success', 200);
    }



    //ALL REQUISITIONS
    public function allRequisitionsView()
    {
        $allRequisitions  = CashFlowModel::get();

        $data   = [
            'allRequisitions'       => $allRequisitions
        ];

        return view('admin.costmanagement.allRequisitions', $data);
    }



}
