<?php

namespace App\Http\Controllers\Auth;

use DB;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\admin\UserRolesModel;
use App\customer\CustomerModel;
use App\welcomeCall\WelcomeCallModel;
use Illuminate\Support\Facades\Log;



class RegisterController extends Controller
{
    //Demo comment
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default, this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */

    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'first_name'    => ['required', 'string', 'max:255'],
            'last_name'     => ['required', 'string', 'max:255'],
            'email'         => ['string', 'email','unique:users', 'max:255'],
            // 'phone'         => ['required|regex:/(01)[0-9]{9}/','unique:users'],
            'phone'         => ['required', 'regex:/(01)[0-9]{9}/', 'unique:users'],
            'address'       => ['required'],
            'password'      => ['required', 'string', 'min:8', 'confirmed'],
            'country'       => ['required', 'min:3', 'max:255'],
            'district'      => ['required', 'min:3', 'max:255'],
            'city'          => ['required', 'min:3', 'max:255'],
            'thana'         => ['required', 'min:3', 'max:255'],
            'area'          => ['required', 'max:512'],
            'road_no'       => ['required', 'max:255'],
            'house_no'      => ['required', 'max:255'],
            'flat_no'       => ['required', 'max:255'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */

    protected function create(array $data)
    {
        DB::beginTransaction();

        try {
            $user =  User::create([
                'first_name'    => $data['first_name'],
                'last_name'     => $data['last_name'],
                'email'         => $data['email'],
                'phone'         => $data['phone'],
                'address'       => $data['address'],
                'password'      => Hash::make($data['password']),
                'plain_password'      => $data['password'],
                'country'       => $data['country'],
                'district'      => $data['district'],
                'city'          => $data['city'],
                'thana'         => $data['thana'],
                'area'          => $data['area'],
                'road_no'       => $data['road_no'],
                'house_no'      => $data['house_no'],
                'flat_no'       => $data['flat_no'],
            ]);

            UserRolesModel::create(
                [
                    'user_id'       => $user->id,
                    'role_id'       => 2,
                    'created_by'    => 'system',
                    'soft_delete'   => 0
                ]
            );


            /* INSERT INTO customers TABLE AS NEW CUSTOMER */

            $customerMailPhoneExists = CustomerModel::where('phone', '=', $data['phone'])->first();

            if ($customerMailPhoneExists === null) {

                $newCustomer = new CustomerModel();
                $newCustomer->first_name    = $data['first_name'];
                $newCustomer->last_name     = $data['last_name'];
                $newCustomer->email         = $data['email'];
                $newCustomer->phone         = $data['phone'];
                $newCustomer->country       = $data['country'];
                $newCustomer->district      = $data['district'];
                $newCustomer->city          = $data['city'];
                $newCustomer->thana         = $data['thana'];
                $newCustomer->area          = $data['area'];
                $newCustomer->road_no       = $data['road_no'];
                $newCustomer->house_no      = $data['house_no'];
                $newCustomer->flat_no       = $data['flat_no'];
                $newCustomer->car_no        = $data['car_no'];
                $newCustomer->address       = $data["address"];
                $newCustomer->created_by    = "website";
                $newCustomer->updated_by    = "website";
                $newCustomer->save();

                WelcomeCallModel::create([
                    'customer_id'	=>	$newCustomer->id
                ]);

            }

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollback();
            Log::error($th->getMessage());
            return abort(500, 'Unexpected error occured.');
        }

        return $user;
    }
}
