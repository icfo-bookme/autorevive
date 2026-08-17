<?php

namespace App\Http\Controllers\item;

use Illuminate\Support\Facades\DB;
use App\tags\Tags;
use App\car\CarModel;
use App\car\CarBrandModel;
use App\car\CarModelModel;
use App\TemporaryBarcode\TemporaryBarcode;
use App\item\ItemModel;
use App\Brand\BrandModel;
use Illuminate\Http\Request;
use App\section\SectionModel;
use App\item\ItemPictureModel;
use App\item\ItemSpecification;
use App\category\CategoryModel;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use App\subCategory\SubCategoryModel;
use App\purchase\PurchaseDetailsModel;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use App\item\ItemCarModelDetails;
use Intervention\Image\Facades\Image;
use App\Brand;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\DataTables;
use App\Http\Helpers\UtilityHelper;
use App\purchase\PurchaseItemBarcode;
use App\PurchaseBarcode\PurchaseBarcode;
use Exception;
use ItemPicture;
use PurchaseDetails;

class ItemController extends Controller
{

    public function getOnlyFileName($fileName)
    {
        if (str_contains($fileName, "_")) {
            return explode('_', $fileName)[0];
        }
        return $fileName;
    }
    public function unuseditemimagesRemove()
    {
        try {
            $thumb = 0;
            $img = 0;
            $useless = 0;
            $total = 0;
            $files = File::files(public_path() . "/" . "itemImage");

            foreach ($files as $file) {
                $filename = $file->getFileName();
                $filenamewithExt = "itemImage/" . $filename;
                $file = explode('.', $filenamewithExt);
                $file2 = explode('.', $filename);
                $onlyFileName = $this->getOnlyFileName($file2[0]);
                $thumbnail = ItemModel::where('thumbnail', 'like', '%' . $onlyFileName . '%')->first();
                $image = ItemPictureModel::where('image_path', 'like', '%' . $onlyFileName . '%')->first();
                if (isset($thumbnail)) {
                    $thumb++;
                } else if (isset($image)) {
                    $img++;
                } else {
                    $useless++;
                    unlink($filenamewithExt);
                }
                $total++;
            }

            return response()->json([
                'data' => [
                    'total_images' => $total,
                    'thumbnail' => $thumb,
                    'item_picture' => $img,
                    'removed' => $useless
                ],
                'status' => true,
                'message' => 'Successfully done'
            ]);
        } catch (Exception $exception) {
            dd($exception->getMessage());
        }
    }

    /**
     * @name itemSetupView
     * @role All item setup form view
     * @param
     * @return view with compact array
     *
     */
    public function itemSetupView()
    {
        $categories    = CategoryModel::where('soft_delete', 0)->get();
        $subCategories = SubCategoryModel::where('soft_delete', 0)->get();
        $brands        = BrandModel::where('soft_delete', 0)->get();
        $sections      = SectionModel::where('soft_delete', 0)->get();
        $companies     = CarModel::where('soft_delete', 0)->get();

        $data = [
            'subCategories' => $subCategories,
            'brands'        => $brands,
            'categories'    => $categories,
            'sections'      => $sections,
            'companies'     => $companies
        ];

        return view('admin.item.itemSetupView', $data);
    }

    /**
     * Generates barcode for items
     */
    // public function generateBarcode(Request $request)
    // {
    //    $categoryId = $request->get('categoryId');
    //    $countBarcodes = TemporaryBarcode::where('category_id',$categoryId)->count();
    //    $generatedBarcode = $this->makeBarcode($categoryId, $countBarcodes + 1);

    //    // Input barcode in temporary_barcodes table
    //    $data = [
    //         'category_id' => $categoryId,
    //         'barcode' => $generatedBarcode
    //    ];

    //    $response = TemporaryBarcode::create($data);

    //    if($response){

    //     return response()->json([
    //      'status' => true,
    //      'message'=> null,
    //      'data' => $generatedBarcode
    //     ]);
    //    }

    //    return response()->json([
    //     'status' => false,
    //     'message'=> "Something went wrong! Please try again",
    //     'data' => null
    //    ]);
    // }




    /**
     * @name getSubcategoryBycategoryAjax
     * @get subcategory
     * @param
     * @return value
     *
     */
    public function getSubcategoryBycategoryAjax(Request $request)
    {

        $subCategory = SubCategoryModel::where('category_id', $request->id)->where('soft_delete', 0)->get();
        return response()->json($subCategory);
    }

    public function makeBarcode($categoryId, $itemCount)
    {
        return sprintf("%03d", $categoryId) . sprintf("%05d", $itemCount);
    }




    public function generateSmallImage($mainImage)
    {
        $imageDetails = UtilityHelper::getImageDetails($mainImage);
        $original_file = $mainImage;

        //Returns file where new small file will be stored
        $resize_file = UtilityHelper::getResizeFilePath($imageDetails['image'], $imageDetails['extension']);

        if (!file_exists($resize_file)) {
            //This actually resizes the file
            $wmax = 320;
            $hmax = 320;
            $resize_response = UtilityHelper::image_resize(public_path($original_file), public_path($resize_file), $wmax, $hmax, $imageDetails['extension']);
        }

        return $resize_file;
    }


    /**
     * @name itemInsertAjax
     * @role insert item info into  database
     * @param Request from array
     * @return json response
     *
     */

    public function itemInsertAjax(Request $request)
    {

        $userName        = Auth::user()->first_name;
        $defaultStatus   = 0;
        $tagList = explode(',', $request->tags);
        $tagList = array_unique($tagList);

        //gettings attributes
        $attributeNames = array(
            'category_id'            => $request->category_id,
            'sub_category_id'        => $request->subcategory_id,
            'brand_id'               => $request->brand_id,
            'section_id'             => $request->section,
            'name'                   => $request->name,
            // 'barcode'                => $request->barcode,
            'length'                 => $request->length,
            'height'                 => $request->height,
            'width'                  => $request->width,
            'minimum_order_quantity' => $request->minimum_order_quantity,
            'regular_price'          => $request->regular_price,
            'sales_price'            => $request->sales_price,
            'minimum_price'          => $request->minimum_price,
            'thumbnail'              => $request->thumbnail,
            'details'                => $request->details,
            'sales_type'             => $request->sales_type,
            'is_published'           => $request->is_published,
            'image'                  => $request->image,
            'company'                => $request->company,
            'brand'                  => $request->brand,
            'model'                  => $request->model
        );

        //validating the attributes
        $validator = Validator::make($attributeNames, [
            'name'                   => 'required',
            'category_id'            => 'required',
            'sub_category_id'        => 'required',
            'brand_id'               => 'required',
            'section_id'             => 'required',
            // 'barcode'                => 'required',
            'minimum_order_quantity' => 'required',
            'thumbnail'              => 'required',
            'details'                => 'required',
            'sales_type'             => 'required',
            'is_published'           => 'required',
            'image.*'                => 'required',
            'regular_price'          => 'gte:sales_price',

        ]);


        if ($validator->fails()) {
            return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        } else {
            DB::beginTransaction();
            try {
                $resizedImage = null;
                if ($request->hasFile('thumbnail')) {
                    $thumbnail                         = $request->file('thumbnail');
                    $watermark                         = Image::make($thumbnail->getRealPath());
                    $imageWidth = $watermark->width();

                    if ($imageWidth >= 1000) {
                        $watermark->insert(public_path('watermark/watermarkLogo.png'), 'center-center', 10, 10);
                    } else if ($imageWidth >= 500 && $imageWidth < 1000) {
                        $watermark->insert(public_path('watermark/watermarkLogo_small.png'), 'center-center', 10, 10);
                    } else {
                        $watermark->insert(public_path('watermark/watermarkLogo_smaller.png'), 'center-center', 10, 10);
                    }

                    $thumbnailName                     = $thumbnail->getClientOriginalName();
                    $thumbnailFile                     = base64_encode($thumbnailName . rand(10, 1000000));
                    $thumbnailExt                      = $thumbnail->getClientOriginalExtension();

                    $watermarkFileName                 = $thumbnailFile . "." . $thumbnailExt;
                    $thumbnail_path                    = 'itemImage/' . $watermarkFileName;
                    $watermark->save($thumbnail_path);

                    $thumbnailFileName                 = $thumbnailFile . "_original" . "." . $thumbnailExt;
                    $original_thumbnail_path           = 'itemImage/' . $thumbnailFileName;
                    $thumbnail->move('itemImage/', $thumbnailFileName);

                    $resizedImage = $this->generateSmallImage($thumbnail_path);
                }


                $item =  new ItemModel();
                $item->category_id           = $request->category_id;
                $item->sub_category_id       = $request->subcategory_id;
                $item->brand_id              = $request->brand_id;
                $item->section_id            = $request->section;
                $item->name                  = $request->name;
                // $item->barcode               = $request->barcode;
                $item->length                = $request->length;
                $item->height                = $request->height;
                $item->width                 = $request->width;
                $item->minimum_order_quantity     = $request->minimum_order_quantity;
                $item->regular_price         = $request->regular_price;
                $item->sales_price           = $request->sales_price;
                $item->minimum_price         = $request->minimum_price;
                $item->thumbnail             = $thumbnail_path;
                $item->details               = $request->details;
                $item->sales_type            = $request->sales_type;
                $item->is_published          = $request->is_published;
                $item->created_by            = $userName;
                $item->updated_by            = $userName;
                $item->soft_delete           = $defaultStatus;
                $item->has_watermark         = 1;
                $item->resized_image         = $resizedImage;

                if ($request->company) {
                    $item->car_company_id        = $request->company;
                }

                if ($request->brand) {
                    $item->car_brand_id          = $request->brand;
                }

                if ($request->model) {
                    $item->car_model_id          = $request->model;
                }

                $item->save();

                $modelPivot = explode(",", $request->model_pivot);

                //INSERT INTO CAR MODEL PIVOT TABLE
                if ($modelPivot[0] != 'null') {

                    foreach ($modelPivot as $pivot) {
                        ItemCarModelDetails::create(
                            [
                                'item_id'      =>  $item->id,
                                'car_model_id' =>  $pivot
                            ]
                        );
                    }
                }

                // //Update barcode status
                // TemporaryBarcode::where(['category_id'=>$request->category_id, 'barcode'=>$request->barcode])
                //         ->update(['status'=>TemporaryBarcode::USED_BARCODE]);

                // //Delete previous entry (status not used) for more than an hour
                // TemporaryBarcode::where('status',TemporaryBarcode::NOT_USED_BARCODE)
                //                 ->where('created_at', '<', Carbon::now()->subHours(1))
                //                 ->delete();

                if ($request->spec_name) {
                    if ($request->spec_name[0] != null) {
                        for ($i = 0; $i < count($request->spec_name); $i++) {
                            ItemSpecification::create([
                                'item_id' => $item->id,
                                'name' => $request->spec_name[$i],
                                'details' => $request->spec_details[$i],
                                'soft_delete' => 0
                            ]);
                        }
                    }
                }



                if ($request->hasFile('image')) {

                    foreach ($request->file('image') as $file) {

                        $water                  = Image::make($file->getRealPath());

                        $imageWidth = $water->width();

                        if ($imageWidth >= 1000) {
                            $water->insert(public_path('watermark/watermarkLogo.png'), 'center-center', 10, 10);
                        } else if ($imageWidth >= 500 && $imageWidth < 1000) {
                            $water->insert(public_path('watermark/watermarkLogo_small.png'), 'center-center', 10, 10);
                        } else {
                            $water->insert(public_path('watermark/watermarkLogo_smaller.png'), 'center-center', 10, 10);
                        }

                        $name                   = $file->getClientOriginalName();
                        $imageName              = base64_encode($name . rand(10, 1000000));
                        $EXT                    = $file->getClientOriginalExtension();

                        $waterImageName         = $imageName . "." . $EXT;
                        $attachment_path        = 'itemImage/' . $waterImageName;
                        $water->save($attachment_path);

                        $imageFileName              = $imageName . "_original" . "." . $EXT;
                        $original_attachment_path   = 'itemImage/' . $imageFileName;
                        $file->move('itemImage/', $imageFileName);


                        $itemImage              = new ItemPictureModel();
                        $itemImage->item_id     = $item->id;
                        $itemImage->image_path  = $attachment_path;
                        $itemImage->created_by  = $userName;
                        $itemImage->updated_by  = $userName;
                        $itemImage->soft_delete = $defaultStatus;
                        $itemImage->save();
                    }
                }

                //TAG INSERT
                if ($tagList[0] != '') {
                    foreach ($tagList as $tag) {
                        $this->insertTag($item['id'], $tag);
                    }
                }

                DB::commit();
                return response()->json("Success");
            } catch (\Exception $exception) {
                DB::rollback();
                return response()->json(array('dbErrors' => $exception->getMessage()));
            }
        }
    }


    public function addWatermarkToPreviousImage()
    {
        $itemdata = ItemModel::with(['item_images'])->orderBy('id', 'desc')->select(['id', 'thumbnail'])->where('has_watermark', 0)->limit(5)->get();

        foreach ($itemdata as $item) {
            $this->createWatermark($item['thumbnail']);
            foreach ($item->item_images as $additionalImage) {
                $this->createWatermark($additionalImage['image_path']);
            }

            ItemModel::where('id', $item['id'])->update([
                'has_watermark' => 1
            ]);
        }
        return response()->json(['status' => true]);
    }


    public function createWatermark($image)
    {
        $imageSource = explode('.', $image);

        if (isset($imageSource[0]) && isset($imageSource[1])) {
            $originalFileName                 = $imageSource[0] . "_original" . "." . $imageSource[1];

            if (!file_exists(public_path() . "/" . $originalFileName)) {
                $thumbnail = Image::make($image);
                $watermark = $thumbnail;


                //Move original image
                $thumbnailFileName = $originalFileName;
                $thumbnail->save($thumbnailFileName);

                //Create watermark image

                $imageWidth = $watermark->width();

                if ($imageWidth >= 1000) {
                    $watermark->insert(public_path('watermark/watermarkLogo.png'), 'center-center', 10, 10);
                } else if ($imageWidth >= 500 && $imageWidth < 1000) {
                    $watermark->insert(public_path('watermark/watermarkLogo_small.png'), 'center-center', 10, 10);
                } else {
                    $watermark->insert(public_path('watermark/watermarkLogo_smaller.png'), 'center-center', 10, 10);
                }

                $watermark->save($image);
            }
        } else {
            Log::error("Invalid image path:  " . $image);
        }
        return true;
    }


    /**
     * Returns all items view
     */
    public function allItemsView()
    {

        $categories    = CategoryModel::where('soft_delete', 0)->get();
        $subCategories = SubCategoryModel::where('soft_delete', 0)->get();
        $brands        = BrandModel::where('soft_delete', 0)->get();
        $companies     = CarModel::where('soft_delete', 0)->get();
        $sections      = SectionModel::where('soft_delete', 0)->get();
        $data = [
            'subCategories' => $subCategories,
            'brands'        => $brands,
            'categories'    => $categories,
            'companies'     => $companies,
            'sections'      => $sections,
        ];

        return view('admin.item.allItemsView', $data);
    }

    /**
     * @param Request $request
     * @return mixed
     * @throws \Exception
     * Returns all items data for datatable display
     */
    public function listAllItems(Request $request)
    {

        $itemData = ItemModel::where(['soft_delete' => 0, 'is_outsourced' => 0])->with(['category', 'sub_category', 'brand'])->orderBy('updated_at', 'desc');
        if ($request->has('ispublic') && $request->ispublic !== null) {
            $itemData->where('is_published', $request->ispublic);
        }
        return Datatables::of($itemData)
            ->addColumn('data_category_name', function ($item) {
                return $item->category->name;
            })
            ->addColumn('data_subcategory_name', function ($item) {
                return $item->sub_category->name;
            })
            ->addColumn('data_brand_name', function ($item) {
                return $item->brand->name;
            })
            ->addColumn('data_image', function ($item) {
                return '<img src="' . $item->thumbnail . '" class="img-thumbnail productImg">';
            })
            ->addColumn('data_sales_type', function ($item) {
                return '<span class="badge badge-primary">' . $item->sales_type . '</span>';
            })
            ->addColumn('data_publication_status', function ($item) {
                if ($item->is_published == 1) {
                    return '<span class="badge badge-success">Published</span>';
                } else {
                    return '<span class="badge badge-danger">Pending</span>';
                }
            })
            // onclick="window.open('{{url('pendingOrderDetailsView',$order->id)}}');"
           ->addColumn('action', function ($item) {

    $buttons = '
        <button class="btn btn-info btn-xs" title="View"
            onclick="window.open(\'' . url('itemImageInfo/' . $item->id) . '\')">
            <i class="fa fa-info-circle"></i>
        </button>
    ';

    // Publish / Unpublish Button
    if ($item->is_published == 0) {
        $buttons .= '
            <button class="btn btn-primary btn-xs" title="Publish"
                onclick="itemPublishEdit(' . $item->id . ')">
                <i class="fa fa-check"></i>
            </button>
        ';
    } else {
        $buttons .= '
            <button class="btn btn-warning btn-xs" title="Unpublish"
                onclick="itemPublishEdit(' . $item->id . ')">
                <i class="fa fa-close"></i>
            </button>
        ';
    }

    $buttons .= '
        <button class="btn btn-primary btn-xs" title="Edit"
            onclick="itemEdit(' . $item->id . ')">
            <i class="fa fa-pencil"></i>
        </button>

        <button class="btn btn-danger btn-xs" title="Delete"
            onclick="itemDelete(' . $item->id . ')">
            <i class="fa fa-trash"></i>
        </button>

        <button class="btn btn-info btn-xs" title="Duplicate"
            onclick="window.open(\'' . url('itemDuplicate/' . $item->id) . '\')">
            <i class="fa fa-files-o"></i>
        </button>
    ';

    return $buttons;
})
            ->rawColumns(['action', 'data_category_name', 'data_subcategory_name', 'data_brand_name', 'data_image', 'data_sales_type', 'data_publication_status'])
            ->make(true);
    }


    public function itemDuplicate()
    {
        $categories    = CategoryModel::where('soft_delete', 0)->get();
        $subCategories = SubCategoryModel::where('soft_delete', 0)->get();
        $brands        = BrandModel::where('soft_delete', 0)->get();
        $sections      = SectionModel::where('soft_delete', 0)->get();
        $companies     = CarModel::where('soft_delete', 0)->get();

        $data = [
            'subCategories' => $subCategories,
            'brands'        => $brands,
            'categories'    => $categories,
            'sections'      => $sections,
            'companies'     => $companies
        ];
        return view('admin.item.itemDuplicate', $data);
    }



    /**
     * @name getItemInfoAjax
     * @role item info by id
     * @param
     * @return json
     *
     */

    public function getItemInfoAjax(Request $request)
    {

        $itemInfo = ItemModel::with(['itemSpecification', 'tags', 'checkModel'])->findOrFail($request->id);
        // dd($itemInfo);
        return response()->json($itemInfo);
    }

    /**
     * @name itemUpdateAjax
     * @role Item Update Ajax
     * @param Request from array
     * @return json response
     *
     */

    public function itemUpdateAjax(Request $request)
    {
        $itemInfo        = ItemModel::findOrFail($request->id);
        $userName        = Auth::user()->first_name;
        $defaultStatus   = 0;
        $tagList = explode(',', $request->tags);
        $tagList = array_unique($tagList);
        $resizedImage = null;

        if ($request->hasFile('thumbnail')) {
            $thumbnail                         = $request->file('thumbnail');
            $watermark                         = Image::make($thumbnail->getRealPath());
            $imageWidth = $watermark->width();

            if ($imageWidth >= 1000) {
                $watermark->insert(public_path('watermark/watermarkLogo.png'), 'center-center', 10, 10);
            } else if ($imageWidth >= 500 && $imageWidth < 1000) {
                $watermark->insert(public_path('watermark/watermarkLogo_small.png'), 'center-center', 10, 10);
            } else {
                $watermark->insert(public_path('watermark/watermarkLogo_smaller.png'), 'center-center', 10, 10);
            }
            $thumbnailName                     = $thumbnail->getClientOriginalName();
            $thumbnailFile                     = base64_encode($thumbnailName . rand(10, 1000000));
            $thumbnailExt                      = $thumbnail->getClientOriginalExtension();

            $watermarkFileName                 = $thumbnailFile . "." . $thumbnailExt;
            $thumbnail_path                    = 'itemImage/' . $watermarkFileName;
            $watermark->save($thumbnail_path);

            $thumbnailFileName                 = $thumbnailFile . "_original" . "." . $thumbnailExt;
            $original_thumbnail_path           = 'itemImage/' . $thumbnailFileName;
            $thumbnail->move('itemImage/', $thumbnailFileName);

            if (is_file(public_path() . "/" . $itemInfo->thumbnail)) {
                unlink($itemInfo->thumbnail);
            }
            if (is_file(public_path() . "/" . $itemInfo->resized_image)) {
                unlink($itemInfo->resized_image);
            }
            $imageWithExtension = explode('.', $itemInfo->thumbnail);
            $originalImage = $imageWithExtension[0] . "_original." . $imageWithExtension[1];

            if (is_file(public_path() . "/" . $originalImage)) {
                unlink($originalImage);
            }

            $resizedImage = $this->generateSmallImage($thumbnail_path);
        } else {
            $thumbnail_path =  $itemInfo->thumbnail;
        }

        //gettings attributes
        $attributeNames = array(
            'category_id'           => $request->category_id,
            'sub_category_id'       => $request->subcategory_id,
            'brand_id'              => $request->brand_id,
            'section_id'            => $request->section,
            'name'                  => $request->name,
            // 'barcode'               => $request->barcode,
            'length'                => $request->length,
            'height'                => $request->height,
            'width'                 => $request->width,
            'regular_price'         => $request->regular_price,
            'minimum_order_quantity' => $request->minimum_order_quantity,
            'sales_price'           => $request->sales_price,
            'minimum_price'         => $request->minimum_price,
            'thumbnail'             => $thumbnail_path,
            'details'               => $request->details,
            'sales_type'            => $request->sales_type,
            'is_published'          => $request->is_published,
            'updated_by'            => $userName,
            'soft_delete'           => $defaultStatus,
            'company'               => $request->company,
            'brand'                 => $request->brand,
            'model'                 => $request->model
        );

        //validating the attributes
        $validator = Validator::make($attributeNames, [
            'name'                  => 'required',
            'category_id'           => 'required',
            'sub_category_id'       => 'required',
            'brand_id'              => 'required',
            'section_id'            => 'required',
            // 'barcode'               => 'required',
            'minimum_order_quantity' => 'required',
            'thumbnail'             => 'required',
            'details'               => 'required',
            'sales_type'            => 'required',
            'is_published'          => 'required',
            'updated_by'            => 'required',
            'soft_delete'           => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        } else {
            DB::beginTransaction();
            try {
                $itemInfo->category_id           = $request->category_id;
                $itemInfo->sub_category_id       = $request->subcategory_id;
                $itemInfo->brand_id              = $request->brand_id;
                $itemInfo->section_id            = $request->section;
                $itemInfo->name                  = $request->name;
                // $itemInfo->barcode               = $request->barcode;
                $itemInfo->length                = $request->length;
                $itemInfo->height                = $request->height;
                $itemInfo->width                 = $request->width;
                $itemInfo->regular_price         = $request->regular_price;
                $itemInfo->minimum_order_quantity = $request->minimum_order_quantity;
                $itemInfo->sales_price           = $request->sales_price;
                $itemInfo->minimum_price         = $request->minimum_price;
                $itemInfo->thumbnail             = $thumbnail_path;
                $itemInfo->details               = $request->details;
                $itemInfo->sales_type            = $request->sales_type;
                $itemInfo->is_published          = $request->is_published;
                $itemInfo->updated_by            = $userName;
                $itemInfo->soft_delete           = $defaultStatus;
                $itemInfo->has_watermark         = 1;

                if ($resizedImage != null && $resizedImage != '') {
                    $itemInfo->resized_image         = $resizedImage;
                }

                if ($request->company) {
                    $itemInfo->car_company_id        = $request->company;
                }
                if ($request->brand) {
                    $itemInfo->car_brand_id          = $request->brand;
                }
                if ($request->model) {
                    $itemInfo->car_model_id          = $request->model;
                }

                $itemInfo->update();


                //update sales_price in purchase_details table
                $itemid = $request->id;
                if (PurchaseDetailsModel::where('item_id', $itemid)->where('soft_delete', 0)->exists()) {
                    $purchase_details = PurchaseDetailsModel::where('item_id', $itemid)->where('soft_delete', 0)->first();
                    $purchase_details->sales_price = $request->sales_price;
                    $purchase_details->update();
                }


                //update tag table
                Tags::where('item_id', $request->id)->delete();
                foreach ($tagList as $tag) {
                    $this->updateTag($request->id, $tag);
                }

                //update item specification table
                $this->deleteItemSpecification($request->id);
                if ($request->spec_name) {
                    for ($i = 0; $i < count($request->spec_name); $i++) {
                        $this->insertItemSpecification($request->id, $request->spec_name[$i], $request->spec_details[$i]);
                    }
                }

                //update car model pivot table
                $this->deleteMultiModel($request->id);
                if ($request->model_pivot != "null" && $request->model_pivot != null) {
                    $modelPivot = explode(",", $request->model_pivot);
                    foreach ($modelPivot as $pivot) {
                        ItemCarModelDetails::create(
                            [
                                'item_id'      =>  $request->id,
                                'car_model_id' =>  $pivot
                            ]
                        );
                    }
                }
                DB::commit();

                return response()->json("Item updated successfully");
            } catch (\Exception $exception) {
                DB::rollback();
                Log::error($exception->getMessage());
                return response()->json(array('dbErrors' => $exception->getMessage()));
            }
        }
    }




    /**
     * @name itemImageInfo
     * @role delete item  from  database
     * @param Request from array
     * @return json response
     *
     */

    public function itemImageInfo($id)
    {

        $itemImages = ItemPictureModel::where('item_id', $id)->where('soft_delete', 0)->get();
        $data = [
            'itemId'     => $id,
            'itemImages' => $itemImages
        ];

        return view('admin.item.itemImagesView', $data);
    }




    /**
     * @name itemDeleteAjax
     * @role delete item  from  database
     * @param Request from array
     * @return json response
     *
     */
    public function itemDeleteAjax(Request $request)
    {
        $item_id = $request->id;

        $is_purchased = (PurchaseDetailsModel::where('item_id', $item_id)->where('soft_delete', 0)->count() + PurchaseItemBarcode::where('item_id', $item_id)->where('soft_delete', 0)->count());
        if ($is_purchased > 0) {
            return response()->json([
                'data' => $item_id,
                'status' => false,
                'message' => 'Sorry,This Item has already been purchased.'
            ]);
        }

        DB::beginTransaction();
        try {
            //soft delete item
            ItemModel::findOrFail($item_id)->update(['soft_delete' => SOFT_DELETE_YES]);

            //soft delete item pictures
            $item_pictures = ItemPictureModel::where('item_id', $item_id)->get();
            foreach ($item_pictures as $picture) {
                $picture->update(['soft_delete' => SOFT_DELETE_YES]);
            }

            //delete tag table
            Tags::where('item_id', $item_id)->delete();

            //delete item specification
            $this->deleteItemSpecification($item_id);

            //update car model pivot table
            $this->deleteMultiModel($item_id);

            DB::commit();
            return response()->json([
                'data' => null,
                'status' => true,
                'message' => "Item deleted successfully"
            ]);
        } catch (\Exception $exception) {
            DB::rollBack();
            return response()->json([
                'data' => null,
                'status' => false,
                'message' => $exception->getMessage()
            ]);
        }
    }




    /**
     * @name itemImageUpdateAjax
     * @role  item  image Update;
     * @param Request from array
     * @return json response
     *
     */

    public function itemImageUpdateAjax(Request $request)
    {
        $userName        = Auth::user()->first_name;
        $itemImageInfo   = ItemPictureModel::findOrFail($request->item_image_id);

        $attributeNames = array(
            'image'                => $request->image,
        );


        //validating the attributes
        $validator = Validator::make($attributeNames, [
            'image'                  => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        } else {

            if ($request->hasFile('image')) {

                //Delete old files
                if (is_file(public_path() . "/" . $itemImageInfo->image_path)) {
                    unlink($itemImageInfo->image_path);
                }

                $imageWithExtension = explode('.', $itemImageInfo->image_path);
                $originalImage = $imageWithExtension[0] . "_original." . $imageWithExtension[1];

                if (is_file(public_path() . "/" . $originalImage)) {
                    unlink($originalImage);
                }


                $file                   = $request->file('image');
                $water                  = Image::make($file->getRealPath());

                $imageWidth = $water->width();

                if ($imageWidth >= 1000) {
                    $water->insert(public_path('watermark/watermarkLogo.png'), 'center-center', 10, 10);
                } else if ($imageWidth >= 500 && $imageWidth < 1000) {
                    $water->insert(public_path('watermark/watermarkLogo_small.png'), 'center-center', 10, 10);
                } else {
                    $water->insert(public_path('watermark/watermarkLogo_smaller.png'), 'center-center', 10, 10);
                }

                $name                   = $file->getClientOriginalName();
                $imageName              = base64_encode($name . rand(10, 1000000));
                $EXT                    = $file->getClientOriginalExtension();

                $waterImageName         = $imageName . "." . $EXT;
                $attachment_path        = 'itemImage/' . $waterImageName;
                $water->save($attachment_path);

                $imageFileName              = $imageName . "_original" . "." . $EXT;
                $original_attachment_path   = 'itemImage/' . $imageFileName;
                $file->move('itemImage/', $imageFileName);


                $itemImageInfo->image_path  = $attachment_path;
                $itemImageInfo->updated_by  = $userName;
                $itemImageInfo->update();
            }

            return response()->json("Success");
        }
    }




    /**
     * @name itemImageDeleteAjax
     * @role  item  image delete;
     * @param Request from array
     * @return json response
     *
     */

    public function itemImageDeleteAjax(Request $request)
    {
        $imageInfo = ItemPictureModel::findOrFail($request->id);
        // if (File::exists($imageInfo->image_path)) {
        //     unlink($imageInfo->image_path);
        // }
        // $imageInfo->delete();
        $deletedAttribute = 1;
        $attributeNames = array(
            'soft_delete' => $deletedAttribute
        );

        try {
            $imageInfo->update($attributeNames);
            return response()->json("Image deleted successfully");
        } catch (\Exception $exception) {
            return response()->json(array('errors' => $exception->getMessage()));
        }

        return response()->json('success');
    }




    /**
     * @name itemImageInsertAjax
     * @role  item  image insert;
     * @param Request from array
     * @return json response
     *
     */

    public function itemImageInsertAjax(Request $request)
    {
        $userName        = Auth::user()->first_name;

        $attributeNames = array(
            'item_id'              => $request->item_id,
            'image'                => $request->image
        );

        //validating the attributes
        $validator = Validator::make($attributeNames, [
            'item_id'                => 'required',
            'image'                  => 'required'
        ]);

        // if ($validator->fails()) {
        //     return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        // } else {
        //     if ($request->hasFile('image')) {

        //         $file = $request->file('image');
        //         $name = $file->getClientOriginalName();
        //         $EXT  = $file->getClientOriginalExtension();
        //         $imageFileName = base64_encode($name . rand(10, 1000000));
        //         $imageFileName = $imageFileName . "." . $EXT;
        //         $attachment_path = 'itemImage/' . $imageFileName;
        //         $file->move('itemImage/', $imageFileName);

        //         $image = new ItemPictureModel();
        //         $image->image_path  = $attachment_path;
        //         $image->item_id     = $request->item_id;
        //         $image->created_by  = $userName;
        //         $image->updated_by  = $userName;
        //         $image->save();
        //     }
        //     return response()->json("Success");
        // }

        if ($validator->fails()) {
            return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        } else {
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $water   = Image::make($file->getRealPath());
                $imageWidth = $water->width();

                if ($imageWidth >= 1000) {
                    $water->insert(public_path('watermark/watermarkLogo.png'), 'center-center', 10, 10);
                } else if ($imageWidth >= 500 && $imageWidth < 1000) {
                    $water->insert(public_path('watermark/watermarkLogo_small.png'), 'center-center', 10, 10);
                } else {
                    $water->insert(public_path('watermark/watermarkLogo_smaller.png'), 'center-center', 10, 10);
                }

                $name                   = $file->getClientOriginalName();
                $imageName              = base64_encode($name . rand(10, 1000000));
                $EXT                    = $file->getClientOriginalExtension();

                $waterImageName         = $imageName . "." . $EXT;
                $attachment_path        = 'itemImage/' . $waterImageName;
                $water->save($attachment_path);

                $imageFileName              = $imageName . "_original" . "." . $EXT;
                $original_attachment_path   = 'itemImage/' . $imageFileName;
                $file->move('itemImage/', $imageFileName);

                $itemImage              = new ItemPictureModel();
                $itemImage->item_id     = $request->item_id;
                $itemImage->image_path  = $attachment_path;
                $itemImage->created_by  = $userName;
                $itemImage->updated_by  = $userName;
                $itemImage->save();
            }
            return response()->json("Success");
        }
    }


    public function searchItemWithCat(Request $request)
    {
        $slug = $request->slug;
        $category_id = (int) $request->category_id;

        if ($category_id > 0) {
            $result = ItemModel::where("soft_delete", 0)
                ->where("name", "LIKE", "%$slug%")
                ->where("category_id", $category_id)
                ->get();
        } else {
            $result = ItemModel::where("soft_delete", 0)
                ->where("name", "LIKE", "%$slug%")
                ->get();
        }

        return response()->json($result, 200);
    }

    /**---------------------------------------
     *            Helper function
     * ---------------------------------------
     */
    public function insertTag($id, String $tag)
    {
        Tags::create([
            'item_id' => $id,
            'tag_text' => $tag,
            'soft_delete' => '0'
        ]);
    }


    public function updateTag($id, String $tag)
    {
        if ($tag != null && $tag != "") {
            Tags::create([
                'item_id' => $id,
                'tag_text' => $tag,
                'soft_delete' => '0'
            ]);
        }
    }

    /**
     * Deletes item tag
     */
    public function tagDelete(Request $request)
    {
        $tagData = Tags::where('id', $request->id)->select('id', 'tag_text')->first();

        $response = Tags::findOrFail($request->id)->delete();

        if ($response) {
            return response()->json([
                'status' => true,
                'message' => 'Tag successfully removed',
                'data' => $tagData
            ]);
        }

        return response()->json([
            'status' => false,
            'message' => 'Tag removing failed! Please try again',
            'data' => null
        ]);
    }

    public function insertItemSpecification($item_id, $name, $details)
    {
        ItemSpecification::create([
            'item_id' => $item_id,
            'name' => $name,
            'details' => $details,
        ]);
    }

    public function deleteItemSpecification($item_id)
    {
        //delete specs where item_id matches
        ItemSpecification::where('item_id', $item_id)->delete();
    }

    public function deleteMultiModel($item_id)
    {
        ItemCarModelDetails::where('item_id', $item_id)->delete();
    }

    public function ItemPublicationInfoChangeAjax(Request $request)
    {
        $itemInfo = ItemModel::findOrFail($request->id);
        $itemInfo->is_published = !$itemInfo->is_published;
        $itemInfo->save();

        if ($itemInfo->is_published) {
            return response()->json("Item published successfully");
        } else {
            return response()->json("Item unpublished successfully");
        }
    }
}
