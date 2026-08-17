<?php

namespace App\Http\Controllers\delivery;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use App\User;
use App\admin\UserRolesModel;
use App\shipment\ShipmentModel;
use App\delivery\deliveryTeamModel;

class deliveryController extends Controller
{
	/**
	 * @name deliveryTeamViw
	 * @role All delivery team list view
	 * @param
	 * @return view with compact array
	 *
	 */


	public function deliveryTeamView()
	{
		// $deliveryTeamRoleId = 3; // more dynamic approach is needed
		// $deliveryTeam = UserRolesModel::where('role_id', $deliveryTeamRoleId)
		$deliveryTeam = UserRolesModel::where('role_id', env('DELIVERYMAN_ROLE'))
			->where('soft_delete', 0)
			->with('user')
			->get(); // FIX IN VIEW
		// $newdeliverymen = deliveryTeamModel::get();
		$data = [
			'deliveryTeam' 		=> $deliveryTeam


		];
		return view('admin.deliveryTeam.deliveryTeamView', $data);
	}


	/**
	 * @name deliveryTeamInsertAjax
	 * @role insert team by ajax
	 * @param
	 * @return view with compact array
	 *
	 */

	public function deliveryTeamInsertAjax(Request $request)
	{

		$userName = Auth::user()->first_name;
		// $deliveryManRoleId = 3;
		$defaultStatus = 0;
		//gettings attributes
		$attributeNames = array(
			'name'                      => $request->name,
			'contact_number'            => $request->contact_number,
			'alt_contact_number'        => $request->alt_contact_number,
			'address'                   => $request->address,
			'NID'                       => $request->file('NID'),
			// 'role_id'                	=> $deliveryManRoleId,
			'role_id'                	=> env('DELIVERYMAN_ROLE'),
			'created_by'                => $userName,
			'updated_by'                => $userName,
			'soft_delete'               => $defaultStatus

		);



		//return dd($attributeNames);

		//validating the attributes
		$validator = Validator::make($attributeNames, [
			'name'                      => 'required',
			'contact_number'            => 'required',
			'address'                   => 'required',
			'NID'                       => 'required',
		]);

		if ($validator->fails()) {
			return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
		} else {

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

			deliveryTeamModel::create($attributeNames);
			return response()->json("Success");
		}
	}



	/**
	 * @name getMemberDetails
	 * @role get member details by ajax
	 * @param
	 * @return view with compact array
	 *
	 */


	public function getMemberDetails(Request $request)
	{
		// $memberInfo = deliveryTeamModel::findOrFail($request->id);
		$memberInfo = User::findOrFail($request->id);
		return response()->json($memberInfo);
	}


	public function unusedNidRemove()
	{
		try{
			$files = File::files(public_path()."/"."img/NID");
			$t = 0;
			$count = 0;
			foreach ($files as $file){
				$basename = pathinfo($file)['basename'];
				$b_name = "img/NID/".$basename;
				$nid = User::where('NID',$b_name)->first();
				if ($nid !== null) {
					$count++;
				}else{
					unlink($b_name);
					$t++;
				}
			}

			return json_encode([
				'status'	=> true,
				'message'	=> "successfull",
				'data'		=> [
					'NID_exists' => $count,
					'NID_deleted' => $t
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
	 * @name deliveryTeamUpdateAjax
	 * @role get member details update by ajax
	 * @param
	 * @return view with compact array
	 *
	 */

	public function deliveryTeamUpdateAjax(Request $request)
	{

		$teamInfo = User::findOrFail($request->id);

		if ($request->hasFile('NID')) {
			$thumbnail                         = $request->file('NID');
			$thumbnailName                     = $thumbnail->getClientOriginalName();
			$thumbnailExt                      = $thumbnail->getClientOriginalExtension();
			$thumbnailFileName                 = base64_encode($thumbnailName . rand(10, 1000000));
			$thumbnailFileName                 = $thumbnailFileName . "." . $thumbnailExt;

            $basePath = base_path() . '/public/';
            $targetRealPath = $basePath . 'img/NID/';
            if (!File::isDirectory($targetRealPath))
                File::makeDirectory($targetRealPath, 0755, true, true);

			$thumbnail_path                   = 'img/NID/' . $thumbnailFileName;
			$thumbnail->move('img/NID/', $thumbnailFileName);

			if (File::exists($teamInfo->NID)) {
				unlink($teamInfo->NID);
			}
		} else {
			$thumbnail_path =  $teamInfo->NID;
		}

		$userName = Auth::user()->first_name;
		$defaultStatus = 0;
		//gettings attributes
		$attributeNames = array(
			'id'			=> $request->team_id,
			'first_name'	=> $request->first_name,
			'last_name'		=> $request->last_name,
			'email'		=> $request->email,
			'phone'		=> $request->phone,
			'country'	=> $request->country,
			'district'	=> $request->district,
			'city'		=> $request->city,
			'thana'		=> $request->thana,
			'area'		=> $request->area,
			'road_no'	=> $request->road_no,
			'house_no'	=> $request->house_no,
			'flat_no'	=> $request->flat_no,
			'NID'       => $thumbnail_path,
			// 'name'                   => $request->name,
			// 'contact_number'         => $request->contact_number,
			// // 'alt_contact_number'  => $request->alt_contact_number,
			// 'address'                => $request->address,
			// // 'updated_by'          => $userName,
			// 'soft_delete'            => $defaultStatus
		);

		//validating the attributes
		$validator = Validator::make($attributeNames, [
			// 'name'                  => 'required',
			// 'contact_number'        => 'required',
			// // 'alt_contact_number' => 'required',
			// // 'address'            => 'required',
			'NID'           => 'required',
			'first_name'	=> 'required', // min + max
			'last_name'		=> 'required', // min + max
			'email'		=> 'required', // email
			'phone'		=> 'required',
			'country'	=> 'required',
			'district'	=> 'required',
			'city'		=> 'required',
			'thana'		=> 'required',
			'area'		=> 'required',
			'road_no'	=> 'required',
			'house_no'	=> 'required',
			'flat_no'	=> 'required',
		]);

		if ($validator->fails()) {
			return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
		} else {
			$teamInfo->update($attributeNames);
			return response()->json("Success");
		}
	}


	/**
	 * @name deliveryTeamDeleteAjax
	 * @role get member delete by ajax
	 * @param
	 * @return view with compact array
	 *
	 */

	public function deliveryTeamDeleteAjax(Request $request)
	{
		// $teamInfo = deliveryTeamModel::findOrFail($request->id);
		// $teamInfo->soft_delete = 1;
		// $teamInfo->update();
		$user = User::findOrFail($request->id);
		$user->delete();
		return response()->json('Success');
	}

	/**
	 * getTeamsDeliveryHistoryAjax
	 *
	 * @param Request User's ID
	 * @return JSON
	 *
	 */

	public function getTeamsDeliveryHistoryAjax(Request $request)
	{
		$id = $request->id;
		$deliveryHistory = ShipmentModel::where('soft_delete', 0)
					->where('delivery_team_id', $id)
					->with('user')
					->with('orderReport')
					->get();

		return response()->json($deliveryHistory, 200);
	}
}
