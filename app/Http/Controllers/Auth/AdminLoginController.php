<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AdminLoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.admin-login');
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'identifier' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Identify the field type (email, phone, or username)
        $userQuery = Admin::query();

        if (filter_var($request->identifier, FILTER_VALIDATE_EMAIL)) {
            $userQuery->where('email', $request->identifier);
        } elseif (is_numeric($request->identifier)) {
            $userQuery->where('phone', $request->identifier);
        } else {
            $userQuery->where('username', $request->identifier);
        }

        $user = $userQuery->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return back()->with('error', 'Invalid credentials');
        }

        // Authenticate using the correct guard
        Auth::guard('admin')->login($user);

        // Redirect dynamically based on role
        return redirect()->route('admin.dashboard')->with('success', 'Login successful');

    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/adminLogin');
    }

}

