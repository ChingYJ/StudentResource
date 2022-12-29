<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    // public function __construct()
    // {
    //     $this->middleware('auth:api',['except'=>['register','login']]);
    // }

    public function register(Request $request)
    {
        $validateData = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'confirm_password' => 'required|same:password'
        ]);

        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();

        return response()->json(['msg'=>'Register Successfully']);
    }

    public function login(Request $request)
    {
        $validateData = $request->validate([
            'email' => 'required|email',
            'password'=> 'required'
        ]);

        if(!auth()->attempt($validateData)){
            return response(['msg'=>'Unauthorized']);
        }

        $token = auth()->user()->createToken('authToken')->accessToken;
        return response()->json(['user'=>auth()->user(),'tokenType'=>'Bearer','authToken'=>$token]);
    }

    public function logout(Request $request)
    {
        if(Auth::check()){
            $username = $request->user()->name;
            $user = $request->user()->token()->revoke();
            return response()->json(['user'=>$username,'msg'=>'Logout Successfully']);
        }else{
            return response()->json(['msg'=>'Error']);
        }
    }

    public function user(Request $request)
    {
        return response($request->user());
    }

}
