<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CallLetterController extends Controller
{
    public function showCallLetterPage()
    {
        return view('call_letter.call-letter');
    }

    
    public function printPdf(Request $request) {

        $validator = Validator::make($request->all(), [
            'phone' => 'required|string|max:10',
            'dob' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = User::where('phone', $request->phone)->first();
        $pdf = Pdf::loadView('call_letter.callLetterPdf', compact('user'));
        return $pdf->stream('call-letter.pdf');
    }



}
