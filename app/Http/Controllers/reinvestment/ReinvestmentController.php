<?php

namespace App\Http\Controllers\reinvestment;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Reinvestment\Reinvestment;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Yajra\DataTables\DataTables;

class ReinvestmentController extends Controller
{
    /**
     * Returns blade for reinvestment view
     */
    public function reinvestmentView()
    {
        return view('admin.reinvestment.reinvestmentView');
    }

    /**
     * @param Request $request
     * @return mixed
     * @throws \Exception
     * Returns all reinvestment data for datatable display
     */
    public function listAllReinvestment(Request $request)
    {
        $reinvestmentData = Reinvestment::with(['createdBy','updatedBy'])->where(['soft_delete' => SOFT_DELETE_NO])->orderBy('updated_at', 'desc');

        return Datatables::of($reinvestmentData)

            ->addColumn('data_created_by', function ($data) {
                return $data->createdBy->first_name;
            })
            ->addColumn('data_updated_by', function ($data) {
                return $data->updatedBy->first_name;
            })
            ->addColumn('action', function ($data) {
                $userId = auth()->user()->id;
                if(($userId==env('SUPERADMIN_ID') || $userId==env('HOP_ID') || $userId==env('ACCOUNTS_ID') || $userId==env('MANAGER_ID') || $userId==env('OPERATION_MANAGER_ID'))) {
                    return '<button class="btn btn-primary btn-xs" title="Edit" onclick="reinvestmentEdit('.$data->id.')">
                                <i class="fa fa-pencil"></i>
                            </button>
                            <button class="btn btn-danger btn-xs" title="Delete" onclick="reinvestmentDelete('.$data->id.')">
                                <i class="fa fa-trash"></i>
                            </button>';
                }
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * Reinvestment insert
     */
    public function reinvestmentInsert(Request $request)
    {
        try {
            //gettings attributes
            $attributeNames = array(
                'amount'        => $request->amount,
                'date'          => $request->date,
                'description'   => $request->description
            );

            //validating the attributes
            $validator = Validator::make($attributeNames, [
                'amount'      => 'required',
                'description' => 'required'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'data'      => $validator->getMessageBag()->toArray(),
                    'status'    => "validation-error",
                    'message'   => "Reinvestment creation failed"
                ]);
            }

            //Inserting data
            $response = Reinvestment::create([
                'amount'        => $request->amount,
                'date'          => $request->date,
                'description'   => $request->description,
                'created_by'    => auth()->user()->id,
                'updated_by'    => auth()->user()->id
            ]);
            if ($response) {
                return response()->json([
                    'data'      => $response,
                    'status'    => true,
                    'message'   > 'Reinvestment created succesfully'
                ]);
            }

            return response()->json([
                'data'      => $response,
                'status'    => false,
                'message'   => 'Reinvestment creation failed! Please try again'
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
    public function getReinvestmentEditForm(Request $request)
    {
        try{
            $reinvestmentData = Reinvestment::where('id',$request->get('id'))->first();

            if($reinvestmentData){
                return response()->json([
                    'data'    => view('admin.reinvestment.reinvestmentEditForm')->with([
                            'reinvestmentData' => $reinvestmentData,
                        ])->render(),
                    'status'  => true,
                    'message' => 'successfully'
                ]);
            }

            return response()->json([
                'data'      => $reinvestmentData,
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
     * Reivestment is updated here
     */
    public function reinvestmentUpdate(Request $request)
    {
        try{
            //gettings attributes
            $reinvestmentId = $request->reinvestment_id;

            $attributeNames = array(
                'reinvestment_id' => $reinvestmentId,
                'amount'          => $request->amount,
                'date'            => $request->date,
                'description'     => $request->description,


            );

            //validating the attributes
            $validator = Validator::make($attributeNames, [
                'amount'      => 'required',
                'description' => 'required',

            ]);

            if ($validator->fails()) {
                return response()->json([
                    'data'      => $validator->getMessageBag()->toArray(),
                    'status'    => "validation-error",
                    'message'   => "Investment update failed"
                ]);
            }

            $response = Reinvestment::where('id',$request->reinvestment_id)->update([
                'amount'        => $request->amount,
                'date'          => $request->date,
                'description'   => $request->description,
                'updated_by'    => auth()->user()->id
            ]);

            if($response){
                return response()->json([
                    'data'      => $response,
                    'status'    => true,
                    'message'   => 'Investment updated successfully'
                ]);
            }
            return response()->json([
                'data'      => $response,
                'status'    => false,
                'message'   => 'Investment update failed! Please try again'
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
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * Deletes reivestment (Soft delete)
     */
    public function investmentDelete(Request $request)
    {
        try{
            $response = Reinvestment::where('id',$request->id)->update([
                'soft_delete' => SOFT_DELETE_YES
                ]);

            if($response){
                return response()->json([
                    'status'    => true,
                    'message'   => 'Reivestment successfully removed',
                    'data'      => $response
                ]);
            }

            return response()->json([
                'status'    => false,
                'message'   => 'Reivestment removing failed! Please try again',
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
