<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthApiController extends Controller
{

    //* Login function
    public function login(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if ($validator->passes()) {

            if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' =>
            $request->password], $request->get('remember'))) {

                $admin = Auth::guard('admin')->user();

                if ($admin->role == 2) {
                    return response()->json([
                        'message' => 'admin login successful'
                    ]);
                } else {
                    return response()->json([
                        'message' => 'You are not authorized to access to acess admin panel'
                    ]);
                }

            } else {
                return response()->json([
                    'message' => 'Email or password is incorrect.'
                ]);
            }

        } else {
            return response()->json([
                'errors' => $validator->errors()
            ]);
        }
    }

    //* Logout
    public function logout() {
        Auth::logout();
        return response()->json([
            'message' => 'Successfully logged out.'
        ]);
    }

    //* User Registration
    public function processRegister(Request $request){

        $validator = Validator::make($request->all(),[
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:5|confirmed'
        ]);

        if ($validator->passes()) {

            $user = new User;
            $user -> name = $request->name;
            $user -> email = $request->email;
            $user -> phone = $request->phone;
            $user -> password = Hash::make($request->password);
            $user->save();

            return response()->json([
                'status' => true,
            ]);

        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }
}
