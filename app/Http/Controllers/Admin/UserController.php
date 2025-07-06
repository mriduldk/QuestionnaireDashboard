<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Survey;
use App\Models\SurveyAnswer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    // GET /users
    public function index()
    {
        //$users = User::where('is_delete', false)->get();
        $users = User::where('is_delete', false)->with('survey')->get();
        return view('admin.users.index', compact('users'));
    }

    // GET /users/create
    public function create()
    {
        $surveys = Survey::pluck('title', 'id'); // or Survey::all() if you need more info
        return view('admin.users.create', compact('surveys'));
    }

    // POST /users
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'     => 'nullable|string|max:200',
            'email'    => 'nullable|email|max:200',
            'phone'    => 'nullable|digits:10',
            'survey_id' => 'required|exists:surveys,id',
            'is_active' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        User::create([
            'user_id'   => Str::uuid(),
            'name'      => $request->name,
            'email'     => $request->email,
            'phone'     => $request->phone,
            /*'password'  => Hash::make($request->password),*/
            'survey_id' => $request->survey_id,
            'is_active' => $request->has('is_active'),
            'is_delete' => false,
        ]);

        return redirect()->route('users.index')->with('success', 'User created successfully');
    }

    public function show($user_id)
    {
        $user = User::where('user_id', $user_id)->firstOrFail();

        // Get all survey answers by this user
        $surveyAnswers = SurveyAnswer::where('user_id', $user_id)
            ->latest()
            ->get();

        return view('admin.users.show', compact('user', 'surveyAnswers'));
    }


    // GET /users/{user}/edit
    public function edit($id)
    {
        $user = User::findOrFail($id);
        //return view('admin.users.edit', compact('user'));
        $surveys = Survey::pluck('title', 'id'); // or Survey::all() if needed
        return view('admin.users.edit', compact('user', 'surveys'));
    }

    // PUT /users/{user}
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name'     => 'nullable|string|max:200',
            'email'    => 'nullable|email|max:200',
            'phone'    => 'nullable|digits:10',
            /*'password' => 'nullable|string|min:6',*/
            'survey_id' => 'required|exists:surveys,id',
            'is_active' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user->name = $request->name ?? $user->name;
        $user->email = $request->email ?? $user->email;
        $user->phone = $request->phone ?? $user->phone;
        $user->survey_id = $request->survey_id;
        $user->is_active = $request->has('is_active');

        /*if ($request->password) {
            $user->password = Hash::make($request->password);
        }*/

        $user->save();

        return redirect()->route('users.index')->with('success', 'User updated successfully');
    }

    // DELETE /users/{user}
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->update(['is_delete' => true]);

        return redirect()->route('users.index')->with('success', 'User deleted successfully');
    }
}
