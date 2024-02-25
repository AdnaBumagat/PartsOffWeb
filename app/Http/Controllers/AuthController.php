<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Province;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    public function login() {
        return view('front.account.login');
    }

    public function register() {
        return view('front.account.register');
    }

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

            session()->flash('success','You have been registered successfully.');

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

    public function authenticate(Request $request) {
        $validator = Validator::make($request->all(),[
            'email' => 'required|email' ,
            'password' => 'required' ,
        ]);

        if ($validator->passes()) {

            if(Auth::attempt(['email' => $request->email, 'password' => $request->password] , $request->get ('remember'))) {

                if(session()->has('url.intended')){
                    return redirect(session()->get('url.intended'));
                }

                return redirect()->route('account.profile');

            } else {
                //session()->flash('error','Either email/password is incorrect.');

            return redirect()->route('account.login')
                    ->withInput($request->only('email'))
                    ->with('error','Either email/password is incorrect.');
            }

        }   else {
            return redirect()->route('account.login')
            ->withErrors($validator)
            ->withInput($request->only('email'));
        }
    }

    public function profile() {

        $provinces =Province::orderBy('name','ASC')->get();

        $user = User::where('id',Auth::user()->id)->first();
        return view('front.account.profile',[
            'user'=> $user,
            'provinces' => $provinces
        ]);
    }

    public function updateProfile(Request $request) {
        $userId = Auth::user()->id;
        $validator = Validator::make($request->all(),[
            'name'=>'required',
            'email' => 'required|email|unique:users,email,'.$userId.',id',
            'phone'=> 'required'
        ]);

        if($validator->passes()) {
            $user = User::find($userId);
            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->save();

            session()->flash('success','profile Updated successfully');

            return response()->json([
                'status' => true,
                'message'=> 'profile Updated successfully'
            ]);
        
        }else
            return response()->json([
                'status' => false,
                'error'=> $validator->errors()
            ]);

    }

    public function logout() {
        Auth::logout();
        return redirect()->route('account.login')
        ->with('success', 'You successfully logged out.');
    }

    public function orders(){
        $data = [];
        $user =Auth::user();

        $orders = Order::where('user_id',$user->id)->orderBy('created_at','DESC')->get();

        $data['orders'] = $orders;
        return view('front.account.order',$data);
    }

    public function orderDetail($id) {
        $data = [];
        $user =Auth::user();
        $orders = Order::where('user_id',$user->id)->where('id',$id)->first();
        $data['order'] = $orders;
        
        $orderItems = OrderItem::where('order_id',$id)->get();
        $data['orderItems'] = $orderItems;

        $orderItemsCount = OrderItem::where('order_id',$id)->count();
        $data['orderItemsCount'] = $orderItemsCount;

        return view('front.account.order-detail',$data);
    }

    public function showchangePasswordForm(){
        return view('front.account.change-password');

    }

    public function changePassword(Request $request){
        $valdidator = Validator::make($request->all(), [
            'old_password' => 'required',
            'new_password' => 'required|min:5',
            'confirm_password' => 'required|same:new_password'

        ]);
        if($valdidator->passes()){

            $user = User::select('id','password')->where('id',Auth::user()->id)->first();

            if(!Hash::check($request->old_password, $user->password)){
                session()->flash('error','Your old password is incorrect, please write again.');
                
                return response()->json([
                    'status' =>true,
                ]);

            }

            User::where('id',$user->id)->update([
                'password' => Hash::make($request->new_password),
            ]);

            session()->flash('success','You have successfully change your password.');
                
                return response()->json([
                    'status' =>true,
                ]);

        }else{
            return response()->json([
                'status' =>false,
                'errors' =>$valdidator->errors()
            ]);
        }   
    }

}
