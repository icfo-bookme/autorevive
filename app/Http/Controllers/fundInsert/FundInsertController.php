<?php

namespace App\Http\Controllers\fundInsert;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\FundInsert\FundCategory;
use App\FundInsert\FundInsert;
use App\FundInsert\FundSubCategory;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Yajra\DataTables\DataTables;

class FundInsertController extends Controller
{

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * Fetch sub categories by category id
     */
    public function getFundSubcategoriesByCategoryId(Request $request)
    {
        try{
            $categoryId     = $request->categoryId;
            $subCategories  = FundSubCategory::select('id','name')->where('category_id',$categoryId)->where('soft_delete',SOFT_DELETE_NO)->get();

            if($subCategories){
                return response()->json([
                    'data'      => $subCategories,
                    'status'    => true,
                    'message'   => 'Successful'
                ]);
            }

            return response()->json([
                'data'      => $subCategories,
                'status'    => false,
                'message'   => 'Something happened wrong!'
            ]);
        }catch (Exception $exception){
            Log::error($exception->getMessage());

            return response()->json([
                'data'      => $exception->getMessage(),
                'status'    => false,
                'message'   => 'Something went wrong! Please try again'
            ]);
        }
    }

    /**
     * Returns blade for fund insert view
     */
    public function fundInsertView()
    {
        $categories = FundCategory::where('soft_delete', SOFT_DELETE_NO)->get();

        $data = [
            'categories' => $categories
        ];
        return view('admin.fundInsert.fundInsertView', $data);
    }

    /**
     * @param Request $request
     * @return mixed
     * @throws \Exception
     * Returns all fund data for datatable display
     */
    public function listAllInsertedFunds(Request $request)
    {

        $fundInsertData = FundInsert::with(['category','subcategory'])->where(['fund_inserts.soft_delete' => 0])->orderBy('fund_inserts.updated_at', 'desc');
        return Datatables::of($fundInsertData)
            ->addColumn('data_category_name', function ($data) {
                return $data->category->name;
            })
            ->addColumn('data_subcategory_name', function ($data) {
               if($data->subcategory == null){
                    return "Not available";
               } else{
                return $data->subcategory->name;
               }
            })
            ->addColumn('action', function ($data) {
                $userId  = auth()->user()->id;
                if(($userId==env('SUPERADMIN_ID') || $userId==env('HOP_ID') || $userId==env('ACCOUNTS_ID') || $userId==env('MANAGER_ID') || $userId==env('OPERATION_MANAGER_ID'))) {
                    return '<button class="btn btn-primary btn-xs" title="Edit" onclick="fundEdit('.$data->id.')">
                                <i class="fa fa-pencil"></i>
                            </button>
                            <button class="btn btn-danger btn-xs" title="Delete" onclick="fundDelete('.$data->id.')">
                                <i class="fa fa-trash"></i>
                            </button>';
                }
            })
            ->rawColumns(['action','data_category_name','data_subcategory_name'])
            ->make(true);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * Fund insert
     */
    public function fundInsert(Request $request)
    {
        try {
            $categoryId     = $request->category_id;
            $subcategoryId  = $request->subcategory_id;

            $attributeNames = array(
                'category_id'       => $categoryId,
                'subcategory_id'    => $subcategoryId,
                'name'              => $request->name,
                'amount'            => $request->amount,
                'date'              => $request->date
            );

            //validating the attributes
            $validator = Validator::make($attributeNames, [
                'category_id'       => 'required',
                // 'subcategory_id'    => 'required',
                'amount'            => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'data'      => $validator->getMessageBag()->toArray(),
                    'status'    => "validation-error",
                    'message'   => "Fund creation failed!"
                ]);
            }

            //Inserting data
            $response = FundInsert::create([
                'category_id'       => $categoryId,
                'subcategory_id'    => $subcategoryId,
                'amount'            => $request->amount,
                'date'              => $request->date,
                'created_by'        => auth()->user()->id,
                'updated_by'        => auth()->user()->id,
                'description'       => $request->description,
                'soft_delete'       => SOFT_DELETE_NO
            ]);

            if ($response) {
                return response()->json([
                    'data'      => $response,
                    'status'    => true,
                    'message'   => 'Fund saved succesfully'
                ]);
            }

            return response()->json([
                'data'      => $response,
                'status'    => false,
                'message'   => 'Fund Saving failed! Please try again'
            ]);

        } catch (Exception $exception) {
            Log::error($exception->getMessage());
            return response()->json([
                'data'      => $exception->getMessage(),
                'status'    => false,
                'message'   => 'Something went wrong! Please try again'
            ]);
        }
    }

    /**
     *Display edit form
     */
    public function getFundEditForm(Request $request)
    {
        try{
            $categories = FundCategory::where('soft_delete',SOFT_DELETE_NO)->get();
            $fundData   = FundInsert::where('id',$request->get('id'))->first();

            $fundSubCategories = FundSubCategory::where('category_id',$fundData->category_id)->where('soft_delete',SOFT_DELETE_NO)->get();

            if($fundData){
                return response()->json([
                    'data' => view('admin.fundInsert.fundEditForm')->with([
                            'fundData'          => $fundData,
                            'categories'        => $categories,
                            'fundSubCategories' => $fundSubCategories,
                        ])->render(),
                    'status'    => true,
                    'message'   => 'successful'
                ]);
            }

            return response()->json([
                'data'      => $fundData,
                'status'    => false,
                'message'   => 'Form fetch failed! Please try again'
            ]);
        } catch(Exception $exception){
            Log::error($exception->getMessage());

            return response()->json([
                'data'      => $exception->getMessage(),
                'status'    => false,
                'message'   => 'Something went wrong! Please try again'
            ]);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * Fund is updated here
     */
    public function fundUpdate(Request $request)
    {
        try {
            $categoryId     = $request->category_id;
            $subcategoryId  = $request->subcategory_id;

            $attributeNames = array(
                'name'              => $request->name,
                'category_id'       => $categoryId,
                'subcategory_id'    => $subcategoryId,
                'amount'            => $request->amount,
                'date'              => $request->date
            );

            //validating the attributes
            $validator = Validator::make($attributeNames, [
                'category_id'       => 'required',
                'subcategory_id'    => 'required',
                'amount'            => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'data'      => $validator->getMessageBag()->toArray(),
                    'status'    => "validation-error",
                    'message'   => "Fund updating failed!"
                ]);
            }

            //Updating data
            $response = FundInsert::where('id',$request->fund_insert_id)->update([
                'category_id'       => $categoryId,
                'subcategory_id'    => $subcategoryId,
                'amount'            => $request->amount,
                'date'              => $request->date,
                'updated_by'        => auth()->user()->id,
                'description'       => $request->description,
            ]);

            if ($response) {
                return response()->json([
                    'data'      => $response,
                    'status'    => true,
                    'message'   => 'Fund updated succesfully'
                ]);
            }

            return response()->json([
                'data'      => $response,
                'status'    => false,
                'message'   => 'Fund updating failed! Please try again'
            ]);

        } catch (Exception $exception) {
            Log::error($exception->getMessage());
            return response()->json([
                'data'      => $exception->getMessage(),
                'status'    => false,
                'message'   => 'Something went wrong! Please try again'
            ]);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * Deletes fund (Soft delete)
     */
    public function fundDelete(Request $request)
    {
        try{
            $response = FundInsert::where('id',$request->id)->update([
                'soft_delete' => SOFT_DELETE_YES
            ]);

            if($response){
                return response()->json([
                    'status'    => true,
                    'message'   => 'Fund successfully removed',
                    'data'      => $response
                ]);
            }

            return response()->json([
                'status'    => false,
                'message'   => 'Fund removing failed! Please try again',
                'data'      => null
            ]);
        }catch (Exception $exception){
            Log::error($exception->getMessage());

            return response()->json([
                'data'      => $exception->getMessage(),
                'status'    => false,
                'message'   => 'Something went wrong! Please try again'
            ]);
        }
    }

    
}
