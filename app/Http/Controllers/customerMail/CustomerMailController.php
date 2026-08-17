<?php

namespace App\Http\Controllers\customerMail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\contact\ContactModel;
use App\Mail\ContactMail;
use Illuminate\Support\Facades\Mail;

class CustomerMailController extends Controller
{
     /**
     * @name allCategoryView
     * @role All category list view
     * @param 
     * @return view with compact array
     *
     */


     public function allCustomerMailView(){
        $allMail = ContactModel::where('soft_delete',0)->orderBy('id', 'desc')->get();

        $data =[
            'allMail' => $allMail
        ];

        return view('admin.customerMail.allMailView',$data);
     }



     /**
     * @name contactMailDeleteAjax
     * @role All mail view
     * @param 
     * @return view with compact array
     *
     */


     public function contactMailDeleteAjax(Request $request){
            $mail = ContactModel::findOrFail($request->id);
            $mail->soft_delete = 1;
            $mail->update();
            return response()->json('success');
     }




      /**
     * @name contactMailReplyAjax
     * @role mail replay
     * @param 
     * @return view with compact array
     *
     */

     public function contactMailReplyAjax(Request $request){

        $mailInfo = ContactModel::findOrFail($request->mail_id);
        
        $attributeNames = array(
            'mail_body'              => $request->mail_body,
        );



        //return dd($attributeNames);

        //validating the attributes
        $validator = Validator::make($attributeNames, [
            'mail_body'                  => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        }else {
            $mailInfo->is_replied = 1;
            $email  = $mailInfo->email;
            $name   = $mailInfo->name;
            $body   = $request->mail_body;
            Mail::to($email)->send(new ContactMail($name,$body));
            $mailInfo->update();
            return response()->json("Success");
        }
        
     }
    

}
