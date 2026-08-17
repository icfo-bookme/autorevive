<?php

namespace App\Http\Controllers\costInsert;

use App\CostInsert\CostCategory;
use App\CostInsert\CostInsert;
use App\CostInsert\CostSubCategory;
use App\CostInsert\CostInsertAudit;
use App\CostEditReason;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use DB; 
use Exception;

class CostInsertController extends Controller
{
    public function __construct()
    {
        $roleArray  = [
            env('SUPERADMIN_ID') => 'superadmin',
            env('MANAGER_ID') => 'manager',
            env('HOP_ID') => 'hop',
            env('ACCOUNTS_ID') => 'accounts',
            env('OPERATION_MANAGER_ID') => 'opManager',
        ];
        $this->roleArray = $roleArray;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * Fetch sub categories by category id
     */
    public function getSubcategoriesByCategoryId(Request $request)
    {
        try{
            $categoryId = $request->categoryId;
            $subCategories = CostSubCategory::select('id','name')->where('category_id',$categoryId)->where('soft_delete',SOFT_DELETE_NO)->get();

            if($subCategories){
                return response()->json([
                    'data' => $subCategories,
                    'status' => true,
                    'message' => 'Successful'
                ]);
            }

            return response()->json([
                'data' => $subCategories,
                'status' => false,
                'message' => 'Something happened wrong!'
            ]);
        }catch (Exception $exception){
            Log::error($exception->getMessage());

            return response()->json([
                'data' => $exception->getMessage(),
                'status' => false,
                'message' => 'Something went wrong! Please try again'
            ]);
        }
    }

    /**
     * Returns blade for cost insert view
     */
    public function costInsertView()
    {
        $categories = CostCategory::where('soft_delete', SOFT_DELETE_NO)->get();

        $data = [
            'categories' => $categories
        ];
        return view('admin.costinsert.costInsertView', $data);
    }

    /**
     * @param Request $request
     * @return mixed
     * @throws \Exception
     * Returns all cost categories data for datatable display
     */
    public function listAllInsertedCosts(Request $request)
    {
        // dd($request->getApproval);
        $role = null;
        if(array_key_exists(auth()->user()->id,$this->roleArray)){
            $role = $this->roleArray[auth()->user()->id];
        }
        
        // if($request->getApproval == 'superadmin'){
        //     $costInsertData = CostInsert::with(['category','subcategory'])->where(['cost_inserts.soft_delete' => 0, 'cost_inserts.is_approved_by_superadmin' => 0])->orderBy('cost_inserts.updated_at', 'desc');
        // }else if($request->getApproval == 'hop'){
        //     $costInsertData = CostInsert::with(['category','subcategory'])->where(['cost_inserts.soft_delete' => 0, 'cost_inserts.is_approved_by_hop' => 0])->orderBy('cost_inserts.updated_at', 'desc');
        // }else if($request->getApproval == 'manager'){
        //     $costInsertData = CostInsert::with(['category','subcategory'])->where(['cost_inserts.soft_delete' => 0, 'cost_inserts.is_approved_by_manager' => 0])->orderBy('cost_inserts.updated_at', 'desc');
        // }else if($request->getApproval == 'accounts'){
        //     $costInsertData = CostInsert::with(['category','subcategory'])->where(['cost_inserts.soft_delete' => 0, 'cost_inserts.is_approved_by_accounts' => 0])->orderBy('cost_inserts.updated_at', 'desc');
        // }else if($request->getApproval == 'opManager'){
        //     $costInsertData = CostInsert::with(['category','subcategory'])->where(['cost_inserts.soft_delete' => 0, 'cost_inserts.is_approved_by_opManager' => 0])->orderBy('cost_inserts.updated_at', 'desc');
        // }else{
        //     $costInsertData = CostInsert::with(['category','subcategory'])->where(['cost_inserts.soft_delete' => 0])->orderBy('cost_inserts.updated_at', 'desc');
        // }
        if($request->getApproval == 'superadmin'){
            $costInsertData = CostInsert::with(['category','subcategory'])->where(['cost_inserts.soft_delete' => 0, 'cost_inserts.is_approved_by_superadmin' => 0])->orderBy('cost_inserts.created_at', 'desc');
        }else if($request->getApproval == 'hop'){
            $costInsertData = CostInsert::with(['category','subcategory'])->where(['cost_inserts.soft_delete' => 0, 'cost_inserts.is_approved_by_hop' => 0])->orderBy('cost_inserts.created_at', 'desc');
        }else if($request->getApproval == 'manager'){
            $costInsertData = CostInsert::with(['category','subcategory'])->where(['cost_inserts.soft_delete' => 0, 'cost_inserts.is_approved_by_manager' => 0])->orderBy('cost_inserts.created_at', 'desc');
        }else if($request->getApproval == 'accounts'){
            $costInsertData = CostInsert::with(['category','subcategory'])->where(['cost_inserts.soft_delete' => 0, 'cost_inserts.is_approved_by_accounts' => 0])->orderBy('cost_inserts.created_at', 'desc');
        }else if($request->getApproval == 'opManager'){
            $costInsertData = CostInsert::with(['category','subcategory'])->where(['cost_inserts.soft_delete' => 0, 'cost_inserts.is_approved_by_opManager' => 0])->orderBy('cost_inserts.created_at', 'desc');
        }else{
            $costInsertData = CostInsert::with(['category','subcategory'])->where(['cost_inserts.soft_delete' => 0])->orderBy('cost_inserts.created_at', 'desc');
        }
        // $costInsertData = CostInsert::with(['category','subcategory'])->where(['cost_inserts.soft_delete' => 0])->orderBy('cost_inserts.created_at', 'desc');

        return Datatables::of($costInsertData)
            ->addColumn('data_category_name', function ($data) {
                return $data->category->name;
            })
            ->addColumn('data_subcategory_name', function ($data) {
                return $data->subcategory->name;
            })
            ->addColumn('data_approved_by',function($data){
                $editedCheck = CostInsertAudit::where(['cost_id' => $data->id, 'trigger_type' => 'before_update'])->where('amount','!=',$data->amount)->OrderBy('updated_at','DESC')->first();
    
                $approvedSection = '';
                if($data->is_approved_by_superadmin == IS_APPROVED){
                    $approvedSection .= '<span class="badge badge-success" title="Approved by superadmin">S</span>';
                } else{
                    $approvedSection .= '<span class="badge badge-warning" title="Not approved by superadmin">S</span>';
                }
                if($data->is_approved_by_hop == IS_APPROVED){
                    $approvedSection .= '
                                        <span class="badge badge-success" title="Approved by hop">H</span>';
                } else{
                    $approvedSection .= '
                                            <span class="badge badge-warning" title="Not approved by hop">H</span>';
                }
                if($data->is_approved_by_manager == IS_APPROVED){
                    $approvedSection .= '
                                            <span class="badge badge-success" title="Approved by manager">M</span>';
                } else{
                    $approvedSection .= '
                                            <span class="badge badge-warning" title="Not approved by manager">M</span>';
                }
                if($data->is_approved_by_accounts == IS_APPROVED){
                    $approvedSection .= '
                                            <span class="badge badge-success" title="Approved by accounts">A</span>';
                } else{
                    $approvedSection .= '
                                            <span class="badge badge-warning" title="Not approved by accounts">A</span>';
                }
                if($data->is_approved_by_opManager == IS_APPROVED){
                    $approvedSection .= '
                                            <span class="badge badge-success" title="Approved by operation manager">O</span>';
                } else{
                    $approvedSection .= '
                                            <span class="badge badge-warning" title="Approved by operation manager">O</span>';
                }
                if($editedCheck){
                    $approvedSection .= '<p style ="opacity: 0.6;">edited</p>';
                }
                return $approvedSection;
            })
            ->addColumn('action', function ($data) use($role) {
                $userId     = auth()->user()->id;
                //Shows approval button if user is superadmin, manager, hop or accounts
                $approveCheck = '';
                if($role != null){
                    $fieldName = "is_approved_by_".$role;
                    if($data[$fieldName] == IS_APPROVED){
                        $approveCheck = '
                                      <button class="btn btn-danger btn-xs" title="Not Approve" onclick="approvalStatusChange('.$data->id.',0)">
                                                <i class="fa fa-times"></i>
                                            </button>';
                    } else{
                        $approveCheck = '
                                       <button class="btn btn-info btn-xs" title="Approve" onclick="approvalStatusChange('.$data->id.',1)">
                                                <i class="fa fa-check"></i>
                                            </button>';
                    }
                }

                if (
                    $userId == env('SUPERADMIN_ID') || 
                    $userId == env('HOP_ID') || 
                    $userId == env('ACCOUNTS_ID') || 
                    $userId == env('MANAGER_ID') || 
                    $userId == env('OPERATION_MANAGER_ID')
                ) {
                    return '<button class="btn btn-primary btn-xs" title="Edit" onclick="costEdit(' . $data->id . ')">
                                <i class="fa fa-pencil"></i>
                            </button>
                            <button class="btn btn-danger btn-xs" title="Delete" onclick="costDelete(' . $data->id . ')">
                                <i class="fa fa-trash"></i>
                            </button>' . 
                            $approveCheck . 
                            ' <button class="btn btn-success btn-xs" title="Details" onclick="costDetails(' . $data->id . ')">
                                <i class="fa fa-info-circle"></i>
                            </button>';
                }
                

                // if(($userId==env('SUPERADMIN_ID') || $userId==env('HOP_ID') || $userId==env('ACCOUNTS_ID') || $userId==env('MANAGER_ID'))) {
                //     return '<button class="btn btn-primary btn-xs" title="Edit" onclick="costEdit('.$data->id.')">
                //                 <i class="fa fa-pencil"></i>
                //             </button>
                //             <button class="btn btn-danger btn-xs" title="Delete" onclick="costDelete('.$data->id.')">
                //                 <i class="fa fa-trash"></i>
                //             </button>'.$approveCheck.
                //             ' <button class="btn btn-outline-dark btn-xs" title="log" onclick="costLog('.$data->id.')">
                //                 <i class="fa fa-history"></i>
                //             </button>';
                // }
            })
            ->rawColumns(['action','data_category_name','data_subcategory_name','data_approved_by'])
            ->make(true);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * Cost Sub-category insert
     */
    public function costInsert(Request $request)
    {
        try {
            $categoryId = $request->category_id;
            $subcategoryId = $request->subcategory_id;

            $attributeNames = array(
                'name' => $request->name,
                'category_id' => $categoryId,
                'subcategory_id' => $subcategoryId,
                'amount' => $request->amount,
                'date' => $request->date
            );

            //validating the attributes
            $validator = Validator::make($attributeNames, [
                'category_id' => 'required',
                'subcategory_id' => 'required',
                'amount' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'data' => $validator->getMessageBag()->toArray(),
                    'status' => "validation-error",
                    'message' => "Cost creation failed!"
                ]);
            }

            //Inserting data
            $response = CostInsert::create([
                'category_id' => $categoryId,
                'subcategory_id' => $subcategoryId,
                'amount' => $request->amount,
                'date' => $request->date,
                'created_by' => auth()->user()->first_name,
                'updated_by' => auth()->user()->first_name,
                'description' => $request->description,
                'soft_delete'=> SOFT_DELETE_NO
            ]);

            if ($response) {
                return response()->json([
                    'data' => $response,
                    'status' => true,
                    'message' => 'Cost saved succesfully'
                ]);
            }

            return response()->json([
                'data' => $response,
                'status' => false,
                'message' => 'Cost Saving failed! Please try again'
            ]);

        } catch (Exception $exception) {
            Log::error($exception->getMessage());
            return response()->json([
                'data' => $exception->getMessage(),
                'status' => false,
                'message' => 'Something went wrong! Please try again'
            ]);
        }
    }

    /**
     *Display edit form
     */
    public function getCostEditForm(Request $request)
    {
        try{
            $categories = CostCategory::where('soft_delete',SOFT_DELETE_NO)->get();
            $costData = CostInsert::where('id',$request->get('id'))->first();

            $costSubCategories = CostSubCategory::where('category_id',$costData->category_id)->where('soft_delete',SOFT_DELETE_NO)->get();

            if($costData){
                return response()->json([
                    'data' => view('admin.costinsert.costEditForm')->with([
                        'costData' => $costData,
                        'categories' => $categories,
                        'costSubCategories' => $costSubCategories,
                    ])->render(),
                    'status' => true,
                    'message' => 'successful'
                ]);
            }

            return response()->json([
                'data' => $costData,
                'status' => false,
                'message' => 'Form fetch failed! Please try again'
            ]);
        } catch(Exception $exception){
            Log::error($exception->getMessage());

            return response()->json([
                'data' => $exception->getMessage(),
                'status' => false,
                'message' => 'Something went wrong! Please try again'
            ]);
        }
    }

    public function showCostEditReasonPage(Request $request)
    {
        $html = view('admin.costEditReason.costEditReasons', [
            'cost_insert_id' => $request->id
        ])->render(); 
    
        return response()->json([
            'status' => true,
            'data' => $html
        ]);
    }

    
    public function getCostEditReasonDetails(Request $request)
    {
        $query = CostEditReason::with(['category', 'subcategory'])
            ->where('cost_insert_id', $request->id) 
            ->orderBy('created_at', 'desc');
            
        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('category', function ($item) {
                return $item->category->name ?? 'N/A';
            })
            ->addColumn('subcategory', function ($item) {
                return $item->subcategory->name ?? 'N/A';
            })
            ->addColumn('created_at', function ($item) {
                return $item->created_at->format('Y-m-d H:i:s'); 
            })
            ->make(true); 
    }

    /**
     *Display log form
     */
    public function getCostLogForm(Request $request)
    {
        try{
            $costInsertData = CostInsert::with(['category','subcategory'])->where(['cost_inserts.soft_delete' => 0, 'id' => $request->id])->orderBy('cost_inserts.updated_at', 'desc')->get();
            $costLogData = CostInsertAudit::with(['category','subcategory'])->where(['trigger_type' => 'before_update', 'cost_id' => $request->id])->orderBy('updated_at', 'desc')->latest()->first()->get();
            $final = $costInsertData->merge($costLogData);
            // dd($costLogData);

            if($costInsertData){
                return response()->json([
                    'data' => view('admin.costinsert.costLogForm')->with([
                        'final' => $final,
                        

                    ])->render(),
                    'status' => true,
                    'message' => 'successful'
                ]);
            }

            return response()->json([
                'data' => $costInsertData,
                'status' => false,
                'message' => 'Form fetch failed! Please try again'
            ]);
        } catch(Exception $exception){
            Log::error($exception->getMessage());

            return response()->json([
                'data' => $exception->getMessage(),
                'status' => false,
                'message' => 'Something went wrong! Please try again'
            ]);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * Sub Category is updated here
     */
    public function costUpdate(Request $request)
    {
        try {

            DB::beginTransaction();

            $attributeNames = array(
                'name' => $request->name,
                'category_id' => $request->category_id,
                'subcategory_id' => $request->subcategory_id,
                'amount' => $request->amount,
                'date' => $request->date,
                'reason' => $request->reason,
            );

            //validating the attributes
            $validator = Validator::make($attributeNames, [
                'category_id' => 'required',
                'subcategory_id' => 'required',
                'amount' => 'required',
                'reason' => 'required'
            ]);

            if ($validator->fails()) {
                DB::rollback();
                return response()->json([
                    'data' => $validator->getMessageBag()->toArray(),
                    'status' => "validation-error",
                    'message' => "Cost updating failed!"
                ]);
            }

            $prevCostDetails = CostInsert::where('id',$request->cost_insert_id)->first();
            $prevAmount = $prevCostDetails->amount;

            //Updating data
            if($prevAmount == $request->amount){

                $attributes = array(
                    'category_id' => $request->category_id,
                    'subcategory_id' => $request->subcategory_id,
                    'date' => $request->date,
                    'description' => $request->description,
                    'updated_by' => auth()->user()->first_name
                );

            }else {

                $attributes = array(
                    'category_id' => $request->category_id,
                    'subcategory_id' => $request->subcategory_id,
                    'amount' => $request->amount,
                    'date' => $request->date,
                    'description' => $request->description,
                    'is_approved_by_superadmin' => 0,
                    'is_approved_by_hop' => 0,
                    'is_approved_by_manager' => 0,
                    'is_approved_by_accounts' => 0,
                    'is_approved_by_opManager' => 0,
                    'is_approved_by_all' => 0,
                    'updated_by' => auth()->user()->first_name
                );

            }

            
            $response = CostInsert::where('id',$request->cost_insert_id)->update($attributes);

            if ($response) {
                $editReason = new CostEditReason();
                $editReason->cost_insert_id = $request->cost_insert_id;
                $editReason->category_id = $request->category_id; 
                $editReason->subcategory_id = $request->subcategory_id;
                $editReason->amount = $request->amount; 
                $editReason->prev_amount = $prevAmount;
                $editReason->date = $request->date;
                $editReason->description = $request->description;
                $editReason->reason = $request->reason; 
                $editReason->created_by = auth()->user()->first_name;
                $editReason->save();
    
                DB::commit(); 
                return response()->json([ 'data' => $response, 'status' => true, 'message' => 'Cost updated successfully']);
            } else {
                DB::rollback();
                return response()->json([ 'data' => $response, 'status' => false, 'message' => 'Error updating cost']);
            }
            

            // //Updating data
            // $response = CostInsert::where('id',$request->cost_insert_id)->update([
            //     'category_id' => $categoryId,
            //     'subcategory_id' => $subcategoryId,
            //     'amount' => $request->amount,
            //     'date' => $request->date,
            //     'updated_by' => auth()->user()->first_name,
            //     'description' => $request->description,
            // ]);
        } catch (Exception $exception) {
            DB::rollback();
            Log::error($exception->getMessage());
            return response()->json([
                'data' => $exception->getMessage(),
                'status' => false,
                'message' => 'Something went wrong! Please try again'
            ]);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * Deletes cost (Soft delete)
     */
    public function costDelete(Request $request)
    {
        try{
            $response = CostInsert::where('id',$request->id)->update([
                'soft_delete' => SOFT_DELETE_YES
            ]);

            if($response){
                return response()->json([
                    'status' => true,
                    'message' => 'Cost successfully removed',
                    'data' => $response
                ]);
            }

            return response()->json([
                'status' => false,
                'message' => 'Cost removing failed! Please try again',
                'data' => null
            ]);
        }catch (Exception $exception){
            Log::error($exception->getMessage());

            return response()->json([
                'data' => $exception->getMessage(),
                'status' => false,
                'message' => 'Something went wrong! Please try again'
            ]);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * Changes approval status depends on request
     */
    public function approvalStatusChange(Request $request)
    {
        try{
            $costId = $request->id;
            $approvalStatus = $request->approvalStatus;
            if($approvalStatus == 1){
                //Make approved
                $fieldName = 'is_approved_by_'.$this->roleArray[auth()->user()->id];
                CostInsert::where('id',$costId)->update([
                    $fieldName => IS_APPROVED
                ]);

                $costData = CostInsert::where('id',$costId)->first();
                if($costData->is_approved_by_superadmin == IS_APPROVED && $costData->is_approved_by_hop && $costData->is_approved_by_manager == IS_APPROVED && $costData->is_approved_by_accounts == IS_APPROVED  && $costData->is_approved_by_opManager == IS_APPROVED){
                   CostInsert::where('id',$costData->id)->update([
                       'is_approved_by_all' => IS_APPROVED
                   ]) ;
                }
                return response()->json([
                    'data' => null,
                    'status' => true,
                    'message' => "Successfully approved"
                ]);

            } else{
                //Disprove
                $fieldName = 'is_approved_by_'.$this->roleArray[auth()->user()->id];
                CostInsert::where('id',$costId)->update([
                    $fieldName => IS_NOT_APPROVED,
                    'is_approved_by_all' => IS_NOT_APPROVED
                ]);

                return response()->json([
                    'data' => null,
                    'status' => true,
                    'message' => "Approval cancelled"
                ]);
            }
        }catch(Exception $exception)
        {
            Log::error($exception->getMessage());

            return response()->json([
                'data' => $exception->getMessage(),
                'status' => false,
                'message' => 'Something went wrong! Please try again'
            ]);

        }
    }
}
