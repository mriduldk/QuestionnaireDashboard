<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\CallLetterDownload;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Applicant;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;

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

        //dd($request->all());

        $user = Applicant::where('phone', $request->phone)->first();

        if ($user) {

            $user->otp = "1234";
            $user->otp_valid_upto = now()->addMinutes(10);
            $user->save();

            return redirect()->route('showCallLetterPage')->with('success', 'OTP Send Successfully')->with('showOtp', true)->with('phone', $request->phone);

        } else {
            return redirect()->route('showCallLetterPage')->with('error', 'User not found');
        }
    }

    public function validateJson(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $user = Applicant::where('phone', $request->phone)->first();

        if ($user) {
            $user->otp = "1234";
            $user->otp_valid_upto = now()->addMinutes(10);
            $user->save();

            return response()->json([
                'status' => true,
                'message' => 'OTP sent successfully',
                'phone' => $request->phone
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'User not found'
            ], 404);
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

        $user = Applicant::where('phone', $request->phone)->first();

        if ($user) {

            CallLetterDownload::create([
                'phone' => $request->phone,
                'ip_address' => request()->ip(),
                'post_name' => $user->post_name,
                'applicant_id' => $user->id
            ]);

            $pdf = Pdf::loadView('call_letter.callLetterPdf', compact('user'));
            //return $pdf->stream('call-letter.pdf');
            return $pdf->download('call-letter.pdf');

        } else {
            return redirect()->route('showCallLetterPage')->with('error', 'Unable to validate user. Please try again');
        }
    }



}
