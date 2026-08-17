<?php

/**
 * @author Usama Mahmud
 * @date 04 January 2021
 * 
 * @edit(s):
 *          @edited_by:
 *          @edited_at:
 */

namespace App\Http\Controllers\delivery;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use App\User;
use App\admin\UserRolesModel;
use App\shipment\ShipmentModel;
use App\delivery\TeamLeader;
use App\OrderModel;
use App\admin\role\RoleModel;

class TeamLeaderController extends Controller
{
    const TEAM_LEADER_ROLE_ID = 5;

    /**
     * Get team leader's delivery history
     * @todo (1) assign right value in $teamLeaderRoleId
     * 
     * @author Usama Mahmud
     * @var view method
     * @param id (Request)
     * @return view with compact array
     */
	public function teamLeaderView()
	{
        // $teamLeaders = UserRolesModel::where('role_id', self::TEAM_LEADER_ROLE_ID)
        $teamLeaders = UserRolesModel::where('role_id', env('TEAMLEADER_ROLE'))
			->where('soft_delete', 0)
			->with('user')
            ->get();
        
        $roles = RoleModel::where('soft_delete', 0)->get();

		$data = [
            'teamLeaders'   => $teamLeaders,
            'roles'         => $roles,
            // 'role_id'       => self::TEAM_LEADER_ROLE_ID,
            'role_id'       => env('TEAMLEADER_ROLE'),
		];
		return view('admin.deliveryTeam.teamLeaderView', $data);
    }


    /**
     * Fetch information from the User's table
     * 
     * @author Usama Mahmud
     * @param id (Request)
     * @return JSON Detail | Error
     */
    public function getTeamLeaderDetails(Request $request)
    {
        // $memberInfo = deliveryTeamModel::findOrFail($request->id);
        $memberInfo = User::with('roles')->findOrFail($request->id);
        // $memberInfo = User::where('id', $request->id)->with('roles')->get();
        return response()->json($memberInfo);
    }


    /**
     * Insert Team Leader with details
     * @todo Which table (users | team_leaders) to inset the data? 
     *       Inserting in the "team_leaders" table for now.
     * 
     * @author Usama Mahmud
     * @var view method
     * @param Request $request [name, contact_number, alt_contact_number, address, (file) NID]
     * @return JSON 'Success' | Error
     */
	public function teamLeaderInsertAjax(Request $request)
	{
        // gettings attributes
        $attributeNames = [
            'name'                  => $request->name,
            'contact_number'        => $request->contact_number,
            'alt_contact_number'    => $request->alt_contact_number,
            'address'               => $request->address,
            'NID'                   => $request->NID,
            'created_by'            => Auth::user()->first_name,
        ];

        // validating the attributes
        $validator = Validator::make($attributeNames, [
            'name'                  => 'required',
            'contact_number'        => 'required',
            'alt_contact_number'    => 'required',
            'address'               => 'required',
            'NID'                   => 'required',
        ]);

		if ($validator->fails()) {
			return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
		} else {
            // upload file
			if ($request->hasFile('NID')) {
				$thumbnail                         = $request->file('NID');
				$thumbnailName                     = $thumbnail->getClientOriginalName();
				$thumbnailExt                      = $thumbnail->getClientOriginalExtension();
				$thumbnailFileName                 = base64_encode($thumbnailName . rand(10, 1000000));
				$thumbnailFileName                 = $thumbnailFileName . "." . $thumbnailExt;
				$thumbnail_path                    = 'img/NID/' . $thumbnailFileName;
				$thumbnail->move('img/NID/', $thumbnailFileName);
				$attributeNames['NID']             = $thumbnail_path;
			}

            TeamLeader::create($attributeNames);

			return response()->json("Success");
		}
	}


    /**
     * Update Team Leader's details
     * 
     * @author Usama Mahmud
     * @var view method
     * @param Request $request [name, contact_number, alt_contact_number, address, (file) NID]
     * @return JSON 'Success' | Error
     */
	public function teamLeaderUpdateAjax(Request $request)
	{
		$teamInfo = User::findOrFail($request->id);

        // gettings attributes
        $attributeNames = [
            "first_name" => $request->first_name,
            "last_name" => $request->last_name,
            "email" => $request->email,
            "phone" => $request->phone,
            "country" => $request->country,
            "district" => $request->district,
            "city" => $request->city,
            "thana" => $request->thana,
            "area" => $request->area,
            "road_no" => $request->road_no,
            "house_no" => $request->house_no,
            "flat_no" => $request->flat_no,
        ];

		// validating the attributes
		$validator = Validator::make($attributeNames, [
            "first_name" => 'required',
            "last_name" => 'required',
            "email" => 'required',
            "phone" => 'required',
            "country" => 'required',
            "district" => 'required',
            "city" => 'required',
            "thana" => 'required',
            "area" => 'required',
            "road_no" => 'required',
            "house_no" => 'required',
            "flat_no" => 'required',
		]);

		if ($validator->fails()) {
			return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
		} else {
            // if file attatched to upload
            if ($request->hasFile('NID')) {
                $thumbnail                         = $request->file('NID');
                $thumbnailName                     = $thumbnail->getClientOriginalName();
                $thumbnailExt                      = $thumbnail->getClientOriginalExtension();
                $thumbnailFileName                 = base64_encode($thumbnailName . rand(10, 1000000));
                $thumbnailFileName                 = $thumbnailFileName . "." . $thumbnailExt;
                $thumbnail_path                    = 'img/NID/' . $thumbnailFileName;
                $thumbnail->move($thumbnail_path);

                // remove previous NID image if exists
                if (File::exists($teamInfo->NID)) {
                    unlink($teamInfo->NID);
                }
            } else {
                $thumbnail_path =  $teamInfo->NID;
            }

            $teamInfo->update($attributeNames);

            // change user role
            UserRolesModel::where('user_id', $request->id)
                        // ->where('role_id', self::TEAM_LEADER_ROLE_ID)
                        ->where('role_id', env('TEAMLEADER_ROLE'))
                        ->latest()
                        ->first()
                        ->update([
                            'role_id' => $request->role_id
                        ]);

			return response()->json("Success");
		}
	}


    /**
     * delete team leader from User table
     * 
     * @author Usama Mahmud
     * @var delete a team leader
     * @param id (Request)
     * @return json "Success" | Error
     */
	public function teamLeaderDeleteAjax(Request $request)
	{
		$user = User::findOrFail($request->id);
		$user->delete();
		return response()->json('Success');
	}


    /**
     * get team leader's delivery history
     * 
     * @author Usama Mahmud
     * @var view method
     * @param id (Request) Team Leader's ID
     * @return view with compact array
     */
	public function getTeamLeaderDeliveryHistoryAjax(Request $request)
	{
        $deliveryHistory = OrderModel::where('soft_delete', 0)
                                        ->where('team_leader_id', $request->id)
                                        ->with('shipment')
                                        ->get();

		return response()->json($deliveryHistory, 200);
	}
}
