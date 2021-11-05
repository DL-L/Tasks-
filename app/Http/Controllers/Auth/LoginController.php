<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    function validate_num(Request $request)
    {
        $phoneNumber = $request->phone_num;

        $user = User::where('phone_number', '=', $phoneNumber)->first();
        if(!$user)
            {
              $register= User::create([
                'phone_number'=> $phoneNumber
              ]);
            } 
        Session::put('phoneNum', $phoneNumber);
        $user = User::where('phone_number', '=', $phoneNumber)->first();
        $user->sendVerificationCode($phoneNumber);
        return \Response::json(array('success' => true));
  }

    function auth(Request $request)
    {
        $code = $request->code;
        $phoneNum = Session::get('phoneNum');
        $user = User::where('phone_number', '=', $phoneNum)->firstOrFail();
        if($user && $user->validateCode($code)) 
        {
            return \Response::json(array('success' => true));
        } 
        else 
        {
            return \Response::json(array('success' => false));
        }
    }
}
