<?php

namespace App\Http\Controllers\complain;

use App\complain\Complain;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\delivery\deliveryTeamModel;

class ComplainController extends Controller
{
    public function compalin()
    {
        $deliveryTeam = deliveryTeamModel::where('soft_delete', 0)->get();
        $complains = Complain::where('soft_delete', 0)
                            ->where('created_by', Auth::user()->first_name)
                            ->with('deliveryTeam')
                            ->get();

        $data = [
            'complains'     => $complains,
            'deliveryTeam'  => $deliveryTeam
        ];

        return view('complain.complain', $data);
    }

    public function insertComplainAjax(Request $request)
    {
        Complain::create([
            'delivery_man_id'   => $request->id,
            'complain'          => $request->complain,
            'complain_detail'   => $request->complain_detail,
            'created_by'        => Auth::user()->first_name,
            'soft_delete'       => 0
        ]);

        return response()->json("Success", 200);
    }
}
