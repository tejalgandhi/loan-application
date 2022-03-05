<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Helper\Helper;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        try {
            $input = $request->all();
            $validator = Validator::make($request->all(), [
                'email' => 'required|email',
                'password' => 'required|min:6',
             ], [
                'email.required' => "Email is Required",
                'password.required' => "Password is Required",
            ]);
            if ($validator->fails()) {
                return Helper::returnresponse(401,$validator->messages()->first(),[]);
            }

            if (!Auth::attempt($input)) {
                return Helper::returnresponse(401,'Credentials not match',[]);
            }

            return Helper::returnresponse(200,'Login Successfully',[
                'token' => auth()->user()->createToken('API Token')->plainTextToken
            ]);
        } catch (\Exception $e) {
            return Helper::returnResponse(500,$e->getMessage(),[]);
        }
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();

        return [
            'message' => 'User Logout Successfully.'
        ];
    }

}