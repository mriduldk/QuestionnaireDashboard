<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


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
            'fcm_token' => 'nullable|string',
        ]);

        $user = User::where('is_delete', 0)
            ->where('phone', $request->phone)
            ->with(['districtInfo', 'subDivisionInfo', 'blockInfo', 'vcdcInfo'])
            ->first();

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

                // Convert model to array and replace district ID with name
                $data = $user->toArray();
                $data['district'] = $user->districtInfo->name ?? null;
                $data['sub_division'] = $user->subDivisionInfo->name ?? null;
                /*$data['block'] = $user->blockInfo->name ?? null;*/
                $data['vcdc'] = $user->vcdcInfo->name ?? null;

                return ApiResponse::success(200, "OTP verified successfully", "user", $data,);
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

    public function storeProfileImage(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'image' => 'required|image|max:2048'
        ]);


        $user = User::where('is_delete', 0)
            ->where('user_id', $request->user_id)
            ->with(['districtInfo', 'subDivisionInfo', 'blockInfo', 'vcdcInfo'])
            ->first();

        if(empty($user)){
            return ApiResponse::error('User Not Found', null, 403);
        }
        else{

            if($user->is_active == 0){

                return ApiResponse::error('User is not active.', null, 403);
            }
            else{

                $path = $request->file('image')->store('users/photos', 'public');

                $user->photo = Storage::url($path);
                $user->save();

                $data = $user->toArray();
                $data['district'] = $user->districtInfo->name ?? null;
                $data['sub_division'] = $user->subDivisionInfo->name ?? null;
                /*$data['block'] = $user->blockInfo->name ?? null;*/
                $data['vcdc'] = $user->vcdcInfo->name ?? null;

                return ApiResponse::success(200, "Image Uploaded Successfully", "user", $data);
            }
        }
    }

    public function updateSubDivisionAndBlock(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'block' => 'required',
            'village' => 'required',
            'address' => 'required'
        ]);


        $user = User::where('is_delete', 0)
            ->where('user_id', $request->user_id)
            ->first();

        if(empty($user)){
            return ApiResponse::error('User Not Found', null, 403);
        }
        else{

            if($user->is_active == 0){

                return ApiResponse::error('User is not active.', null, 403);
            }
            else{

                $user->block = $request->block;
                $user->village = $request->village;
                $user->address = $request->address;
                $user->save();


                $data = $user->toArray();
                $data['district'] = $user->districtInfo->name ?? null;
                $data['sub_division'] = $user->subDivisionInfo->name ?? null;
                $data['vcdc'] = $user->vcdcInfo->name ?? null;

                return ApiResponse::success(200, "Updated Successfully", "user", $data);
            }
        }
    }


    public function getByUserId(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
        ]);

        $user = User::where('is_delete', 0)
            ->where('user_id', $request->user_id)
            ->first();

        if(empty($user)){
            return ApiResponse::error('User Not Found', null, 403);
        }
        else{
            if($user->is_active == 0){
                return ApiResponse::error('User is not active.', null, 403);
            }
            else{

                $data = $user->toArray();
                $data['district'] = $user->districtInfo->name ?? null;
                $data['sub_division'] = $user->subDivisionInfo->name ?? null;
                $data['vcdc'] = $user->vcdcInfo->name ?? null;

                return ApiResponse::success(200, "Updated Successfully", "user", $data);

            }
        }
    }


    public function updateUserLanguage(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'language' => 'required',
        ]);


        $user = User::where('is_delete', 0)
            ->where('user_id', $request->user_id)
            ->first();

        if(empty($user)){
            return ApiResponse::error('User Not Found', null, 403);
        }
        else{

            if($user->is_active == 0){

                return ApiResponse::error('User is not active.', null, 403);
            }
            else{

                $user->password = $request->language;
                $user->save();

                return ApiResponse::success(200, "Updated Successfully", "user", $user);
            }
        }
    }



}

