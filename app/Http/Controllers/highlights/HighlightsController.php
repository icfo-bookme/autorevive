<?php

namespace App\Http\Controllers\highlights;

use App\Http\Controllers\Controller;
use App\highlights\HighlightsModel;
use Illuminate\Http\Request;

class HighlightsController extends Controller
{
    public function highlightsView(){

    $highlights = HighlightsModel::get();
        $data = [
            'highlights' => $highlights
        ];

        return view('admin.highlights.highlightsView',$data);
    }

    
    public function highlightsDelete(Request $request){

        $highlights_delete = HighlightsModel::findOrFail($request->id);
        $highlights_delete->delete();

        if ($highlights_delete) {
            return response()->json(["result" => "success"]);
        }
    }

}
