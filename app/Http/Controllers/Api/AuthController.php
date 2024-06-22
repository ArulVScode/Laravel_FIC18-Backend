<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    //UserRegister
    public function userRegister(Request $request) {

        $request->validate([

            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'phone' => 'required|string',
        ]);

        $data = $request->all();
        $data['password'] = Hash::make($data['password']);
        $data['roles'] = 'user';

        $user = User::create($data);

        return response()->json([

            'status' => 'success',
            'message' => 'User Registered Successfully',
            'data'=> $user

        ]);
    }

    // login
    public function login(Request $request) {

        $request->validate([

            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {

            return response()->json([

                'status' => 'failed',
                'message'=> 'Invalid Credentials'
            ]);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([

            'status' => 'success',
            'message' => 'User Logged In Successfully',
            'data' => [

                'user' => $user,
                'token' => $token
            ]
        ]);
    }

    // logout
    public function logout(Request $request) {

        $request->user()->currentAccessToken()->delete();

        return response()->json([

            'status' => 'success',
            'message' => 'User Logged Out Successfully',
        ]);
    }

    // RestaurantRegister
    public function restaurantRegister(Request $request) {

        $request->validate([

            'name' => 'required|string',
            'email'=> 'required|email|unique:users,email',  
            'password'=> 'required|string|min:6',
            'phone'=> 'required|string',
            'restaurant_name'=> 'required|string',
            'restaurant_address'=> 'required|string',
            'photo'=> 'required|image',
            'latlong'=> 'required|string',
        ]);

        $data = $request->all();
        $data['password'] = Hash::make($data['password']);
        $data['roles'] = 'restaurant';

        $user = User::create($data);

        // check if photo is uploaded
        if ($request->hasFile('photo')) {

            $photo = $request->file('photo');
            $photo_name = time(). '.'. $photo->getClientOriginalExtension();
            $photo->move(public_path('images'), $photo_name);
            $user->photo = $photo_name;
            $user->save();
        }

        return response()->json([

            'status' => 'success',
            'message' => 'Restaurant Registered Successfully',
            'data'=> $user
        ]);
    }

    // DriverRegister
    public function driverRegister(Request $request) {

        $request->validate([

            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'phone'=> 'required|string',
            'license_plate'=> 'required|string',
            'photo' => 'required|image',
        ]);

        $data = $request->all();
        $data['password'] = Hash::make($data['password']);
        $data['roles'] = 'driver';

        $user = User::create($data);

        // check if photo is uploaded
        if ($request->hasFile('photo')) {

            $photo = $request->file('photo');
            $photo_name = time(). '.'. $photo->getClientOriginalExtension();
            $photo->move(public_path('images'), $photo_name);
            $user->photo = $photo_name;
            $user->save();
        }

        return response()->json([

            'status' => 'success',
            'message' => 'Driver Registered Successfully',
            'data'=> $user
        ]);
    }

    // updateLatLong user
    public function updateLatLong(Request $request) {

        $request->validate([

            'latlong' => 'required|string',
        ]);

        $user = $request->user();
        $user->latlong = $request->latlong;
        $user->save();

        return response()->json([

            'status' => 'succsess',
            'message' => 'Latlong user successfuly updated',
            'data' => $user
        ]);
    }

    // get all restaurant
    public function getRestaurant() {

        $restaurant = User::where('roles', 'restaurant')->get();

        return response()->json([

            'status' => 'success',
            'message' => 'All Restaurant',
            'data'=> $restaurant
        ]);
    }
}
