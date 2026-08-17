<?php

namespace App\Http\Controllers\purchase;

use App\highlights\HighlightsModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\item\ItemModel;
use Illuminate\Support\Facades\DB;
use App\vendor\VendorModel;
use App\purchase\PurchaseDetailsModel;
use App\purchase\PurchaseItemBarcode;
use App\purchase\PurchaseLog;
use App\purchase\PurchaseDetailLog;
use App\purchase\PurchaseModel;
use App\stock\StockModel;
use App\stock\StockCount;
use App\sales\SalesDetailsModel;
use Yajra\DataTables\DataTables;
use App\section\SectionModel;
use App\admin\UserRolesModel;
use App\admin\role\RolesDetailsModel;
use App\admin\module\ModuleDetailsModel;
use App\permissionRequest\PermissionRequest;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;
use PurchaseDetails;
use BarcodeBakery\Common\BCGFontFile;
use BarcodeBakery\Common\BCGColor;
use BarcodeBakery\Common\BCGDrawing;
use BarcodeBakery\Barcode\BCGcode128;
use Illuminate\Support\Facades\Mail;
use App\Mail\StockCountSheet;
use App\purchase\PurchaseDraft;
use PDF;

class PurchaseController extends Controller
{
    /**
     * @name purchaseSetupView
     * @role All purchase setup form view
     * @param
     * @return view with compact array
     *
     */

    public function purchaseSetupView()
    {
        $vendors = VendorModel::where('soft_delete', 0)->get();
        $items = ItemModel::where('soft_delete', 0)->where('is_outsourced', 0)->get();
        $data = [
            'vendors' => $vendors,
            'items' => $items
        ];

        return view('admin.purchase.purchaseSetupView', $data);
    }

    public function getPricesById(Request $request)
    {
        $itemInfo = ItemModel::findOrFail($request->id);
        // dd($itemInfo);
        return response()->json($itemInfo);
    }



    /**
     * @param $barcode
     * @param $itemName
     * @return void
     * @throws \BarcodeBakery\Common\BCGArgumentException
     * @throws \BarcodeBakery\Common\BCGDrawException
     * This function creates barcode image from barcode and save it to public/barcode folder
     */
    public function createBarcodeImage($barcode, $itemName)
    {
        $font = new BCGFontFile(public_path('arial/arial.ttf'), 18);
        $colorBlack = new BCGColor(0, 0, 0);
        $colorWhite = new BCGColor(255, 255, 255);

        // Barcode Part
        $code = new BCGcode128();
        $code->setScale(2);
        $code->setThickness(30);
        $code->setForegroundColor($colorBlack);
        $code->setBackgroundColor($colorWhite);
        $code->setFont($font);
        $code->setStart(null);
        $code->setTilde(true);
        $code->parse($barcode);

        $itemName = str_replace(' ', '', $itemName);
        $itemName = str_replace('/', '', $itemName);

        $image =  public_path('/barcode/' . $itemName . $barcode . '.png');
        // Drawing Part
        header('Content-Type: image/png');
        $drawing = new BCGDrawing($code, $colorWhite);
        $drawing->finish(BCGDrawing::IMG_FORMAT_PNG, $image);
        chmod($image, 0777);
    }

    /**
     * @param $itemId
     * @param $categoryId
     * @param $subcategoryId
     * @param $vendorId
     * @param $purchaseId
     * @param $regularPrice
     * @param $salesPrice
     * @param $itemName
     * @return string
     * This function creates barcode and save to public/barcode folder and path save to database
     */
    public function generateBarcode($itemDetails, $vendorId, $purchaseId, $regularPrice, $salesPrice, $purchaseDetailId)
    {
        $substrVendor = substr($vendorId, 0, 3);
        $substrVendor = sprintf("%03d", $substrVendor);

        $substrPurchaseDetailId = substr($purchaseDetailId, 0, 3);
        $substrPurchaseDetailId = sprintf("%03d", $substrPurchaseDetailId);

        $barcode = $substrVendor . $substrPurchaseDetailId . sprintf("%04d", rand(0, 9999));

        //Create barcode image
        $this->createBarcodeImage($barcode, $itemDetails['name']);

        $itemName = str_replace(' ', '', $itemDetails['name']);
        $itemName = str_replace('/', '', $itemName);

        $barcodeData = [
            'purchase_id' => $purchaseId,
            'purchase_detail_id' => $purchaseDetailId,
            'item_id' => $itemDetails['id'],
            'barcode' => $barcode,
            'regular_price' => $regularPrice,
            'sales_price' => $salesPrice,
            'barcode_image' => 'barcode/' . $itemName . $barcode . '.png'
        ];
        PurchaseItemBarcode::create($barcodeData);

        return $barcode;
    }

    public function purchaseInserAjax(Request $request)
    {
        $userName = Auth::user()->first_name;
        $defaultStatus = 0;

        //gettings attributes
        $attributeNames = array(
            'uom'               => $request->uom,
            'mrp'               => $request->mrp,
            'item_id'           => $request->item_id,
            'quantity'          => $request->quantity,
            'cost_price'        => $request->cost_price,
            'due_amount'        => $request->due_amount,
            'paid_amount'       => $request->paid_amount,
            'purchase_date'     => $request->purchase_date,
            'sales_price'       => $request->sales_price,
            'total_amount'      => $request->total_amount,
            'is_published'      => $request->is_published,
            'vendor_id'         => $request->vendor_id,
            'invoice_number'    => $request->invoice_number,
            'wholesale_price'   => $request->wholesale_price,
            'regular_price'     => $request->regular_price,
            'input_img'         => $request->input_img,
            // 'expired_date'   => $request->expired_date,
        );

        //validating the attributes
        $validator = Validator::make($attributeNames, [
            'cost_price.*'      => 'required',
            'due_amount'        => 'required',
            'invoice_number'    => 'required',
            'item_id.*'         => 'required',
            'mrp.*'             => 'required',
            'quantity.*'        => 'required',
            'uom.*'             => 'required',
            'paid_amount'       => 'required',
            'purchase_date'     => 'required',
            'sales_price.*'     => 'required',
            'wholesale_price.*' => 'required',
            'total_amount'      => 'required',
            'vendor_id'         => 'required',
            'regular_price.*'   => 'required|gte:sales_price.*',
            'input_img'         => 'required|max:1024'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'data' => $validator->getMessageBag()->toArray(),
                'status' => "validation-error",
                'message' => null
            ]);
        } else {

            DB::beginTransaction();
            try {

                if ($request->hasFile('input_img')) {
                    $file = $request->file('input_img');
                    $name = $file->getClientOriginalName();
                    $EXT = $file->getClientOriginalExtension();
                    $imageFileName = base64_encode($name . rand(10, 1000000));
                    $imageFileName = $imageFileName . "." . $EXT;

                    $basePath = base_path() . '/public/';
                    $targetRealPath = $basePath . 'img/challan/';
                    if (!File::isDirectory($targetRealPath))
                        File::makeDirectory($targetRealPath, 0755, true, true);

                    $attachment_path = 'img/challan/' . $imageFileName;

                    $file->move('img/challan/', $imageFileName);
                } else {

                    return response()->json([
                        'data' => null,
                        'status' => false,
                        'message' => "Please upload image"
                    ]);
                }

                $purchase = new PurchaseModel();
                $purchase->vendor_id = $request->vendor_id;
                $purchase->invoice_number = $request->invoice_number;
                $purchase->purchase_date = $request->purchase_date;
                $purchase->total_amount = $request->total_amount;
                $purchase->paid_amount = $request->paid_amount;
                $purchase->due_amount = $request->due_amount;
                $purchase->challan_img = $attachment_path;
                $purchase->remarks = $request->remarks;
                $purchase->completed_at = now()->toDateTimeString();
                $purchase->created_by = $userName;
                $purchase->updated_by = $userName;
                $purchase->soft_delete = $defaultStatus;
                $purchase->save();

                // $barcodeArray = [];

                // $isSalesPriceShowInBarcode = 0;
                // if ($request->get('sales_price_show_in_barcode') != null) {
                //     if ($request->get('sales_price_show_in_barcode') == 1) {
                //         $isSalesPriceShowInBarcode = 1;
                //     }
                // }

                $barcodeArrayToDownload = [];
                for ($i = 0; $i < count($request->item_id); $i++) {

                    $itemQuery = ItemModel::where('id', $request->item_id[$i]);

                    //price update in item table
                    $itemQuery->update([
                        'regular_price' => $request->regular_price[$i],
                        'sales_price'   => $request->sales_price[$i],
                        'cost_price'    => $request->cost_price[$i],
                        'is_published'  => $request->is_published[$i]
                    ]);

                    $itemDetails = $itemQuery->select('barcode', 'id', 'name', 'category_id', 'sub_category_id', 'regular_price')->first();


                    $purchaseDetails = new PurchaseDetailsModel();
                    $purchaseDetails->purchase_id = $purchase->id;
                    $purchaseDetails->item_id = $request->item_id[$i];
                    $purchaseDetails->cost_price = $request->cost_price[$i];
                    $purchaseDetails->sales_price = $request->sales_price[$i];
                    $purchaseDetails->wholesale_price = $request->wholesale_price[$i];
                    $purchaseDetails->mrp = $request->mrp[$i];
                    $purchaseDetails->quantity = $request->quantity[$i];
                    $purchaseDetails->uom = $request->uom[$i];
                    $purchaseDetails->created_by = $userName;
                    $purchaseDetails->updated_by = $userName;
                    $purchaseDetails->soft_delete = $defaultStatus;
                    $purchaseDetails->barcode = "test";
                    $purchaseDetails->is_barcode = PURCHASE_DETAIL__BARCODE_GENERATED;
                    $purchaseDetails->save();

                    //generate barcodes here
                    //dd("Yes");
                    $barcode = $this->generateBarcode($itemDetails, $request->vendor_id, $purchase->id, $request->regular_price[$i], $request->sales_price[$i], $purchaseDetails->id);
                    $itemNameToStore = str_replace(' ', '', $itemDetails['name']);
                    $itemNameToStore = str_replace('/', '', $itemNameToStore);
                    array_push($barcodeArrayToDownload, asset('barcode/' . $itemNameToStore . $barcode . '.png'));

                    // array_push($barcodeArray, [
                    //     'name' => $itemDetails['name'],
                    //     'quantity' => $request->quantity[$i],
                    //     'barcode' => $barcode,
                    //     'sales_price' => $request->sales_price[$i],
                    //     'is_sales_price_show' => $isSalesPriceShowInBarcode
                    // //'number_of_copy' => $request->print_barcode[$i]
                    // ]);
                    $purchaseItemBarcodeQuery = PurchaseItemBarcode::where('barcode', $barcode)->first();

                    $stockQuery = StockModel::where(['barcode' => $barcode, 'cost_price' => $request->cost_price[$i], 'soft_delete' => 0]);
                    if ($stockQuery->exists()) {
                        $stock = $stockQuery->first();
                        $stock->quantity = $request->quantity[$i] + $stock->quantity;
                        $stock->uom = $request->uom[$i];
                        $stock->updated_by = $userName;
                        $stock->update();
                    } else {
                        $stock = new StockModel();
                        $stock->item_barcodes_id = $purchaseItemBarcodeQuery->id;
                        $stock->barcode     = $purchaseItemBarcodeQuery->barcode;
                        $stock->item_id     = $request->item_id[$i];
                        $stock->quantity    = $request->quantity[$i];
                        $stock->uom         = $request->uom[$i];
                        $stock->cost_price  = $request->cost_price[$i];
                        $stock->created_by  = $userName;
                        $stock->updated_by  = $userName;
                        $stock->save();
                    }
                }

                //INSERT INTO highlights TABLE//
                if ($request->highlights !== null) {
                    $Info = new HighlightsModel();
                    $Info->type_id = $purchase->id;
                    $Info->type = "PURCHASE";
                    $Info->summary = "This Purchase is highlighted";
                    $Info->created_by = $userName;
                    $Info->save();
                }

                //IF DRAFTED PURCHASE
                if (isset($request->draft_id)) {
                    PurchaseDraft::where(['id' => $request->draft_id])->update([
                        'purchase_id' => $purchase->id,
                        'is_purchased' => 1
                    ]);
                }

                DB::commit();
                return response()->json([
                    'data' => $barcodeArrayToDownload,
                    'status' => true,
                    'message' => 'Successful'
                ]);
            } catch (\Exception $exception) {
                DB::rollback();

                return response()->json([
                    'data' => $exception->getMessage(),
                    'status' => false,
                    'message' => "Something went wrong!"
                ]);
            }
        }
    }

    // public function draftedPurchaseInserAjax(Request $request)
    // {
    //     $userName = Auth::user()->first_name;
    //     $defaultStatus = 0;

    //     //gettings attributes
    //     $attributeNames = array(
    //         'uom'               => $request->uom,
    //         'mrp'               => $request->mrp,
    //         'item_id'           => $request->item_id,
    //         'quantity'          => $request->quantity,
    //         'cost_price'        => $request->cost_price,
    //         'due_amount'        => $request->due_amount,
    //         'paid_amount'       => $request->paid_amount,
    //         'purchase_date'     => $request->purchase_date,
    //         'sales_price'       => $request->sales_price,
    //         'total_amount'      => $request->total_amount,
    //         'is_published'      => $request->is_published,
    //         'vendor_id'         => $request->vendor_id,
    //         'invoice_number'    => $request->invoice_number,
    //         'wholesale_price'   => $request->wholesale_price,
    //         'regular_price'     => $request->regular_price
    //     );

    //     //validating the attributes
    //     $validator = Validator::make($attributeNames, [
    //         'cost_price.*'      => 'required',
    //         'due_amount'        => 'required',
    //         'invoice_number'    => 'required',
    //         'item_id.*'         => 'required',
    //         'mrp.*'             => 'required',
    //         'quantity.*'        => 'required',
    //         'uom.*'             => 'required',
    //         'paid_amount'       => 'required',
    //         'purchase_date'     => 'required',
    //         'sales_price.*'     => 'required',
    //         'wholesale_price.*' => 'required',
    //         'total_amount'      => 'required',
    //         'vendor_id'         => 'required',
    //         'regular_price.*'   => 'required|gte:sales_price.*'
    //     ]);

    //     if ($validator->fails()) {
    //         return response()->json([
    //             'data' => $validator->getMessageBag()->toArray(),
    //             'status' => "validation-error",
    //             'message' => null
    //         ]);
    //     } else {

    //         DB::beginTransaction();
    //         try {
    //             if ($request->hasFile('input_img')) {
    //                 $file = $request->file('input_img');
    //                 $name = $file->getClientOriginalName();
    //                 $EXT = $file->getClientOriginalExtension();
    //                 $imageFileName = base64_encode($name . rand(10, 1000000));
    //                 $imageFileName = $imageFileName . "." . $EXT;

    //                 $basePath = base_path() . '/public/';
    //                 $targetRealPath = $basePath . 'img/challan/';
    //                 if (!File::isDirectory($targetRealPath))
    //                     File::makeDirectory($targetRealPath, 0755, true, true);

    //                 $attachment_path = 'img/challan/' . $imageFileName;
    //                 $file->move('img/challan/', $imageFileName);
    //             }

    //             $purchase = new PurchaseModel();
    //             $purchase->vendor_id      = $request->vendor_id;
    //             $purchase->invoice_number = $request->invoice_number;
    //             $purchase->purchase_date  = $request->purchase_date;
    //             $purchase->total_amount   = $request->total_amount;
    //             $purchase->paid_amount    = $request->paid_amount;
    //             $purchase->due_amount     = $request->due_amount;
    //             $purchase->challan_img    = $request->hasFile('input_img')? $attachment_path:null;
    //             $purchase->remarks        = $request->remarks;
    //             $purchase->is_draft       = 1;
    //             $purchase->created_by     = $userName;
    //             $purchase->updated_by     = $userName;
    //             $purchase->soft_delete    = $defaultStatus;
    //             $purchase->save();

    //             for ($i = 0; $i < count($request->item_id); $i++) {
    //                 $itemQuery = ItemModel::where('id', $request->item_id[$i]);

    //                 //price update in item table
    //                 $itemQuery->update([
    //                     'regular_price' => $request->regular_price[$i],
    //                     'sales_price'   => $request->sales_price[$i],
    //                     'cost_price'    => $request->cost_price[$i],
    //                     'is_published'  => $request->is_published[$i]
    //                 ]);

    //                 $purchaseDetails = new PurchaseDetailsModel();
    //                 $purchaseDetails->purchase_id     = $purchase->id;
    //                 $purchaseDetails->item_id         = $request->item_id[$i];
    //                 $purchaseDetails->cost_price      = $request->cost_price[$i];
    //                 $purchaseDetails->sales_price     = $request->sales_price[$i];
    //                 $purchaseDetails->wholesale_price = $request->wholesale_price[$i];
    //                 $purchaseDetails->mrp             = $request->mrp[$i];
    //                 $purchaseDetails->quantity        = $request->quantity[$i];
    //                 $purchaseDetails->uom             = $request->uom[$i];
    //                 $purchaseDetails->created_by      = $userName;
    //                 $purchaseDetails->updated_by      = $userName;
    //                 $purchaseDetails->soft_delete     = $defaultStatus;
    //                 $purchaseDetails->barcode         = "test";
    //                 $purchaseDetails->is_barcode      = PURCHASE_DETAIL__BARCODE_NOT_GENERATED;
    //                 $purchaseDetails->save();

    //             }

    //             //INSERT INTO highlights TABLE//
    //             if ($request->highlights !== null) {
    //                 $Info = new HighlightsModel();
    //                 $Info->type_id = $purchase->id;
    //                 $Info->type = "PURCHASE";
    //                 $Info->summary = "This Purchase is highlighted";
    //                 $Info->created_by = $userName;
    //                 $Info->save();
    //             }

    //             DB::commit();
    //             return response()->json([
    //                 'status' => true,
    //                 'message' => 'Successful'
    //             ]);

    //         } catch (\Exception $exception) {
    //             DB::rollback();

    //             return response()->json([
    //                 'data' => $exception->getMessage(),
    //                 'status' => false,
    //                 'message' => "Something went wrong!"
    //             ]);
    //         }
    //     }
    // }

    public function draftInsert(Request $request)
    {

        try {

            $attributeNames = array(
                'amount'    => $request->amount,
                'note'      => $request->note
            );

            //validating the attributes
            $validator = Validator::make($attributeNames, [
                'amount'    => 'required'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'data'      => $validator->getMessageBag()->toArray(),
                    'status'    => "validation-error",
                    'message'   => "Fund creation failed!"
                ]);
            }

            //Inserting data
            $response = PurchaseDraft::create([
                'amount'            => $request->amount,
                'note'              => $request->note,
                'created_by'        => auth()->user()->id,
                'updated_by'        => auth()->user()->id,
                'soft_delete'       => SOFT_DELETE_NO
            ]);

            if ($response) {
                return response()->json([
                    'data'      => $response,
                    'status'    => true,
                    'message'   => 'Draft saved succesfully'
                ]);
            }

            return response()->json([
                'data'      => $response,
                'status'    => false,
                'message'   => 'Draft Saving failed! Please try again'
            ]);
        } catch (\Exception $exception) {
            return response()->json([
                'data'      => $exception->getMessage(),
                'status'    => false,
                'message'   => 'Something went wrong! Please try again'
            ]);
        }
    }

    public function getDraftEditForm(Request $request)
    {
        try {
            $draftData   = PurchaseDraft::where('id', $request->get('id'))->first();
            if ($draftData) {
                return response()->json([
                    'data' => view('admin.purchase.draftEditForm')->with([
                        'draftData'          => $draftData
                    ])->render(),
                    'status'    => true,
                    'message'   => 'successful'
                ]);
            }

            return response()->json([
                'data'      => $draftData,
                'status'    => false,
                'message'   => 'Form fetch failed! Please try again'
            ]);
        } catch (\Exception $exception) {
            return response()->json([
                'data'      => $exception->getMessage(),
                'status'    => false,
                'message'   => 'Something went wrong! Please try again'
            ]);
        }
    }

    public function draftUpdate(Request $request)
    {
        try {

            $attributeNames = array(
                'amount'    => $request->amount,
                'note'      => $request->note
            );

            //validating the attributes
            $validator = Validator::make($attributeNames, [
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
            $response = PurchaseDraft::where('id', $request->draft_id)->update([
                'amount'            => $request->amount,
                'note'              => $request->note,
                'updated_by'        => auth()->user()->id
            ]);

            if ($response) {
                return response()->json([
                    'data'      => $response,
                    'status'    => true,
                    'message'   => 'Draft updated succesfully'
                ]);
            }

            return response()->json([
                'data'      => $response,
                'status'    => false,
                'message'   => 'Draft updating failed! Please try again'
            ]);
        } catch (\Exception $exception) {
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
    public function draftDelete(Request $request)
    {
        try {
            $response = PurchaseDraft::where('id', $request->id)->update([
                'soft_delete' => SOFT_DELETE_YES
            ]);

            if ($response) {
                return response()->json([
                    'status'    => true,
                    'message'   => 'Draft successfully deleted',
                    'data'      => $response
                ]);
            }

            return response()->json([
                'status'    => false,
                'message'   => 'Draft deleting failed! Please try again',
                'data'      => null
            ]);
        } catch (\Exception $exception) {

            return response()->json([
                'data'      => $exception->getMessage(),
                'status'    => false,
                'message'   => 'Something went wrong! Please try again'
            ]);
        }
    }

    public function draftedPurchaseSetupView($draftId)
    {
        $draft      = PurchaseDraft::where(['id' => $draftId, 'soft_delete' => 0])->first();
        $vendors    = VendorModel::where('soft_delete', 0)->get();
        $items      = ItemModel::where('soft_delete', 0)->where('is_outsourced', 0)->get();

        $data = [
            'vendors'   => $vendors,
            'items'     => $items,
            'draft'     => $draft
        ];

        return view('admin.purchase.draftedPurchaseSetupView', $data);
    }




    public function unusedChallanRemove()
    {
        try {
            $files = File::files(public_path() . "/" . "img/challan");
            $t = 0;
            $count = 0;
            foreach ($files as $file) {
                $basename = pathinfo($file)['basename'];
                $b_name = "img/challan/" . $basename;
                $challan_img = PurchaseModel::where('challan_img', $b_name)->first();
                if ($challan_img !== null) {
                    $count++;
                } else {
                    unlink($b_name);
                    $t++;
                }
            }

            return json_encode([
                'status' => true,
                'message' => "successfull",
                'data' => [
                    'challan_img_exists' => $count,
                    'challan_img_deleted' => $t
                ]
            ]);
        } catch (\Exception $exception) {
            return json_encode([
                'status' => false,
                'message' => $exception->getMessage()
            ]);
        }
    }


    /**
     * @name allPurchaseView
     * @role All purchase setup form view
     * @param
     * @return view with compact array
     *
     */

    public function allPurchaseView()
    {
        $purchases = PurchaseModel::where(['soft_delete' => 0, 'is_draft' => 0])->orderBy('id', 'desc')->get();

        $data = [
            'purchases' => $purchases
        ];

        return view('admin.purchase.allPurchaseView', $data);
    }

    /**
     * @name allDraftedPurchaseView
     */

    public function allDraftedPurchaseView()
    {
        //  $purchases = PurchaseModel::where(['soft_delete' => 0, 'is_draft' => 1])->orderBy('id', 'desc')->get();
        $purchase_drafts = PurchaseDraft::where(['soft_delete' => 0, 'is_purchased' => 0])->orderBy('id', 'asc')->get();
        $data = [
            'purchase_drafts' => $purchase_drafts
        ];

        return view('admin.purchase.allDraftedPurchaseView', $data);
    }

    /**
     * @name allPurchaseView
     * @role All purchase setup form view
     * @param
     * @return view with compact array
     *
     */

    public function abnormalPurchaseView()
    {
        $abnormalPurchases = PurchaseModel::whereColumn('paid_amount', '!=', 'total_amount')->where('soft_delete', 0)->get();
        $data = [
            'abnormalPurchases' => $abnormalPurchases
        ];

        return view('admin.purchase.abnormalPurchaseView', $data);
    }



    /**
     * @name all Single Purchase View
     * @role All purchase setup form view
     * @param
     * @return view with compact array
     *
     */

    public function allSinglePurchaseView()
    {
        $master = PurchaseItemBarcode::where('soft_delete', 0)->with(['item', 'purchase_details']);
        $singlePurchases = $master->where(function ($subQuery) {
            $subQuery->whereHas('purchase_details', function ($query) {
                $query->where(['soft_delete' => 0, 'is_barcode' => 1]);
            });
        })->get();

        // foreach ($singlePurchases as $singlePurchase) {
        //    dd("inside", $singlePurchase->barcode, $singlePurchase->item->name, $singlePurchase->purchase_details->wholesale_price, $singlePurchase->purchase_details->purchase->vendor->name, $singlePurchase->stock->quantity );
        // }
        // dd($singlePurchases);

        $singlePurchases = [
            'singlePurchases' => $singlePurchases
        ];

        return view('admin.purchase.allSinglePurchaseView', $singlePurchases);
    }

    /**
     * Returns purchase view logs
     */
    public function purchaseLogsView()
    {
        return view('admin.purchase.purchaseLogsView');
    }

    /**
     * Returns all purchase logs data in datatable
     */
    public function listPurchaseLogs(Request $request)
    {
        $purchaseLogsData = PurchaseLog::with(['vendor'])->orderBy('purchase_logs.updated_at', 'desc');

        return Datatables::of($purchaseLogsData)
            ->addColumn('data_vendor_name', function ($purchaseLog) {
                return $purchaseLog->vendor->name;
            })
            ->addColumn('action', function ($purchaseLog) {
                return '<a target="_blank" href="' . route('purchase-logs.view-details', $purchaseLog->id) . '"><button class="btn btn-success btn-xs">
                                        <i class="fa fa-info-circle"></i> Show Details
                                    </button></a>';
                // <button class="btn btn-info btn-xs" title="Present Details" onclick="window.open(`'.url('purchaseInfoView/'.$purchaseLog->purchase_id).'`)"></i>Present</button>';
            })
            ->rawColumns(['action', 'data_vendor_name'])
            ->make(true);
    }

    /**
     * Purchase log details are displayed
     */
    public function viewPurchaseLogsDetails($purchaseLogId)
    {
        $vendors = VendorModel::where('soft_delete', 0)->get();
        $items = ItemModel::where('soft_delete', 0)->get();
        $purchaseLog = PurchaseLog::where('id', $purchaseLogId)->first();
        $purchaseLogDetails = PurchaseDetailLog::where('purchase_log_id', $purchaseLogId)->where('soft_delete', 0)->get();


        $purchase = PurchaseModel::findOrFail($purchaseLog->purchase_id);
        $purchaseDetails = PurchaseDetailsModel::where('purchase_id', $purchaseLog->purchase_id)->where('soft_delete', 0)->get();

        // dd($purchaseDetails);
        $data = [
            'vendors' => $vendors,
            'items' => $items,
            'purchaseLog' => $purchaseLog,
            'purchaseLogDetails' => $purchaseLogDetails,
            'purchase' => $purchase,
            'purchaseDetails' => $purchaseDetails
        ];

        return view('admin.purchase.purchaseLogDetails', $data);
    }


    /**
     * @name purchaseInfoView
     * @role purchase Info view
     * @param
     * @return view with compact array
     *
     */

    public function purchaseInfoView($id)
    {
        $purchase = PurchaseModel::findOrFail($id);
        $purchaseDetails = PurchaseDetailsModel::where('purchase_id', $id)->where('soft_delete', 0)->get();
        $data = [
            'purchase' => $purchase,
            'purchaseDetails' => $purchaseDetails
        ];

        return view('admin.purchase.purchaseInfoView', $data);
    }


    /**
     * @name purchaseInfoEdit
     * @role All purchase edit form view
     * @param
     * @return view with compact array
     *
     */

    public function purchaseInfoEdit($id)
    {
        $vendors    = VendorModel::where('soft_delete', 0)->get();
        $items      = ItemModel::where('soft_delete', 0)->where('is_outsourced', 0)->get();
        $purchase   = PurchaseModel::findOrFail($id);
        $purchaseDetails = PurchaseDetailsModel::where('purchase_id', $id)->where('soft_delete', 0)->with('purchase_item_barcode')->get();

        $data = [
            'vendors'   => $vendors,
            'items'     => $items,
            'purchase'  => $purchase,
            'purchaseDetails' => $purchaseDetails
        ];

        return view('admin.purchase.purchaseInfoEdit', $data);
    }


    /**
     * @name draftedPurchaseInfoEdit
     * @role Drafted purchase edit form view
     * @param
     *
     */

    public function draftedPurchaseInfoEdit($id)
    {
        $vendors    = VendorModel::where('soft_delete', 0)->get();
        $items      = ItemModel::where('soft_delete', 0)->where('is_outsourced', 0)->get();
        $purchase   = PurchaseModel::findOrFail($id);
        $purchaseDetails = PurchaseDetailsModel::where('purchase_id', $id)->where('soft_delete', 0)->with('purchase_item_barcode')->get();

        $data = [
            'vendors'   => $vendors,
            'items'     => $items,
            'purchase'  => $purchase,
            'purchaseDetails' => $purchaseDetails
        ];

        return view('admin.purchase.draftedPurchaseInfoEdit', $data);
    }


    /**
     * @param $purchaseId
     * @param $itemId
     * @return void
     * Delete
     */
    public function deleteBarcodeForPurchase($purchaseDetailId)
    {
        //Unlink image
        $barcodeData = PurchaseItemBarcode::where([
            'purchase_detail_id' => $purchaseDetailId
        ])->select('barcode_image')->first();

        if (is_file(public_path() . "/" . $barcodeData['barcode_image'])) {
            unlink($barcodeData['barcode_image']);
        }

        //Make data soft deleted
        PurchaseItemBarcode::where([
            'purchase_detail_id' => $purchaseDetailId
        ])->update([
            'soft_delete' => PURCHASE_ITEM_BARCODE__SOFT_DELETE_YES
        ]);
    }

    /**
     * @name purchaseUpdateAjax
     * @role All purchase update form view
     * @param
     * @return view with compact array
     *
     */

    public function purchaseUpdateAjax(Request $request)
    {

        // dd($request->all());
        if (!$request->item_id) {
            // return response()->json("Sorry! Cannot delete all the previously purchased items.");
            return response()->json([
                'data' => null,
                'status' => false,
                'message' => "Sorry! Cannot delete all the previously purchased items."
            ]);
        } else {
            foreach ($request->item_id as $item_id) {
                if ($item_id === null) {
                    return response()->json([
                        'data' => null,
                        'status' => false,
                        'message' => "Select Item Please!!"
                    ]);
                }
            }

            for ($i = 0; $i < count($request->item_id); $i++) {
                //stock update and purchase_details table update
                $existingPurchaseDetails = PurchaseDetailsModel::where(['purchase_id' => $request->purchase_id, 'item_id' => $request->item_id[$i], 'soft_delete' => 0])->with('item')->first();
                if ($existingPurchaseDetails) {
                    $item_barcodes_id = PurchaseItemBarcode::where(['purchase_detail_id' => $existingPurchaseDetails->id])->first();
                    $stock = StockModel::where(['item_barcodes_id' => $item_barcodes_id->id, 'item_id' => $request->item_id[$i], 'soft_delete' => 0])->first();
                    $stock_quantity = $stock->quantity;
                    $updated_quantity = $request->quantity[$i];
                    $sold = $existingPurchaseDetails->quantity - $stock_quantity;

                    $item_name = $existingPurchaseDetails->item->name;
                    if ($updated_quantity < $sold) {
                        return response()->json([
                            'data' => null,
                            'status' => false,
                            'message' => "Check sold quantity of $item_name!"
                        ]);
                    }
                }
            }

            if (isset($request->deletedItems)) {
                $purchaseDetailsIdToDelete = array_map('intval', explode(',', $request->deletedItems));
                foreach ($purchaseDetailsIdToDelete as $purchaseDetailsId) {

                    $item_barcodes_table = PurchaseItemBarcode::where(['purchase_detail_id' => $purchaseDetailsId])->first();
                    $sold = SalesDetailsModel::where('barcode_id', $item_barcodes_table->id)->exists();
                    if ($sold) {
                        return response()->json([
                            'data' => null,
                            'status' => false,
                            'message' => "Sorry! A quantity of item has already been sold. Please EDIT QUANTITY above sold unit!"
                        ]);
                    }
                }
            }

            $userName = Auth::user()->first_name;
            $defaultStatus = 0;

            //gettings attributes
            $attributeNames = array(
                'item_id'           => $request->item_id,
                'vendor_id'         => $request->vendor_id,
                'invoice_number'    => $request->invoice_number,
                'purchase_date'     => $request->purchase_date,
                'cost_price'        => $request->cost_price,
                'regular_price'     => $request->regular_price,
                'sales_price'       => $request->sales_price,
                'wholesale_price'   => $request->wholesale_price,
                'mrp'               => $request->mrp,
                'due_amount'        => $request->due_amount,
                'paid_amount'       => $request->paid_amount,
                'total_amount'      => $request->total_amount,
                // 'expired_date'   => $request->expired_date,
            );

            //validating the attributes
            $validator = Validator::make($attributeNames, [
                'item_id.*'             => 'required',
                'vendor_id'             => 'required',
                'invoice_number'        => 'required',
                'purchase_date'         => 'required',
                'cost_price.*'          => 'required',
                'regular_price.*'       => 'required',
                'sales_price.*'         => 'required',
                'wholesale_price.*'     => 'required',
                'mrp.*'                 => 'required',
                'paid_amount'           => 'required',
                'due_amount'            => 'required',
                'total_amount'          => 'required',
                'regular_price.*'       => 'gte:sales_price.*',
                // 'expired_date.*'     =>  'required',
            ]);

            if ($validator->fails()) {
                return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
            } else {
                DB::beginTransaction();
                try {


                    //Create logs of purchase table
                    $purchaseData = PurchaseModel::where('id', $request->purchase_id)->first();
                    $data = [
                        'purchase_id'       => $purchaseData['id'],
                        'vendor_id'         => $purchaseData['vendor_id'],
                        'invoice_number'    => $purchaseData['invoice_number'],
                        'purchase_date'     => $purchaseData['purchase_date'],
                        'total_amount'      => $purchaseData['total_amount'],
                        'paid_amount'       => $purchaseData['paid_amount'],
                        'due_amount'        => $purchaseData['due_amount'],
                        'challan_img'       => $purchaseData['challan_img'],
                        'remarks'           => $purchaseData['remarks'],
                        'is_draft'          => $purchaseData['is_draft'],
                        'completed_at'      => $purchaseData['completed_at'],
                        'created_by'        => $purchaseData['created_by'],
                        'updated_by'        => $purchaseData['updated_by'],
                        'soft_delete'       => $purchaseData['soft_delete'],
                    ];
                    $purchaseLogResult = PurchaseLog::create($data);

                    //Create logs of purchase details table
                    $purchaseDetailsData = PurchaseDetailsModel::where('purchase_id', $request->purchase_id)->get();
                    foreach ($purchaseDetailsData as $data) {
                        $data = [
                            'purchase_log_id'       => $purchaseLogResult['id'],
                            'purchase_detail_id'    => $data['id'],
                            'purchase_id'           => $data['purchase_id'],
                            'item_id'               => $data['item_id'],
                            'cost_price'            => $data['cost_price'],
                            'sales_price'           => $data['sales_price'],
                            'wholesale_price'       => $data['wholesale_price'],
                            'mrp'                   => $data['mrp'],
                            'quantity'              => $data['quantity'],
                            'uom'                   => $data['uom'],
                            'created_by'            => $data['created_by'],
                            'updated_by'            => $data['updated_by'],
                            'soft_delete'           => $data['soft_delete'],
                            // 'expired_date' => $data['expired_date'],
                        ];
                        PurchaseDetailLog::create($data);
                    }

                    //Update purchase table
                    $purchase = PurchaseModel::findOrFail($request->purchase_id);
                    $purchase->vendor_id        = $request->vendor_id;
                    $purchase->total_amount     = $request->total_amount;
                    $purchase->paid_amount      = $request->paid_amount;
                    $purchase->due_amount       = $request->due_amount;
                    $purchase->remarks          = $request->remarks;
                    $purchase->updated_by       = $userName;
                    $purchase->update();

                    //deleting removed purchases from purchase_details table
                    if (isset($request->deletedItems)) {
                        $purchaseDetailsIdToDelete = array_map('intval', explode(',', $request->deletedItems));

                        foreach ($purchaseDetailsIdToDelete as $purchaseDetailsId) {
                            //deleting from purchase_details table
                            $purchaseDetailsData = PurchaseDetailsModel::where('id', $purchaseDetailsId)->first();
                            $purchaseDetailsData->soft_delete = 1;
                            $purchaseDetailsData->update();

                            //Deleting from purchase_item_barocodes table
                            $this->deleteBarcodeForPurchase($purchaseDetailsId);

                            //stock decrease or delete
                            $item_barcodes_table = PurchaseItemBarcode::where(['purchase_detail_id' => $purchaseDetailsId])->first();
                            $stock = StockModel::where(['item_barcodes_id' => $item_barcodes_table->id, 'soft_delete' => 0])->update(['soft_delete' => 1]);
                        }
                    }

                    //update purchase_details,item and stock table
                    $barcodeArrayToDownload = [];
                    for ($i = 0; $i < count($request->item_id); $i++) {

                        //stock update and purchase_details table update
                        $existingPurchaseDetails = PurchaseDetailsModel::where(['purchase_id' => $request->purchase_id, 'item_id' => $request->item_id[$i], 'soft_delete' => 0])->first();
                        if ($existingPurchaseDetails) {
                            $item_barcodes_id = PurchaseItemBarcode::where(['purchase_detail_id' => $existingPurchaseDetails->id])->first();
                            $stock = StockModel::where(['item_barcodes_id' => $item_barcodes_id->id, 'item_id' => $request->item_id[$i], 'soft_delete' => 0])->first();

                            if ($stock) {
                                $previous_quantity   = $existingPurchaseDetails->quantity;
                                $new_quantity        = $request->quantity[$i];
                                $quantity_difference = $previous_quantity - $new_quantity;

                                $present_stock = $stock->quantity;
                                $updated_stock = $present_stock - $quantity_difference;

                                $stock->quantity    = $updated_stock;
                                $stock->uom         = $request->uom[$i];
                                $stock->cost_price  = $request->cost_price[$i];
                                $stock->updated_by  = $userName;
                                $stock->update();
                            }
                            //update purchase_details table
                            $existingPurchaseDetails->cost_price        = $request->cost_price[$i];
                            $existingPurchaseDetails->sales_price       = $request->sales_price[$i];
                            $existingPurchaseDetails->wholesale_price   = $request->wholesale_price[$i];
                            $existingPurchaseDetails->mrp               = $request->mrp[$i];
                            $existingPurchaseDetails->quantity          = $request->quantity[$i];
                            $existingPurchaseDetails->uom               = $request->uom[$i];
                            $existingPurchaseDetails->updated_by        = $userName;
                            $existingPurchaseDetails->update();

                            //Update purchase item barcodes table
                            PurchaseItemBarcode::where([
                                'purchase_id' => $request->purchase_id,
                                'item_id' => $request->item_id[$i]
                            ])->update([
                                'regular_price' => $request->regular_price[$i],
                                'sales_price' => $request->sales_price[$i]
                            ]);
                        } else {

                            //purchase_details table insert
                            $purchaseDetails = new PurchaseDetailsModel();
                            $purchaseDetails->purchase_id       = $purchase->id;
                            $purchaseDetails->item_id           = $request->item_id[$i];
                            $purchaseDetails->cost_price        = $request->cost_price[$i];
                            $purchaseDetails->sales_price       = $request->sales_price[$i];
                            $purchaseDetails->wholesale_price   = $request->wholesale_price[$i];
                            $purchaseDetails->mrp               = $request->mrp[$i];
                            $purchaseDetails->quantity          = $request->quantity[$i];
                            $purchaseDetails->uom               = $request->uom[$i];
                            $purchaseDetails->created_by        = $userName;
                            $purchaseDetails->updated_by        = $userName;
                            $purchaseDetails->soft_delete       = $defaultStatus;
                            $purchaseDetails->is_barcode        = PURCHASE_DETAIL__BARCODE_GENERATED;
                            $purchaseDetails->save();

                            //Generate barcode for new item
                            $itemDetails = ItemModel::where('id', $request->item_id[$i])->select('id', 'name', 'category_id', 'sub_category_id')->first();
                            $barcode = $this->generateBarcode($itemDetails, $request->vendor_id, $purchase->id, $request->regular_price[$i], $request->sales_price[$i], $purchaseDetails->id);

                            $itemNameToStore = str_replace(' ', '', $itemDetails['name']);
                            $itemNameToStore = str_replace('/', '', $itemNameToStore);
                            array_push($barcodeArrayToDownload, asset('barcode/' . $itemNameToStore . $barcode . '.png'));


                            $purchaseItemBarcodeQuery = PurchaseItemBarcode::where('barcode', $barcode)->first();

                            //insert into stocks table
                            $stock = new StockModel();
                            $stock->item_barcodes_id = $purchaseItemBarcodeQuery->id;
                            $stock->barcode     = $purchaseItemBarcodeQuery->barcode;
                            $stock->item_id     = $request->item_id[$i];
                            $stock->quantity    = $request->quantity[$i];
                            $stock->uom         = $request->uom[$i];
                            $stock->cost_price  = $request->cost_price[$i];
                            $stock->created_by  = $userName;
                            $stock->updated_by  = $userName;
                            $stock->save();
                        }


                        //item table update
                        ItemModel::find($request->item_id[$i])->update([
                            'regular_price' => $request->regular_price[$i],
                            'sales_price'   => $request->sales_price[$i],
                            'cost_price'    => $request->cost_price[$i]
                        ]);
                    }

                    DB::commit();
                    // return response()->json("Successfully Updated");
                    return response()->json([
                        'data' => $barcodeArrayToDownload,
                        'status' => true,
                        'message' => "Successfully Updated"
                    ]);
                } catch (\Exception $exception) {
                    DB::rollback();
                    return response()->json(array('dbErrors' => $exception->getMessage()));
                }
            }
        }
    }


    /**
     * @name draftedPurchaseUpdateAjax
     * @role All purchase update form view
     * @param
     * @return view with compact array
     *
     */

    public function draftedPurchaseUpdateAjax(Request $request)
    {

        if (!$request->item_id) {
            return response()->json([
                'data' => null,
                'status' => false,
                'message' => "Sorry! Cannot delete all the previously purchased items."
            ]);
        } else {
            foreach ($request->item_id as $item_id) {
                if ($item_id === null) {
                    return response()->json([
                        'data' => null,
                        'status' => false,
                        'message' => "Select Item Please!!"
                    ]);
                }
            }

            $userName = Auth::user()->first_name;
            $defaultStatus = 0;

            //gettings attributes
            $attributeNames = array(

                'uom'               => $request->uom,
                'mrp'               => $request->mrp,
                'item_id'           => $request->item_id,
                'quantity'          => $request->quantity,
                'cost_price'        => $request->cost_price,
                'due_amount'        => $request->due_amount,
                'paid_amount'       => $request->paid_amount,
                'purchase_date'     => $request->purchase_date,
                'sales_price'       => $request->sales_price,
                'total_amount'      => $request->total_amount,
                'is_published'      => $request->is_published,
                'vendor_id'         => $request->vendor_id,
                'invoice_number'    => $request->invoice_number,
                'wholesale_price'   => $request->wholesale_price,
                'regular_price'     => $request->regular_price,
                'input_img'         => $request->input_img,
            );

            //validating the attributes
            $validator = Validator::make($attributeNames, [

                'cost_price.*'      => 'required',
                'due_amount'        => 'required',
                'invoice_number'    => 'required',
                'item_id.*'         => 'required',
                'mrp.*'             => 'required',
                'quantity.*'        => 'required',
                'uom.*'             => 'required',
                'paid_amount'       => 'required',
                'purchase_date'     => 'required',
                'sales_price.*'     => 'required',
                'wholesale_price.*' => 'required',
                'total_amount'      => 'required',
                'vendor_id'         => 'required',
                'regular_price.*'   => 'required|gte:sales_price.*',
                'input_img'         => 'max:1024'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'data' => $validator->getMessageBag()->toArray(),
                    'status' => "validation-error",
                    'message' => null
                ]);
            } else {

                DB::beginTransaction();
                try {

                    $challanImage = PurchaseModel::select('challan_img')->where('id', $request->purchase_id)->first();
                    if (isset($challanImage->challan_img)) {
                        if ($request->hasFile('input_img')) {
                            $file = $request->file('input_img');
                            $name = $file->getClientOriginalName();
                            $EXT = $file->getClientOriginalExtension();
                            $imageFileName = base64_encode($name . rand(10, 1000000));
                            $imageFileName = $imageFileName . "." . $EXT;

                            $basePath = base_path() . '/public/';
                            $targetRealPath = $basePath . 'img/challan/';
                            if (!File::isDirectory($targetRealPath))
                                File::makeDirectory($targetRealPath, 0755, true, true);

                            $attachment_path = 'img/challan/' . $imageFileName;

                            $file->move('img/challan/', $imageFileName);
                        }
                    } else {

                        return response()->json([
                            'data' => null,
                            'status' => false,
                            'message' => "Please upload image"
                        ]);
                    }

                    //Create logs of purchase table
                    $purchaseData = PurchaseModel::where('id', $request->purchase_id)->first();
                    $data = [
                        'purchase_id'       => $purchaseData['id'],
                        'vendor_id'         => $purchaseData['vendor_id'],
                        'invoice_number'    => $purchaseData['invoice_number'],
                        'purchase_date'     => $purchaseData['purchase_date'],
                        'total_amount'      => $purchaseData['total_amount'],
                        'paid_amount'       => $purchaseData['paid_amount'],
                        'due_amount'        => $purchaseData['due_amount'],
                        'challan_img'       => $purchaseData['challan_img'],
                        'remarks'           => $purchaseData['remarks'],
                        'is_draft'          => $purchaseData['is_draft'],
                        'completed_at'      => $purchaseData['completed_at'],
                        'created_by'        => $purchaseData['created_by'],
                        'updated_by'        => $purchaseData['updated_by'],
                        'soft_delete'       => $purchaseData['soft_delete'],
                    ];
                    $purchaseLogResult = PurchaseLog::create($data);

                    //Create logs of purchase details table
                    $purchaseDetailsData = PurchaseDetailsModel::where('purchase_id', $request->purchase_id)->get();
                    foreach ($purchaseDetailsData as $data) {
                        $data = [
                            'purchase_log_id'       => $purchaseLogResult['id'],
                            'purchase_detail_id'    => $data['id'],
                            'purchase_id'           => $data['purchase_id'],
                            'item_id'               => $data['item_id'],
                            'cost_price'            => $data['cost_price'],
                            'sales_price'           => $data['sales_price'],
                            'wholesale_price'       => $data['wholesale_price'],
                            'mrp'                   => $data['mrp'],
                            'quantity'              => $data['quantity'],
                            'uom'                   => $data['uom'],
                            'created_by'            => $data['created_by'],
                            'updated_by'            => $data['updated_by'],
                            'soft_delete'           => $data['soft_delete'],
                            // 'expired_date' => $data['expired_date'],
                        ];
                        PurchaseDetailLog::create($data);
                    }

                    //Update purchase table
                    $purchase = PurchaseModel::findOrFail($request->purchase_id);
                    $purchase->vendor_id        = $request->vendor_id;
                    $purchase->total_amount     = $request->total_amount;
                    $purchase->paid_amount      = $request->paid_amount;
                    $purchase->due_amount       = $request->due_amount;
                    $purchase->challan_img      = $attachment_path;
                    $purchase->remarks          = $request->remarks;
                    $purchase->is_draft         = 0;
                    $purchase->completed_at     = now()->toDateTimeString();
                    $purchase->updated_by       = $userName;
                    $purchase->update();

                    //deleting removed purchases from purchase_details table
                    if (isset($request->deletedItems)) {
                        $purchaseDetailsIdToDelete = array_map('intval', explode(',', $request->deletedItems));

                        foreach ($purchaseDetailsIdToDelete as $purchaseDetailsId) {
                            //deleting from purchase_details table
                            $purchaseDetailsData = PurchaseDetailsModel::where('id', $purchaseDetailsId)->first();
                            $purchaseDetailsData->soft_delete = 1;
                            $purchaseDetailsData->update();
                        }
                    }

                    //update purchase_details,item table
                    $barcodeArrayToDownload = [];

                    for ($i = 0; $i < count($request->item_id); $i++) {
                        $itemQuery = ItemModel::where('id', $request->item_id[$i]);

                        //price update in item table
                        $itemQuery->update([
                            'regular_price' => $request->regular_price[$i],
                            'sales_price'   => $request->sales_price[$i],
                            'cost_price'    => $request->cost_price[$i],
                            'is_published'  => $request->is_published[$i]
                        ]);

                        $itemDetails = $itemQuery->select('barcode', 'id', 'name', 'category_id', 'sub_category_id', 'regular_price')->first();

                        //purchase_details table update
                        $purchaseDetails = PurchaseDetailsModel::where(['purchase_id' => $request->purchase_id, 'item_id' => $request->item_id[$i], 'soft_delete' => 0])->first();
                        if ($purchaseDetails) {
                            //update purchase_details table
                            $purchaseDetails->cost_price        = $request->cost_price[$i];
                            $purchaseDetails->sales_price       = $request->sales_price[$i];
                            $purchaseDetails->wholesale_price   = $request->wholesale_price[$i];
                            $purchaseDetails->mrp               = $request->mrp[$i];
                            $purchaseDetails->quantity          = $request->quantity[$i];
                            $purchaseDetails->uom               = $request->uom[$i];
                            $purchaseDetails->updated_by        = $userName;
                            $purchaseDetails->is_barcode        = PURCHASE_DETAIL__BARCODE_GENERATED;
                            $purchaseDetails->update();
                        } else {
                            //purchase_details table insert
                            $purchaseDetails = new PurchaseDetailsModel();
                            $purchaseDetails->purchase_id       = $purchase->id;
                            $purchaseDetails->item_id           = $request->item_id[$i];
                            $purchaseDetails->cost_price        = $request->cost_price[$i];
                            $purchaseDetails->sales_price       = $request->sales_price[$i];
                            $purchaseDetails->wholesale_price   = $request->wholesale_price[$i];
                            $purchaseDetails->mrp               = $request->mrp[$i];
                            $purchaseDetails->quantity          = $request->quantity[$i];
                            $purchaseDetails->uom               = $request->uom[$i];
                            $purchaseDetails->created_by        = $userName;
                            $purchaseDetails->updated_by        = $userName;
                            $purchaseDetails->soft_delete       = $defaultStatus;
                            $purchaseDetails->barcode = "test";
                            $purchaseDetails->is_barcode        = PURCHASE_DETAIL__BARCODE_GENERATED;
                            $purchaseDetails->save();
                        }

                        $barcode = $this->generateBarcode($itemDetails, $request->vendor_id, $purchase->id, $request->regular_price[$i], $request->sales_price[$i], $purchaseDetails->id);
                        $itemNameToStore = str_replace(' ', '', $itemDetails['name']);
                        $itemNameToStore = str_replace('/', '', $itemNameToStore);

                        array_push($barcodeArrayToDownload, asset('barcode/' . $itemNameToStore . $barcode . '.png'));

                        $purchaseItemBarcodeQuery = PurchaseItemBarcode::where('barcode', $barcode)->first();

                        $stockQuery = StockModel::where(['barcode' => $barcode, 'cost_price' => $request->cost_price[$i], 'soft_delete' => 0]);
                        if ($stockQuery->exists()) {
                            $stock = $stockQuery->first();
                            $stock->quantity = $request->quantity[$i] + $stock->quantity;
                            $stock->uom = $request->uom[$i];
                            $stock->updated_by = $userName;
                            $stock->update();
                        } else {
                            $stock = new StockModel();
                            $stock->item_barcodes_id = $purchaseItemBarcodeQuery->id;
                            $stock->barcode     = $purchaseItemBarcodeQuery->barcode;
                            $stock->item_id     = $request->item_id[$i];
                            $stock->quantity    = $request->quantity[$i];
                            $stock->uom         = $request->uom[$i];
                            $stock->cost_price  = $request->cost_price[$i];
                            $stock->created_by  = $userName;
                            $stock->updated_by  = $userName;
                            $stock->save();
                        }
                    }

                    DB::commit();
                    return response()->json([
                        'data' => $barcodeArrayToDownload,
                        'status' => true,
                        'message' => 'Successful'
                    ]);
                } catch (\Exception $exception) {
                    DB::rollback();
                    return response()->json([
                        'data' => $exception->getMessage(),
                        'status' => false,
                        'message' => "Something went wrong!"
                    ]);
                }
            }
        }
    }




    /**
     * @name purchaseDeleteAjax
     * @role All purchase delete form view
     * @param
     * @return response json
     *
     */


    public function purchaseDeleteAjax(Request $request)
    {
        DB::beginTransaction();
        try {

            $purchase_details = PurchaseDetailsModel::where('purchase_id', $request->id)->where('soft_delete', 0)->get();
            foreach ($purchase_details as $purchase_detail) {

                $purchaseDetailsId = $purchase_detail->id;
                $item_barcodes_table = PurchaseItemBarcode::where(['purchase_detail_id' => $purchaseDetailsId])->first();
                $sold = SalesDetailsModel::where('barcode_id', $item_barcodes_table->id)->exists();
                if ($sold) {
                    return response()->json([
                        'data' => null,
                        'status' => false,
                        'message' => "Sorry! A quantity of item in this Invoice has already been sold."
                    ]);
                }
            }


            //unlink challan image
            $purchaseInfo        = PurchaseModel::findOrFail($request->id);
            if (is_file(public_path() . "/" . $purchaseInfo->challan_img)) {
                unlink($purchaseInfo->challan_img);
            }

            //update purchase table
            $purchase = PurchaseModel::findOrFail($request->id);
            $purchase->soft_delete = 1;
            $purchase->update();

            //update stock table
            $purchase_details = PurchaseDetailsModel::where('purchase_id', $request->id)->where('soft_delete', 0)->get();
            foreach ($purchase_details as $purchase_detail) {

                //Deleting from purchase_item_barocodes table
                $this->deleteBarcodeForPurchase($purchase_detail->id);

                //stock decrease or delete
                $item_barcodes_table = PurchaseItemBarcode::where(['purchase_detail_id' => $purchase_detail->id])->first();
                $stock = StockModel::where(['item_barcodes_id' => $item_barcodes_table->id, 'soft_delete' => 0])->update(['soft_delete' => 1]);
            }

            //update purchase_details table,used array as the purchase can have multiple items
            PurchaseDetailsModel::where('purchase_id', $request->id)->update(array('soft_delete' => 1));

            //update highlights table
            $highlight = HighlightsModel::where('type_id', $request->id)->first();
            if ($highlight != null) {
                $highlight->delete();
            }


            DB::commit();
            return response()->json([
                'data' => null,
                'status' => true,
                'message' => "Purchase deleted successfully"
            ]);
            // return json_encode([
            //     'status' => true,
            //     'message' => "Purchase deleted successfully",
            //     'data' => null
            // ]);

        } catch (\Exception $exception) {
            DB::rollback();
            return response()->json([
                'data' => null,
                'status' => false,
                'message' => $exception->getMessage()
            ]);
            // return json_encode([
            //     'status' => false,
            //     'message' => $exception->getMessage()
            // ]);
        }
    }




    /**
     * @name physical stock count View blade
     */
    public function physicalStockCount()
    {

        return view('admin.stock.physicalStockCountView');
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * Item insert by barcode from Physical Count Panel
     */
    public function itemCountByBarcode(Request $request)
    {
        try {
            $userName = Auth::user()->first_name;
            $barcode = $request->get('barcode');
            $barcodeData = PurchaseItemBarcode::where([
                'barcode' => $barcode,
                'soft_delete' => PURCHASE_ITEM_BARCODE__SOFT_DELETE_NO
            ])->first();

            if ($barcodeData) {
                /* check barcode existance in stock_count table */
                $barcodeInsertedAlready = StockCount::where('barcode', $barcode)->first();
                if ($barcodeInsertedAlready) {
                    $newQuantity = $barcodeInsertedAlready['quantity'] + 1;
                    $updateQuantity = StockCount::where('barcode', $barcode)
                        ->update([
                            'quantity' => $newQuantity,
                            'updated_by' => $userName
                        ]);
                } else {
                    /* stock_count table insert */
                    $StockCountInsert = new StockCount();
                    $StockCountInsert->item_id     = $barcodeData['item_id'];
                    $StockCountInsert->item_name   = $barcodeData->item->name;
                    $StockCountInsert->barcode     = $request->barcode;
                    $StockCountInsert->quantity    = 1;
                    $StockCountInsert->created_by  = $userName;
                    $StockCountInsert->updated_by  = $userName;
                    $StockCountInsert->save();
                }

                // $stockData = StockModel::where('item_barcodes_id',$barcodeData['id'])->select('quantity')->first();
                $itemData = ItemModel::where([
                    'id' => $barcodeData['item_id'],
                    'soft_delete' => SOFT_DELETE_NO
                ])->first();

                if ($itemData) {
                    return response()->json([
                        'data' => [
                            'itemData' => $itemData,
                            'barcodeData' => $barcodeData,
                            // 'stockData' => $stockData,
                        ],
                        'status' => true,
                        'message' => null
                    ]);
                }

                return response()->json([
                    'data' => null,
                    'status' => false,
                    'message' => 'No items found!'
                ]);
            }

            return response()->json([
                'data' => null,
                'status' => false,
                'message' => 'No barcodes found!'
            ]);
        } catch (\Exception $exception) {
            return response()->json([
                'data' => $exception->getMessage(),
                'status' => false,
                'message' => 'Something went wrong! Please try again'
            ]);
        }
    }



    /**
     * @name this function is used to get all data physicalStockCount server side data table(Added by Kawsar)
     */
    public function listAllPhysicalStockCount()
    {
        // $countedItemList = StockCount::orderBy('updated_at','desc');

        // added by monir: 02.05.2024
        $countedItemList = StockCount::with(['item'])
            ->orderBy('updated_at', 'desc')
            ->get();

        return DataTables::of($countedItemList)
            ->addColumn('data_barcode_name', function ($count) {
                return $count->barcode;
            })
            ->addColumn('data_item_name', function ($count) {
                return $count->item_name;
            })

            // added by monir: 02.05.2024
            ->addColumn('data_item_category_name', function ($count) {
                return $count->item->category->name;
            })

            ->addColumn('data_quantity_name', function ($count) {
                return $count->quantity;
            })
            ->addColumn('data_updated_by', function ($count) {
                return $count->updated_by;
            })
            ->addColumn('action', function ($count) {
                return '<button class="btn btn-primary btn-xs" onclick="itemCountEdit(' . $count->id . ')">
            <i class="fa fa-pencil"></i>
        </button>';
            })
            ->rawColumns(['data_barcode_name', 'data_item_name', 'data_item_category_name', 'data_quantity_name', 'action'])
            ->make(true);
    }

    /**
     * @name update physical inventory count
     * @param $id
     * @return response json
     */

    public function getItemCountDetailsAjax(Request $request)
    {
        $itemCountInfo = StockCount::findOrFail($request->id);
        if ($itemCountInfo) {

            return response()->json([
                'data' => $itemCountInfo,
                'status' => true,
                'message' => null
            ]);
        }

        return response()->json([
            'data' => null,
            'status' => false,
            'message' => "Quantity not found!"
        ]);
    }


    /**
     * @name Quantity update(only decrease) after scanning any item at Physical count panel
     * @param $id, $quantity
     * @return response json
     *
     */
    public function itemCountUpdateAjax(Request $request)
    {
        $userName = Auth::user()->first_name;
        $attributeNames = array(
            'quantity'    => $request->quantity,
            'updated_by'  => $userName
        );

        $validator = Validator::make($attributeNames, [
            'quantity'     => 'required',
            'updated_by'   => 'required'
        ]);

        if ($validator->fails()) {

            return response()->json([
                'data'      => $validator->getMessageBag()->toArray(),
                'status'    => 'validation-error',
                'message'   => null
            ]);
        }
        DB::beginTransaction();
        try {
            $itemCountInfo      = StockCount::findOrFail($request->id);
            $itemCountInfo->quantity       = $request->quantity;
            $itemCountInfo->updated_by     = $userName;
            $itemCountInfo->update();

            DB::commit();
            return response()->json([
                'data'      => null,
                'status'    => true,
                'message'   => 'Quantity updated Successfully!'
            ]);
        } catch (\Exception $exception) {
            DB::rollback();

            return response()->json([
                'data'      => null,
                'status'    => false,
                'message'   => $exception->getMessage(),
            ]);
        }
    }


    /**
     * @name Discrepancy report view
     */
    public function discrepancyReport()
    {

        return view('admin.stock.discrepancyReport');
    }


    /**
     * @name this function is used to get all data listAllForDiscrepancyReport server side data table(Added by Kawsar)
     */
    public function listAllForDiscrepancyReport()
    {
        $items = StockCount::get();

        return DataTables::of($items)
            ->addColumn('data_item_name', function ($item) {
                return $item->item_name;
            })
            ->addColumn('barcode_name', function ($item) {
                return $item->barcode;
            })
            ->addColumn('counted_quantity', function ($item) {
                return $item->quantity;
            })
            ->addColumn('system_quantity', function ($item) {
                $systemQty = $item->system_stock ? $item->system_stock->quantity : 0;
                return $systemQty;
            })
            ->addColumn('difference', function ($item) {
                $systemQty = $item->system_stock ? $item->system_stock->quantity : 0;
                $difference = $item->quantity - $systemQty;
                return $difference;
            })
            ->addColumn('updated_by', function ($item) {
                return $item->updated_by;
            })
            ->rawColumns(['data_barcode_name', 'barcode_name', 'counted_quantity', 'system_quantity', 'difference', 'updated_by'])
            ->make(true);
    }


    /**
     * backup send via mail and clear stock_count table
     */
    public function backupAndClearCountDataList()
    {

        try {
            //send backup mail
            $stockCountSheet = StockCount::get();
            $data['emails'] = ["technovabd.info@gmail.com", "automartctg@gmail.com"];
            $data["title"] = "Physical stock count report";
            $data["body"] = "This is the report generated till now.";
            $data['stockCountSheet'] = $stockCountSheet;

            $pdf = PDF::loadView('mail.stockCountSheet', ['stockCountSheet' => $stockCountSheet]);

            // Mail::send('mail.stockCountTitle', $data, function($message)use($data, $pdf) {
            //     $message->to($data["emails"])
            //         ->subject($data["title"])
            //         ->attachData($pdf->output(), "stockCountReport.pdf");
            // });s

            //clear stock_count table
            StockCount::truncate();
            DB::commit();

            return response()->json([
                'data'      =>  null,
                'status'    =>  true,
                'message'   =>  'Deleted all records successfully!'
            ]);
        } catch (\Exception $exception) {
            DB::rollback();

            return response()->json([
                'data'      => null,
                'status'    => false,
                'message'   => $exception->getMessage(),
            ]);
        }
    }




    /**
     * @name allStockView
     * @role stock view returns
     * @param
     * @return response json
     *
     */

    public function allStockView()
    {
        return view('admin.stock.stockView');
    }

    public function stockOutView()
    {
        return view('admin.stock.stockOutView');
    }


    public function allEditRequests()
    {
        $requests = PermissionRequest::where('permission', 0)->get();
        $approved_requests = PermissionRequest::where('permission', 1)->get();
        $data = [
            'requests' => $requests,
            'approved_requests' => $approved_requests

        ];
        return view('admin.stock.stockEditRequestsView', $data);
    }

    public function approveEditRequest(Request $request)
    {
        $userName = Auth::user()->first_name;
        $req_approve = PermissionRequest::where('id', $request->id)
            ->update([
                'permission' => 1,
                'approved_by' => $userName
            ]);

        if ($req_approve) {
            return response()->json('Success', 200);
        }
    }

    /**
     * @param Request $request
     * @return void
     * List all stocks in datatable
     */
    public function listAllStocks(Request $request)
    {
        // Start time
        // $startQueryTime = microtime(true);

        // $stockData = StockModel::where('soft_delete', 0)->where('quantity','>',0)->with(['item','purchase_item_barcode'])->orderBy('id', 'desc')->get();
        // // End time for query
        // $endQueryTime = microtime(true);

        // // Calculate database query execution time
        // $queryExecutionTime = $endQueryTime - $startQueryTime;
        // \Log::info("Old With Indexing Database Query Execution Time: {$queryExecutionTime} seconds");


        // // Start processing time
        // $startProcessingTime = microtime(true);

        // // return DataTables::of($stockData)
        // $dataTable = DataTables::of($stockData)
        //     ->addColumn('data_duplicate_flag', function ($stock) {
        //         $flag = $stock->duplicate_flag ? 'checked':'';
        //         return
        //         '<div class="form-check">
        //             <input class="form-check-input" type="checkbox" name="duplicate_flag" value="" onclick="duplicateFlag('.$stock->id.')" '.$flag.'>
        //         </div>';
        //     })
        //     ->addColumn('data_cross_flag', function ($stock) {
        //         $flag = $stock->cross_flag ? 'checked':'';
        //         if($flag == 'checked'){
        //             return
        //                 '<div class="form-check">
        //             <i class="fa fa-times" onclick="crossFlag('.$stock->id.')" title="Undo"></i>
        //         </div>';
        //         }
        //         else{
        //             return
        //                 '<div class="form-check">
        //             <i class="fa fa-square-o" onclick="crossFlag('.$stock->id.',0)" title="Cancel"></i>
        //         </div>';
        //         }
        //     })
        //     ->addColumn('data_item_name', function ($stock) {
        //         return '<a class="custom_textDecoration" onclick="itemDetails('.$stock->id.')" style="cursor:pointer">'.$stock->item->name.'</a>';
        //     })
        //     ->addColumn('data_item_image', function ($stock) {
        //         return '<img src="' . $stock->item->thumbnail . '" class="img-thumbnail" style="height: 65px;width: 65px;object-fit: contain;">';
        //     })
        //     ->addColumn('data_item_category_name', function ($stock) {
        //         return $stock->item->category->name;
        //     })
        //     ->addColumn('data_item_section_name', function ($stock) {
        //         return $stock->item->section->name;
        //     })
        //     ->addColumn('data_wholesale_price', function ($stock) {
        //         return $stock->purchase_item_barcode->purchase_details->wholesale_price;
        //     })
        //     ->addColumn('action',function($stock){
        //         $userId     = Auth::user()->id;
        //         $userName   = Auth::user()->first_name;
        //         $userRole   = UserRolesModel::where('user_id',$userId)->get();
        //         $currentUrl = Route::currentRouteName();
        //         $previousUrl = url()->previous();
        //         if ($stock->item->name == 'Installation Charge') {
        //             return '<p> Installation Charge </p>';
        //         } else {

        //             if($userId == 1) {
        //                 return '<button class="btn btn-primary btn-xs" onclick="editPurchaseModal('.$stock->id.')"><i class="fa fa-pencil"></i>Edit</button>
        //                         <a class="btn btn-primary btn-xs" href="'.$stock->purchase_item_barcode->barcode_image.'" download><i class="fa fa-download"></i> Barcode</a>';

        //             } elseif(PermissionRequest::where('user_id',$userId)->where('permission',1)->exists()){
        //                 foreach ($userRole as $role) {
        //                     $role_id = $role->role_id;
        //                     $modules = RolesDetailsModel::where('role_id',$role_id)->get();
        //                     foreach ($modules as $module) {
        //                         $module_id = $module->module_id;
        //                         $routes = ModuleDetailsModel::where('module_id',$module_id)->get();
        //                         foreach ($routes as $routeName) {
        //                             $route_name = $routeName->route;
        //                             $current_route_name = Route::currentRouteName();
        //                             if($route_name === $current_route_name){
        //                                 return '<button class="btn btn-primary btn-xs" onclick="editPurchaseModal('.$stock->id.')">Edit</button>
        //                                         <a class="btn btn-primary btn-xs" href="'.$stock->purchase_item_barcode->barcode_image.'" download><i class="fa fa-download"></i> Barcode</a>';

        //                             }
        //                         }
        //                     }
        //                 }



        //             } elseif(PermissionRequest::where('user_id',$userId)->where('permission',0)->exists()){
        //                 return '<a class="btn btn-primary btn-xs" href="'.$stock->purchase_item_barcode->barcode_image.'" download><i class="fa fa-download"></i> Barcode</a>';

        //             }else{
        //                 return '<a class="btn btn-primary btn-xs" href="'.$stock->purchase_item_barcode->barcode_image.'" download><i class="fa fa-download"></i> Barcode</a>
        //                         <button class="btn btn-primary btn-xs" onclick="editRequest('.$userId.','."'$userName'".','."'$currentUrl'".','."'$previousUrl'".')">Edit REQ</button>';
        //             }
        //         }
        //     })
        //     ->rawColumns(['data_duplicate_flag','data_cross_flag','action','data_item_name', 'data_item_image', 'data_item_category_name', 'data_item_section_name','data_wholesale_price'])
        //     ->make(true);

        // // End processing time
        // $endProcessingTime = microtime(true);

        // // Calculate processing time
        // $processingTime = $endProcessingTime - $startProcessingTime;
        // \Log::info("Processing Time: {$processingTime} seconds");

        // return $dataTable;



        $stockData = StockModel::where([['stocks.soft_delete', '=', 0], ['stocks.quantity', '>', 0]])
            ->with([
                'item:id,name,thumbnail,category_id,section_id',
                'item.category:id,name',
                'item.section:id,name',
                'purchase_item_barcode:id,barcode_image,regular_price,sales_price,purchase_detail_id',
                'purchase_item_barcode.purchase_details:id,wholesale_price'
            ])
            ->select(
                'stocks.id as stock_id',
                'stocks.item_id',
                'stocks.item_barcodes_id',
                'stocks.cross_flag',
                'stocks.duplicate_flag',
                'stocks.cost_price as stock_cost_price',
                'stocks.uom',
                'stocks.quantity',
                'stocks.barcode'
            );

        $dataTable = DataTables::of($stockData)
            ->addColumn('data_duplicate_flag', function ($stock) {
                $flag = $stock->duplicate_flag ? 'checked' : '';
                return '<div class="form-check">
                        <input class="form-check-input" type="checkbox" name="duplicate_flag" value="" 
                            onclick="duplicateFlag(' . $stock->stock_id . ')" ' . $flag . '>
                    </div>';
            })
            ->addColumn('data_cross_flag', function ($stock) {
                $flag = $stock->cross_flag ? 'checked' : '';
                if ($flag === 'checked') {
                    return '<div class="form-check">
                            <i class="fa fa-times" onclick="crossFlag(' . $stock->stock_id . ')" title="Undo"></i>
                        </div>';
                } else {
                    return '<div class="form-check">
                            <i class="fa fa-square-o" onclick="crossFlag(' . $stock->stock_id . ',0)" title="Cancel"></i>
                        </div>';
                }
            })
            ->addColumn('data_item_name', function ($stock) {
                return '<a class="custom_textDecoration" onclick="itemDetails(' . $stock->stock_id . ')" style="cursor:pointer">'
                    . e($stock->item->name) .
                    '</a>';
            })
            // ->addColumn('data_item_image', function ($stock) {
            //     $thumbnail = $stock->item->thumbnail ?: 'N/A';
            //     return '<img src="' . e($thumbnail) . '" class="img-thumbnail" style="height: 65px;width: 65px;object-fit: contain;">';
            // })
            ->addColumn('data_item_category_name', function ($stock) {
                return optional($stock->item->category)->name ?: 'N/A';
            })
            ->addColumn('data_item_section_name', function ($stock) {
                return optional($stock->item->section)->name ?: 'N/A';
            })
            ->addColumn('data_wholesale_price', function ($stock) {
                return optional($stock->purchase_item_barcode->purchase_details)->wholesale_price ?: 0;
            })

            // ->addColumn('barcode', function ($stock) {
            //     return optional($stock->barcode) ?: 'N/A';
            // })
            // ->addColumn('quantity', function ($stock) {
            //     return $stock->quantity ?: 0; // Assuming `quantity` is a field in `StockModel`
            // })
            ->addColumn('cost_price', function ($stock) {
                return optional($stock)->stock_cost_price ?: 0;
            })
            // ->addColumn('uom', function ($stock) {
            //     return optional($stock)->uom ?: 'N/A';
            // })

            ->addColumn('regular_price', function ($stock) {
                return optional($stock->purchase_item_barcode)->regular_price ?: 0;
            })
            ->addColumn('sales_price', function ($stock) {
                return optional($stock->purchase_item_barcode)->sales_price ?: 0;
            })
            ->addColumn('action', function ($stock) {
                $userId     = Auth::user()->id;
                $userName   = Auth::user()->first_name;
                $userRole   = UserRolesModel::where('user_id', $userId)->get();
                $currentUrl = Route::currentRouteName();
                $previousUrl = url()->previous();


                if ($stock->item->name == 'Installation Charge') {
                    return '<p> Installation Charge </p>';
                } else {

                    if ($userId == 1) {
                        return '<button class="btn btn-primary btn-xs" onclick="editPurchaseModal(' . $stock->stock_id . ')"><i class="fa fa-pencil"></i>Edit</button>
                                    <a class="btn btn-primary btn-xs" href="' . $stock->purchase_item_barcode->barcode_image . '" download><i class="fa fa-download"></i> Barcode</a>';
                    } elseif (PermissionRequest::where('user_id', $userId)->where('permission', 1)->exists()) {
                        foreach ($userRole as $role) {
                            $role_id = $role->role_id;
                            $modules = RolesDetailsModel::where('role_id', $role_id)->get();
                            foreach ($modules as $module) {
                                $module_id = $module->module_id;
                                $routes = ModuleDetailsModel::where('module_id', $module_id)->get();
                                foreach ($routes as $routeName) {
                                    $route_name = $routeName->route;
                                    $current_route_name = Route::currentRouteName();
                                    if ($route_name === $current_route_name) {
                                        return '<button class="btn btn-primary btn-xs" onclick="editPurchaseModal(' . $stock->stock_id . ')">Edit</button>
                                                    <a class="btn btn-primary btn-xs" href="' . $stock->purchase_item_barcode->barcode_image . '" download><i class="fa fa-download"></i> Barcode</a>';
                                    }
                                }
                            }
                        }
                        // $current_route_name = Route::currentRouteName();
                        // $userRoles = $userRole->load(['rolesDetails', 'rolesDetails.moduleDetails']);
                        // foreach ($userRoles as $role) {
                        //     foreach ($role->rolesDetails as $module) {
                        //         $routeNames = $module->moduleDetails->pluck('route')->toArray();
                        //         if (in_array($current_route_name, $routeNames)) {
                        //             // Return the buttons only when a match is found
                        //             return '<button class="btn btn-primary btn-xs" onclick="editPurchaseModal('.$stock->stock_id.')">Edit</button>
                        //                     <a class="btn btn-primary btn-xs" href="'.$stock->purchase_item_barcode->barcode_image.'" download>
                        //                         <i class="fa fa-download"></i> Barcode
                        //                     </a>';
                        //         }
                        //     }
                        // }


                    } elseif (PermissionRequest::where('user_id', $userId)->where('permission', 0)->exists()) {
                        return '<a class="btn btn-primary btn-xs" href="' . $stock->purchase_item_barcode->barcode_image . '" download><i class="fa fa-download"></i> Barcode</a>';
                    } else {
                        return '<a class="btn btn-primary btn-xs" href="' . $stock->purchase_item_barcode->barcode_image . '" download><i class="fa fa-download"></i> Barcode</a>
                                    <button class="btn btn-primary btn-xs" onclick="editRequest(' . $userId . ',' . "'$userName'" . ',' . "'$currentUrl'" . ',' . "'$previousUrl'" . ')">Edit REQ</button>';
                    }
                }
            })
            // ->rawColumns(['data_duplicate_flag','data_cross_flag','action','data_item_name', 'data_item_image', 'data_item_category_name', 'data_item_section_name','data_wholesale_price'])
            ->rawColumns(['data_duplicate_flag', 'data_cross_flag', 'action', 'data_item_name', 'data_item_category_name', 'data_item_section_name', 'data_wholesale_price'])
            ->make(true);

        return $dataTable;
    }


    public function listAllStockOut(Request $request)
    {

        $latestStockIds = StockModel::where('soft_delete', 0)
            ->groupBy('item_id')
            ->selectRaw('MAX(id) as id')
            ->pluck('id');


        $stockData = StockModel::where([['stocks.soft_delete', '=', 0], ['stocks.quantity', '<=', 0]])
            ->with([
                'item:id,name,thumbnail,category_id,section_id',
                'item.category:id,name',
                'item.section:id,name',
                'purchase_item_barcode:id,barcode_image,regular_price,sales_price,purchase_detail_id',
                'purchase_item_barcode.purchase_details:id,wholesale_price'
            ])
            ->select(
                'stocks.id as stock_id',
                'stocks.item_id',
                'stocks.item_barcodes_id',
                'stocks.cross_flag',
                'stocks.duplicate_flag',
                'stocks.cost_price as stock_cost_price',
                'stocks.uom',
                'stocks.quantity',
                'stocks.barcode',
                'stocks.isPublic',
                'stocks.stock_out_display',
            );

        if ($request->filled('ispublic')) {
            $stockData->where('stocks.isPublic', $request->ispublic);
        }

        if ($request->filled('priceDisplay')) {
            $stockData->where('stocks.stock_out_display', $request->priceDisplay);
        }


        if ($request->filled('sortOrder')) {

            if ($request->sortOrder == 1) {
                $stockData->orderBy('stocks.updated_at', 'asc');
            } else {
                $stockData->orderBy('stocks.updated_at', 'desc');
            }
        }

        return DataTables::of($stockData)



            ->addColumn('data_item_name', function ($stock) {

                $itemName = isset($stock->item->name)
                    ? $stock->item->name
                    : 'N/A';

                return '
                <a class="custom_textDecoration"
                    onclick="itemDetails(' . $stock->stock_id . ')"
                    style="cursor:pointer">'
                    . e($itemName) .
                    '</a>
            ';
            })

            ->addColumn('data_item_category_name', function ($stock) {

                return isset($stock->item->category->name)
                    ? $stock->item->category->name
                    : 'N/A';
            })

            ->addColumn('data_item_section_name', function ($stock) {

                return isset($stock->item->section->name)
                    ? $stock->item->section->name
                    : 'N/A';
            })

            ->addColumn('data_wholesale_price', function ($stock) {

                return isset($stock->purchase_item_barcode->purchase_details->wholesale_price)
                    ? $stock->purchase_item_barcode->purchase_details->wholesale_price
                    : 0;
            })



            ->addColumn('cost_price', function ($stock) {

                return $stock->stock_cost_price
                    ? $stock->stock_cost_price
                    : 0;
            })

            ->addColumn('regular_price', function ($stock) {

                return isset($stock->purchase_item_barcode->regular_price)
                    ? $stock->purchase_item_barcode->regular_price
                    : 0;
            })

            ->addColumn('sales_price', function ($stock) {

                return isset($stock->purchase_item_barcode->sales_price)
                    ? $stock->purchase_item_barcode->sales_price
                    : 0;
            })


            ->addColumn('action', function ($stock) {

                if ($stock->isPublic == 1) {

                    return '
            <button class="btn btn-primary btn-xs"
                onclick="changeStatus(' . $stock->stock_id . ')">
                public
            </button>
        ';
                } else {

                    return '
            <button class="btn btn-warning btn-xs"
                onclick="changeStatus(' . $stock->stock_id . ')">
                private
            </button>
        ';
                }
            })

            ->addColumn('stock_out_display', function ($stock) {

                if ($stock->stock_out_display == 1) {

                    return '
            <button class="btn btn-primary btn-xs"
                onclick="priceDisplaySatusChange(' . $stock->stock_id . ')">
                Contact For Price
            </button>
        ';
                } else {

                    return '
            <button class="btn btn-warning btn-xs"
                onclick="priceDisplaySatusChange(' . $stock->stock_id . ')">
                Stock Out
            </button>
        ';
                }
            })


            ->rawColumns([

                'data_item_name',
                'action',
                'stock_out_display'
            ])

            ->make(true);
    }

    public function stockPublicSatusChange($stockId)
    {
        $stock = StockModel::findOrFail($stockId);


        if ($stock->isPublic == 1) {

            $update = $stock->update([
                'isPublic' => 0
            ]);
        } else {

            $stock->update([
                'isPublic' => 1
            ]);
        }



        return response()->json([
            'success' => true,
            'message' => 'Status changed successfully'
        ]);
    }


    public function priceDisplaySatusChange($stockId)
    {
        $stock = StockModel::findOrFail($stockId);


        if ($stock->stock_out_display == 1) {

            $update = $stock->update([
                'stock_out_display' => 0
            ]);
        } else {

            $stock->update([
                'stock_out_display' => 1
            ]);
        }



        return response()->json([
            'success' => true,
            'message' => 'Status changed successfully'
        ]);
    }



    /**
     * @param $id
     * @return void
     * Returns item details for stock show
     */
    public function getItemDetailsForStockView($stockId)
    {
        $stockDetails = StockModel::where('id', $stockId)->with(['item', 'purchase_item_barcode'])->first();

        return response()->json([
            'data' => $stockDetails,
            'status' => true,
            'message' => null
        ]);
    }

    public function getPriceAndQuantityForStockEdit(Request $request)
    {
        $stockDetails = StockModel::where('id', $request->stockId)->with(['item', 'purchase_item_barcode'])->first();
        $purchaseData = PurchaseModel::where('id', $stockDetails->purchase_item_barcode->purchase_id)->first();
        $purchaseDetailsData = PurchaseDetailsModel::where('id', $stockDetails->purchase_item_barcode->purchase_detail_id)->first();
        $purchaseItemBarcodeData = PurchaseItemBarcode::where('id', $stockDetails->item_barcodes_id)->first();
        $itemData = ItemModel::where('id', $stockDetails->item_id)->first();

        $sold_quantity = $purchaseDetailsData->quantity - $stockDetails->quantity;

        return response()->json([
            'data' => [
                'stockDetails' => $stockDetails,
                'purchaseData' => $purchaseData,
                'purchaseDetailsData' => $purchaseDetailsData,
                'purchaseItemBarcodeData' => $purchaseItemBarcodeData,
                'itemData' => $itemData,
                'sold_quantity' => $sold_quantity
            ],
            'status' => true,
            'message' => null
        ]);
    }

    public function editRequestAjax(Request $request)
    {
        try {
            $data = [
                'user_id'       => $request->userId,
                'current_url'   => $request->currentUrl,
                'previous_url'  => $request->previousUrl,
                'requested_by'  => $request->userName,
            ];

            $response = PermissionRequest::create($data);

            if ($response) {
                return response()->json("Success");
            }
        } catch (\Exception $exception) {
            return response()->json(array('dbErrors' => $exception->getMessage()));
        }
    }

    // public function stockDetailsView($id)
    // {
    //     $itemTable = ItemModel::where('id',$id)->where('soft_delete', 0)->first();
    //     $productdetailsTable = PurchaseDetailsModel::where('item_id',$id)->where('soft_delete', 0)->with(['purchase','purchase_item_barcode'])->get();

    //     $data = [
    //         'itemTable'         => $itemTable,
    //         'productdetailsTable' => $productdetailsTable
    //     ];
    //     return view('admin.stock.stockDetailsView', $data);
    // }

    // public function stockDetailsEdit($id)
    // {
    //     $itemTable = ItemModel::where('id',$id)->where('soft_delete', 0)->first();
    //     $productdetailsTable = PurchaseDetailsModel::where('item_id',$id)->where('soft_delete', 0)->with(['purchase','purchase_item_barcode'])->get();

    //     $data = [
    //         'itemTable'         => $itemTable,
    //         'productdetailsTable' => $productdetailsTable
    //     ];
    //     return view('admin.stock.stockDetailsEdit', $data);
    // }


    public function getPurchaseDetails(Request $request)
    {
        $purchaseDetails = PurchaseDetailsModel::findOrFail($request->id);
        $purchase = PurchaseModel::findOrFail($purchaseDetails->purchase_id);
        $data = [
            'purchaseDetails' => $purchaseDetails,
            'purchase'        => $purchase
        ];
        return response()->json($data);
    }


    // public function updateItemPrice(Request $request)
    // {
    //     $stock_update = ItemModel::findOrFail($request->item_id);

    //     $attributeNames = array(
    //         'regular_price' => $request->regular_price,
    //         'sales_price'   => $request->sales_price,
    //         'is_published'  => $request->is_published
    //     );

    //     $validator = Validator::make($attributeNames, [
    //         'regular_price'   => 'gte:sales_price',

    //     ]);

    //     if ($validator->fails()) {
    //         return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
    //     } else {
    //         $stock_update->regular_price = $request->regular_price;
    //         $stock_update->sales_price = $request->sales_price;
    //         $stock_update->is_published = $request->is_published;
    //         $stock_update->update();

    //         //stucked
    //         $itemid = $request->item_id;
    //         $purchase_details = PurchaseDetailsModel::where('item_id',$itemid)->where('soft_delete', 0)->first();
    //         $purchase_details->sales_price = $request->sales_price;
    //         $purchase_details->update();

    //         return response()->json("Success");
    //     }
    // }


    public function purchaseUpdateFromStock(Request $request)
    {
        $attributeNames = array(
            'purchase_item_barcode_id'   => $request->purchase_item_barcode_id,
            'purchase_id'           => $request->purchase_id,
            'purchase_details_id'   => $request->purchase_details_id,
            'item_id'               => $request->item_id,
            'total_amount'          => $request->total_amount,
            'paid_amount'           => $request->paid_amount,
            'due_amount'            => $request->due_amount,
            'cost_price'            => $request->cost_price,
            'quantity'              => $request->quantity,
            'regular_price'         => $request->regular_price,
            'sales_price'           => $request->sales_price,
            'wholesale_price'       => $request->wholesale_price
        );

        $validator = Validator::make($attributeNames, [
            'paid_amount'       => 'lte:total_amount',
            'due_amount'        => 'lte:total_amount',
            'total_amount'      => 'min:1',
            'paid_amount'       => 'min:0',
            'due_amount'        => 'min:0',
            'quantity'          => 'min:1',
            'regular_price'     => 'gte:sales_price',
            'wholesale_price'   => 'min:1'
        ]);

        if ($validator->fails()) {
            return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        } else {
            DB::beginTransaction();
            try {
                $userName = Auth::user()->first_name;

                //Create logs of purchase table.
                $purchaseData = PurchaseModel::where('id', $request->purchase_id)->first();
                $data = [
                    'purchase_id'       => $purchaseData['id'],
                    'vendor_id'         => $purchaseData['vendor_id'],
                    'invoice_number'    => $purchaseData['invoice_number'],
                    'purchase_date'     => $purchaseData['purchase_date'],
                    'total_amount'      => $purchaseData['total_amount'],
                    'paid_amount'       => $purchaseData['paid_amount'],
                    'due_amount'        => $purchaseData['due_amount'],
                    'challan_img'       => $purchaseData['challan_img'],
                    'created_by'        => $purchaseData['created_by'],
                    'updated_by'        => $purchaseData['updated_by'],
                    'soft_delete'       => $purchaseData['soft_delete'],
                ];
                $purchaseLogResult = PurchaseLog::create($data);

                //Create logs of purchase details table.
                $purchaseDetailsData = PurchaseDetailsModel::where('purchase_id', $request->purchase_id)->get();
                foreach ($purchaseDetailsData as $data) {
                    $data = [
                        'purchase_log_id'       => $purchaseLogResult['id'],
                        'purchase_detail_id'    => $data['id'],
                        'purchase_id'           => $data['purchase_id'],
                        'item_id'               => $data['item_id'],
                        'cost_price'            => $data['cost_price'],
                        'sales_price'           => $data['sales_price'],
                        'wholesale_price'       => $data['wholesale_price'],
                        'mrp'                   => $data['mrp'],
                        'quantity'              => $data['quantity'],
                        'uom'                   => $data['uom'],
                        'created_by'            => $data['created_by'],
                        'updated_by'            => $data['updated_by'],
                        'soft_delete'           => $data['soft_delete']
                    ];
                    PurchaseDetailLog::create($data);
                }

                //Update purchase table.
                $purchase = PurchaseModel::findOrFail($request->purchase_id);
                $purchase->total_amount     = $request->total_amount;
                $purchase->paid_amount      = $request->paid_amount;
                $purchase->due_amount       = $request->due_amount;
                $purchase->updated_by       = $userName;
                $purchase->update();


                //update purchase_details and stock decrease from stock table.
                $purchaseDetailsQuery = PurchaseDetailsModel::where(['purchase_id' => $request->purchase_id, 'item_id' => $request->item_id, 'soft_delete' => 0]);
                $stockQuery = StockModel::where(['item_barcodes_id' => $request->purchase_item_barcode_id, 'soft_delete' => 0]);
                if ($purchaseDetailsQuery->count() > 0) {
                    //condition satisfied means item exists without soft_delete.
                    $purchaseDeatils = $purchaseDetailsQuery->first();
                    //decrease/empty the old quantity from stock.
                    if ($stockQuery->exists()) {
                        $stock = $stockQuery->first();
                        $stock->quantity = $stock->quantity - $purchaseDeatils->quantity;
                        $stock->update();
                    }

                    $purchaseDeatils->quantity          = $request->quantity;
                    $purchaseDeatils->sales_price       = $request->sales_price;
                    $purchaseDeatils->wholesale_price   = $request->wholesale_price;
                    $purchaseDeatils->updated_by        = $userName;
                    $purchaseDeatils->update();

                    //update purchase_item_barcode table
                    $barcodeTableQuery = PurchaseItemBarcode::where(['id' => $request->purchase_item_barcode_id, 'purchase_detail_id' => $request->purchase_details_id, 'soft_delete' => 0])->first();
                    $barcodeTableQuery->regular_price = $request->regular_price;
                    $barcodeTableQuery->sales_price = $request->sales_price;
                    $barcodeTableQuery->update();
                }

                //increase the new quantity to stock.
                if ($stockQuery->exists()) {
                    $stockUpdate = $stockQuery->first();
                    $stockUpdate->quantity      = $request->quantity + $stockUpdate->quantity;
                    $stockUpdate->updated_by    = $userName;
                    $stockUpdate->update();
                }

                DB::commit();
                return response()->json("Success");
            } catch (\Exception $exception) {
                DB::rollback();
                return response()->json(array('dbErrors' => $exception->getMessage()));
            }
        }
    }


    public function duplicateFlagAjax(Request $request)
    {
        try {
            $id = $request->id;
            $flag = StockModel::where('id', $id)->where('soft_delete', 0)->first();
            if ($flag->duplicate_flag == 0) {
                $flag->duplicate_flag = 1;
                $flag->update();
                $message = "Checked!";
            } else {
                $flag->duplicate_flag = 0;
                $flag->update();
                $message = "Unchecked!";
            }
            return response()->json([
                'status'    => true,
                'message'   => $message
            ]);
        } catch (\Exception $exception) {
            return response()->json([
                'status'    => true,
                'message'   => $exception->getMessage()
            ]);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * Cancel stock flag
     */
    public function crossFlagAjax(Request $request)
    {
        try {
            $id = $request->id;
            $flag = StockModel::where('id', $id)->where('soft_delete', 0)->first();
            if ($flag->cross_flag == 0) {
                $flag->cross_flag = 1;
                $flag->update();
                $message = "Checked!";
            } else {
                $flag->cross_flag = 0;
                $flag->update();
                $message = "Unchecked!";
            }
            return response()->json([
                'status'    => true,
                'message'   => $message
            ]);
        } catch (\Exception $exception) {
            return response()->json([
                'status'    => true,
                'message'   => $exception->getMessage()
            ]);
        }
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * Item search by barcode from POS sales panel
     */
    public function itemSearchByBarcode(Request $request)
    {
        try {
            $barcode = $request->get('barcode');
            $barcodeData = PurchaseItemBarcode::where([
                'barcode' => $barcode,
                'soft_delete' => PURCHASE_ITEM_BARCODE__SOFT_DELETE_NO
            ])->first();

            if ($barcodeData) {
                $stockData = StockModel::where('item_barcodes_id', $barcodeData['id'])->select('quantity')->first();
                $itemData = ItemModel::where([
                    'id' => $barcodeData['item_id'],
                    'soft_delete' => SOFT_DELETE_NO
                ])->first();

                if ($itemData) {
                    return response()->json([
                        'data' => [
                            'itemData' => $itemData,
                            'barcodeData' => $barcodeData,
                            'stockData' => $stockData,
                        ],
                        'status' => true,
                        'message' => null
                    ]);
                }

                return response()->json([
                    'data' => null,
                    'status' => false,
                    'message' => 'No items found!'
                ]);
            }

            return response()->json([
                'data' => null,
                'status' => false,
                'message' => 'No barcodes found!'
            ]);
        } catch (\Exception $exception) {
            return response()->json([
                'data' => $exception->getMessage(),
                'status' => false,
                'message' => 'Something went wrong! Please try again'
            ]);
        }
    }

    /**
     * @return void
     * This function is used for generating barcodes for previously purchased items
     */
    public function generateBarcodeForPreviousPurchase()
    {
        DB::beginTransaction();
        try {
            $purchaseDetails = PurchaseDetailsModel::where([
                'is_barcode' => PURCHASE_DETAIL__BARCODE_NOT_GENERATED,
                'soft_delete' => PURCHASE_DETAIL__SOFT_DELETE_NO
            ])->limit(10)->get();

            $counter = 0;
            foreach ($purchaseDetails as $detail) {
                $itemId = $detail['item_id'];
                $itemDetails = ItemModel::where('id', $itemId)->select('id', 'name', 'category_id', 'sub_category_id', 'regular_price', 'sales_price')->first();
                $purchaseData = PurchaseModel::where('id', $detail['purchase_id'])->select('vendor_id')->first();

                //Generate barcode
                $barcode = $this->generateBarcode($itemDetails, $purchaseData['vendor_id'], $detail['purchase_id'], $itemDetails['regular_price'], $itemDetails['sales_price'], $detail['id']);

                //Update purchase details table
                $response = PurchaseDetailsModel::where('id', $detail['id'])->update([
                    'is_barcode' => PURCHASE_DETAIL__BARCODE_GENERATED
                ]);
                $counter++;
            }
            DB::commit();
            return response()->json([
                'data' => $counter,
                'status' => true,
                'message' => 'Successful'
            ]);
        } catch (\Exception $exception) {
            DB::rollBack();

            return response()->json([
                'data' => $exception->getMessage(),
                'status' => false,
                'message' => 'Something went wrong! Please try again'
            ]);
        }
    }

    // Copy data into stocks table
    public function copyPurchasedItemsToStock()
    {
        $barcodesData = PurchaseItemBarcode::where('soft_delete', 0)->get();
        foreach ($barcodesData as $barcode) {
            $purchaseDetailData = PurchaseDetailsModel::where('id', $barcode->purchase_detail_id)->first();

            $data = [
                'item_barcodes_id' => $barcode->id,
                'item_id'       => $barcode->item_id,
                'barcode'       => $barcode->barcode,
                'quantity'      => $purchaseDetailData->quantity,
                'uom'           => $purchaseDetailData->uom,
                'cost_price'    => $purchaseDetailData->cost_price,
                'created_by'    => $purchaseDetailData->created_by,
                'updated_by'    => $purchaseDetailData->updated_by,
                'created_at'    => $purchaseDetailData->created_at,
                'updated_at'    => $purchaseDetailData->updated_at,
            ];

            StockModel::create($data);
        }

        return response()->json([
            'status' => 200,
            'message' => 'Script executed successfully'
        ]);
    }

    //Copy duplicate flag from old stocks to new stocks table
    public function copyDuplicateFlagFromOldStockToStock()
    {
        $oldStocks = DB::table('stock_old')->select('duplicate_flag', 'item_id')->get();
        foreach ($oldStocks as $oldStock) {
            StockModel::where('item_id', $oldStock->item_id)->update([
                'duplicate_flag' => $oldStock->duplicate_flag
            ]);
        }

        return response()->json([
            'status' => 200,
            'message' => 'Script executed successfully'
        ]);
    }

    public function downloadBarcode(Request $request) {}
    public function test()
    {
        return view('admin.purchase.test');
    }

    //Finds out where mismatch happens in purchase and purchase details
    public function testPurchaseMismatch()
    {
        $mismatchArray = [];
        $allPurchases = PurchaseModel::where('soft_delete', 0)->get();
        foreach ($allPurchases as $purchase) {
            $amount = PurchaseDetailsModel::where('purchase_id', $purchase->id)->where('soft_delete', 0)->selectRaw('sum(cost_price * quantity) as total')->first()['total'];
            if ($amount != $purchase->total_amount)
                array_push($mismatchArray, $purchase->id);
        }
        dd($mismatchArray);
    }
}
