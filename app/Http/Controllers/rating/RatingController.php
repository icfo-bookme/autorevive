<?php

namespace App\Http\Controllers\rating;

use DB;
use App\rating\RatingModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;


class RatingController extends Controller
{
    public function getItemRatingAjax(Request $request)
    {
        $item_id = $request->item_id;
        $ratings = RatingModel::where('soft_delete', 0)
                                ->where('item_id', $item_id)
                                ->get();
        return response()->json($ratings);
    }

    public function insertItemRatingAjax(Request $request)
    {  

       
        $attributeNames = array(
            'item_id'           => $request->item_id,
            'rating'            => $request->ratingValue,
            'review'            => $request->review,
            'name'              => $request->name,
            'email'             => $request->email,
            'soft_delete'       => 0
        );

        $validator = Validator::make($attributeNames, [
            'item_id'           => 'required',
            'rating'            => 'required',
            'review'            => 'required',
            'name'              => 'required',
            'email'             => 'required',

        ]);

        if ($validator->fails()) {
            return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        } else {
            RatingModel::create($attributeNames);
            DB::commit();

            
            return response()->json("Success");
        }
    }

    public function getAllItemRatingAjax(Request $request)
    {
        $allRatings = RatingModel::where('soft_delete', 0)->get();
        return response()->json($allRatings);
    }

    public function deleteItemRatingAjax(Request $request)
    {
        $id = $request->id;
        $itemRating = RatingModel::findOrFail($id);
        $attributeName = array(
            'soft_delete' => 1
        );

        try {
            $itemRating->update($attributeName);
            return response()->json("Deleted!");
        } catch (\Exception $exception) {
            return response()->json(array('errors' => $exception->getMessage()));
        }
    }

}
