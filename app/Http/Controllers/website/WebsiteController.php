<?php

namespace App\Http\Controllers\website;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\WebsiteDetailsModel;


class WebsiteController extends Controller
{
    public function siteDetails()
    {
        $websiteDetails = WebsiteDetailsModel::all()->first();

        $data = [
            'websiteDetails' => $websiteDetails
        ];
// dd($websiteDetails);
        return view('shop.websitedetails', $data);
    }

    public function insertSiteDetails(Request $request)
    {
        $websiteDetails = WebsiteDetailsModel::find(1);

        if ($request->hasFile('banner_image_path')) {
            $bannerImage                         = $request->file('banner_image_path');
            $bannerImageName                     = $bannerImage->getClientOriginalName();
            $bannerImageExt                      = $bannerImage->getClientOriginalExtension();
            $bannerImageFileName                 = base64_encode($bannerImageName . rand(10, 1000000));
            $bannerImageFileName                 = $bannerImageFileName . "." . $bannerImageExt;
            $bannerImage_path                   = 'itemImage/' . $bannerImageFileName;
            $bannerImage->move('itemImage/', $bannerImageFileName);

            $websiteDetails->banner_image_path = $bannerImage_path;
        }

        if ($request->hasFile('logo_path')) {
            $logo_path                         = $request->file('logo_path');
            $logo_pathName                     = $logo_path->getClientOriginalName();
            $logo_pathExt                      = $logo_path->getClientOriginalExtension();
            $logo_pathFileName                 = base64_encode($logo_pathName . rand(10, 1000000));
            $logo_pathFileName                 = $logo_pathFileName . "." . $logo_pathExt;
            $logo_path_location                = 'itemImage/' . $logo_pathFileName;
            $logo_path->move('itemImage/', $logo_pathFileName);

            $websiteDetails->logo_path = $logo_path_location;
        }

        $request->validate([
            'banner_text' => 'required'
        ]);

        $websiteDetails->banner_text = $request->banner_text;

        $websiteDetails->save();

        return response()->json('Success', 200);
    }
}
