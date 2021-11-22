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
        $request->validate([
            'phone_num' => 'required'
        ]);
        $phoneNumber = $request->phone_num;
        $user = User::where('phone_number', '=', $phoneNumber)->first();
        if(!$user)
            {
              $register= User::create([
                'phone_number'=> $phoneNumber
              ]);
            } 
        $request->session()->put('phoneNum', $phoneNumber);
        $user = User::where('phone_number', '=', $phoneNumber)->first();
        $code = $user->sendVerificationCode($phoneNumber);
        return response()->json([
            'success' => true,
            'user' => $user,
            'code_session' => $code[1],
        ]);
  }

    function auth(Request $request)
    {
        $request->validate([
            'code' => 'required|max:6|min:6'
        ]);
        $code = $request->code;
        $phoneNum = $request->session()->get('phoneNum');
        // $phone_number = $request->phone_number;
        // $code_sent = $request->code_sent;
        $user = User::where('phone_number', '=', $phoneNum)->firstOrFail();
        if($user && $user->validateCode($code)) 
        {
            $authToken = $user->createToken('auth-token')->plainTextToken;
            return response()->json(['success' => true,
                                    'user' => $phoneNum,
                                    'access_token' => $authToken]);
        } 
        else 
        {
            return response()->json(['success' => false,
                                    'user' => $phoneNum]);
        }
    }
}
