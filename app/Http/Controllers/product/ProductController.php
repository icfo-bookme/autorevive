<?php

namespace App\Http\Controllers\product;

use Illuminate\Http\Request;
use App\Product\ProductRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;


class ProductController extends Controller
{
    //Hello World
    public function requests()
    {
        $requests = ProductRequest::where('soft_delete', 0)->get();
        $data = [
            'requests' => $requests
        ];
        // return view('product.productRequests', compact('requests'));
        return view('product.productRequests', $data);
    }

    public function requestInsertAjax(Request $request)
    {

        $attributeNames = [
            'user_name'         => $request->user_name,
            'user_phone'        => $request->user_phone,
            'user_email'        => $request->user_email,
            'product_detail'    => $request->product_detail,
            'product_image'     => $request->file('product_image'),
        ];

        $validator = Validator::make($attributeNames, [
            'user_name'         => 'required|min:3|max:256',
            'user_phone'        => 'required',
            // 'user_email'        => 'required|email',
            'product_detail'    => 'required|max:1024',
        ]);

        if ($validator->fails()) {
            return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        } else {

            $thumbnail_path = '';

            if ($request->hasFile('product_image')) {
                $thumbnail                         = $request->file('product_image');
                $thumbnailName                     = $thumbnail->getClientOriginalName();
                $thumbnailExt                      = $thumbnail->getClientOriginalExtension();
                $thumbnailFileName                 = base64_encode($thumbnailName . rand(10, 1000000));
                $thumbnailFileName                 = $thumbnailFileName . "." . $thumbnailExt;

                $basePath = base_path() . '/public/';
                $targetRealPath = $basePath . 'img/requestedProduct/';
                if (!File::isDirectory($targetRealPath))
                    File::makeDirectory($targetRealPath, 0755, true, true);

                $thumbnail_path = 'img/requestedProduct/' . $thumbnailFileName;
                $thumbnail->move('img/requestedProduct/', $thumbnailFileName);
                $attributeNames['product_image']   = $thumbnail_path;
            }

            ProductRequest::create([
                'user_name'         => $request->user_name,
                'user_phone'        => $request->user_phone,
                'user_email'        => $request->user_email,
                'product_detail'    => $request->product_detail,
                'product_image'     => $thumbnail_path,
                'soft_delete'       => '0',
            ]);

            return response()->json('Success', 200);
        }
    }
}
