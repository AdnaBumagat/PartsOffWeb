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
    public function authenticate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->passes()) {

            if (Auth::attempt(['email' => $request->email, 'password' => $request->password], $request->get('remember'))) {

                // if(session()->has('url.intended')){
                //     return redirect(session()->get('url.intended'));
                // }

                return response()->json([
                    'message' => 'Login successful'
                ]);
            } else {
                //session()->flash('error','Either email/password is incorrect.');

                // return redirect()->route('account.login')
                //     ->withInput($request->only('email'))
                //     ->with('error', 'Either email/password is incorrect.');
                return response()->json([
                    'message' => 'Either email/password is incorrect.'
                ]);
            }
        } else {
            // return redirect()->route('account.login')
            //     ->withErrors($validator)
            //     ->withInput($request->only('email'));

            return response()->json([
                'message' => ''
            ]);
        }
    }

    //* Logout
    public function logout()
    {
        Auth::logout();
        return response()->json([
            'message' => 'Successfully logged out.'
        ]);
    }

    //* User Registration
    public function processRegister(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:5|confirmed'
        ]);

        if ($validator->passes()) {

            $user = new User;
            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->password = Hash::make($request->password);
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

    //* Change password
    public function changePassword(Request $request)
    {
        $valdidator = Validator::make($request->all(), [
            'old_password' => 'required',
            'new_password' => 'required|min:5',
            'confirm_password' => 'required|same:new_password'

        ]);
        if ($valdidator->passes()) {

            $user = User::select('id', 'password')->where('id', Auth::user()->id)->first();

            if (!Hash::check($request->old_password, $user->password)) {

                return response()->json([
                    'status' => true,
                ]);
            }

            User::where('id', $user->id)->update([
                'password' => Hash::make($request->new_password),
            ]);

            return response()->json([
                'status' => true,
            ]);
        } else {
            return response()->json([
                'status' => false,
                'errors' => $valdidator->errors()
            ]);
        }
    }
}
