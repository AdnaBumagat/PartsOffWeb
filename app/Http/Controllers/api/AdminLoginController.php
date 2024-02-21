<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminLoginController extends Controller
{
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
                    // Auth::guard('admin')->logout();
                    // return redirect()->route('admin.login')->with('error', 'You are not authorized to access to acess admin panel');
                    return response()->json([
                        'message' => 'You are not authorized to access to acess admin panel'
                    ]);
                }

        //         return redirect()->route('admin.dashboard');
        //     } else {
        //         return redirect()->route('admin.login')->with('error', 'Either Email/Password is incorrect');
            }
        } else {
            return response()->json([
                'errors' => $validator->errors()
            ]);
        }
    }
}
