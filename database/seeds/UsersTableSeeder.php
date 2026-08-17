<?php



use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('users')->insert([
            [
                'first_name' => 'John',
                'last_name' => 'Doe',
                'email' => 'john@example.com',
                'phone' => '01711111111',
                'address' => 'House 10, Road 5',
                'country' => 'Bangladesh',
                'district' => 'Dhaka',
                'city' => 'Dhaka',
                'thana' => 'Dhanmondi',
                'area' => 'Dhanmondi 27',
                'road_no' => '5',
                'house_no' => '10',
                'flat_no' => 'A-2',
                'NID' => '1234567890123',
                'email_verified_at' => Carbon::now(),
                'password' => Hash::make('12345678'),
                'plain_password' => '12345678',
                'remember_token' => Str::random(10),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}