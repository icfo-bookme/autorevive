<?php

namespace App\Http\Controllers\sms;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\SMS\SmsTemplate;
use App\SMS\SmsSetting;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class SmsController extends Controller
{
    /**
     * Returns blade for sms template crud
     */
    public function smsTemplateView() {
        return view('admin.sms.smsTemplateView');
    }

    /**
     * @param Request $request
     * @return mixed
     * @throws \Exception
     * Returns all sms template data for datatable display
     */
    public function listAllTemplate(Request $request)
    {
        $templateData = SmsTemplate::where(['soft_delete' => SOFT_DELETE_NO])->orderBy('updated_at', 'desc');

        return Datatables::of($templateData)

            ->addColumn('data_created_by', function ($data) {
                return $data->createdBy->first_name;
            })
            ->addColumn('data_updated_by', function ($data) {
                return $data->updatedBy->first_name;
            })
            ->addColumn('action', function ($data) {
                return '<button class="btn btn-primary btn-xs" title="Edit" onclick="templateEdit('.$data->id.')">
                            <i class="fa fa-pencil"></i>
                        </button>
                        <button class="btn btn-danger btn-xs" title="Delete" onclick="templateDelete('.$data->id.')">
                            <i class="fa fa-trash"></i>
                        </button>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    /**
     * sms template insert
     */
    public function smsTemplateInsert(Request $request) {
        try {
            //gettings attributes
            $attributeNames = array(
                'name' => $request->name,
                'body' => $request->body

            );
            //validating the attributes
            $validator = Validator::make($attributeNames, [
                'name' => 'required',
                'body' => 'required'

            ]);

            if ($validator->fails()) {
                return response()->json([
                    'data' => $validator->getMessageBag()->toArray(),
                    'status' => "validation-error",
                    'message' => "Template creation failed"
                ]);
            }

            //Inserting data
            $response = SmsTemplate::create([
                'name' => $request->name,
                'body' => $request->body,
                'created_by' => auth()->user()->id,
                'updated_by' => auth()->user()->id
            ]);
            if ($response) {
                return response()->json([
                    'data' => $response,
                    'status' => true,
                    'message' => 'Template created succesfully'
                ]);
            }

            return response()->json([
                'data' => $response,
                'status' => false,
                'message' => 'Template creation failed! Please try again'
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
    public function getsmsTemplateForm(Request $request)
    {
        try{
            $smsTemplateData = SmsTemplate::where('id',$request->get('id'))->first();

            if($smsTemplateData){
                return response()->json([
                    'data' => view('admin.sms.smsTemplateEditForm')->with([
                        'smsTemplateData' => $smsTemplateData,
                    ])->render(),
                    'status' => true,
                    'message' => 'successfully'
                ]);
            }

            return response()->json([
                'data' => $smsTemplateData,
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
     * sms template is updated here
     */
    public function templateUpdate(Request $request)
    {
        try{

            //gettings attributes
            $templateId = $request->template_id;
            
            $attributeNames = array(
                'name' => $request->name,
                'body' => $request->body,

            );

            //validating the attributes
            $validator = Validator::make($attributeNames, [
                'name' => 'required',
                'body' => 'required',

            ]);

            if ($validator->fails()) {
                return response()->json([
                    'data' => $validator->getMessageBag()->toArray(),
                    'status' => "validation-error",
                    'message' => "Template update failed"
                ]);
            }

            $response = SmsTemplate::where('id',$templateId)->update([
                'name' => $request->name,
                'body' => $request->body,
                'updated_by' => auth()->user()->id
            ]);

            if($response){
                return response()->json([
                    'data' => $response,
                    'status' => true,
                    'message' => 'Template updated successfully'
                ]);
            }
            return response()->json([
                'data' => $response,
                'status' => false,
                'message' => 'Template update failed! Please try again'
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
     * Deletes sms template (Soft delete)
     */
    public function templateDelete(Request $request)
    {
        try{
            $response = SmsTemplate::where('id',$request->id)->update([
            'soft_delete' => SOFT_DELETE_YES
            ]);

            if($response){
                return response()->json([
                    'status' => true,
                    'message' => 'Template successfully removed',
                    'data' => $response
                ]);
            }

            return response()->json([
                'status' => false,
                'message' => 'Template removing failed! Please try again',
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
     * Returns blade for sms setting
     */
    public function smsSettingView()
    {
        $afterSaleSetting = SmsSetting::where(['type' => 'after_sale','soft_delete' => 0])->first();
        $afterApproveOrderSetting = SmsSetting::where(['type' => 'after_approve_order','soft_delete' => 0])->first();
        $afterFirstSaleSetting = SmsSetting::where(['type' => 'after_first_sale','soft_delete' => 0])->first();

        $data = [
            'afterSaleSetting' => $afterSaleSetting,
            'afterApproveOrderSetting' => $afterApproveOrderSetting,
            'afterFirstSaleSetting' => $afterFirstSaleSetting
        ];

        return view('admin.sms.smsSettingView',$data);
    }


    /**
     * Update or Insert sms settings
     */
    public function smsSettingUpsert(Request $request)
    {
        
        $validator = Validator::make($request->all(), [
            'type'      => 'required',
            'sms_body'  => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'data'      => $validator->getMessageBag()->toArray(),
                'status'    => 'validation-error',
                'message'   => null
            ]);
        }

        $status = 0;
        if($request->get('switch') == 1 || $request->get('switch') == "on" ){
            $status = 1;
        }

        $exist = SmsSetting::where('type',$request->type)->exists();
        
        if(!$exist) {
            $response = SmsSetting::create([
                'type'          => $request->type,
                'sms_body'      => $request->sms_body,
                'status'        => $status,
                'created_by'    => auth()->user()->id,
                'updated_by'    => auth()->user()->id
            ]);

        } else {
            $response = SmsSetting::where(['type' => $request->type,'soft_delete' => 0])->update([
                'sms_body'      => $request->sms_body,
                'status'        => $status,
                'updated_by'    => auth()->user()->id
            ]);
        }
        

        return response()->json([
            'data'      => $response,
            'status'    => true,
            'message'   => "Settings saved successfully"
        ]);
    }

}
