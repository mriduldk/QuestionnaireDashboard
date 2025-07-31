<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Applicant;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class CallLetterController extends Controller
{
    public function showCallLetterPage()
    {
        return view('call_letter.call-letter');
    }

    public function validate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $user = Applicant::where('phone', $request->phone)->first();

        if ($user) {

            $user->otp = "1234";
            $user->otp_valid_upto = now()->addMinutes(10);
            $user->save();



            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://control.msg91.com/api/v5/widget/verifyAccessToken',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS =>'{
                  "authkey": "{Your MSG91 AuthKey}",
                  "access-token": "{jwt_token_from_otp_widget}"
                }',
                CURLOPT_HTTPHEADER => array(
                    'Content-Type: application/json',
                    'Accept: application/json',
                ),
            ));
            $response = curl_exec($curl);
            curl_close($curl);
            echo $response;


            return redirect()->route('showCallLetterPage')->with('success', 'OTP Send Successfully')->with('showOtp', true)->with('phone', $request->phone);

        } else {
            return redirect()->route('showCallLetterPage')->with('error', 'User not found');
        }
    }

    public function printPdf(Request $request) {

        $validator = Validator::make($request->all(), [
            'phone' => 'required|string|max:10',
            'otp' => 'required|string|max:4',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = Applicant::where('phone', $request->phone)->where('otp', $request->otp)->first();

        if ($user) {

            $pdf = Pdf::loadView('call_letter.callLetterPdf', compact('user'));
            return $pdf->stream('call-letter.pdf');

        } else {
            return redirect()->route('showCallLetterPage')->with('error', 'Unable to validate user. Please try again');
        }
    }



}
