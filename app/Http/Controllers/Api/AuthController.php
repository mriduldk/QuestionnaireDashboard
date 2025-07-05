<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class AuthController extends Controller
{
    public function checkUserPhoneNumber(Request $request)
    {

        $request->validate([
            /** @query */
            'phone' => 'required|string|max:10',
        ]);

        $user_exists = User::where('is_delete', 0)->where('phone', $request->phone)->first();

        if(empty($user_exists)){

            return ApiResponse::error('User Not Found', null, 403);
        }
        else{

            if($user_exists->is_active == 0){
                return ApiResponse::error('User is not active.', null, 403);
            }
            else{

                $user_exists->otp = '1234';
                $user_exists->otp_valid_upto = Carbon::now()->addMinutes(10)->toDateTimeString();

                $user_exists->save();

                return ApiResponse::success(200, "OTP sent to phone number", "user", $user_exists,);

            }
        }
    }

    public function otpVerify(Request $request)
    {
        $request->validate([
            /** @query */
            'phone' => 'required|string|max:10',
            /** @query */
            'otp' => 'required|string|min:4|max:4',
            /** @query */
            'fcm_token' => 'required|string',
        ]);

        $user = User::where('is_delete', 0)->where('phone', $request->phone)->first();

        if(empty($user)){
            return ApiResponse::error('User Not Found', null, 403);
        }
        else{

            if($user->is_active == 0){

                return ApiResponse::error('User is not active.', null, 403);
            }
            else{
                $user->is_active = 1;
                $user->fcm_token = $request->fcm_token;
                $user->save();

                return ApiResponse::success(200, "OTP verified successfully", "user", $user,);
            }
        }
    }

    public function logout()
    {
        Auth::logout();
        return response()->json([
            'message' => 'Successfully logged out',
        ]);
    }

    public function refresh()
    {
        return response()->json([
            'user' => Auth::user(),
            'authorisation' => [
                'token' => Auth::refresh(),
                'type' => 'bearer',
            ]
        ]);
    }

}
