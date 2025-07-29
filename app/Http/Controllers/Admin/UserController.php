<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Block;
use App\Models\District;
use App\Models\SubDivision;
use App\Models\Survey;
use App\Models\SurveyAnswer;
use App\Models\User;
use App\Models\Vcdc;
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

        $districts = District::pluck('name', 'id');
        return view('admin.users.create', compact('surveys', 'districts'));
        //return view('admin.users.create', compact('surveys'));
    }

    // POST /users
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'     => 'nullable|string|max:200',
            'email'    => 'nullable|email|max:200',
            'phone'    => 'nullable|digits:10',
            'survey_id' => 'required|exists:surveys,id',

            'father_name' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'village' => 'nullable|string|max:255',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',

            'district_id' => 'required|string|max:255',
            'sub_division_id' => 'required|string|max:255',
            'block_id' => 'required|string|max:255',
            'vcdc_id' => 'required|string|max:255',

            'is_active' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('users/photos', 'public');
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

            'father_name' => $request->father_name,
            'address' => $request->address,
            'village' => $request->village,
            'photo' => $photoPath,

            'district' => $request->district_id,
            'sub_division' => $request->sub_division_id,
            'block' => $request->block_id,
            'vcdc' => $request->vcdc_id,
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
    public function edit(User $user)
    {
        /*$user = User::findOrFail($id);
        $surveys = Survey::pluck('title', 'id');
        return view('admin.users.edit', compact('user', 'surveys'));*/

        $surveys = Survey::pluck('title', 'id');
        $districts = District::pluck('name', 'id');
        $subDivisions = SubDivision::where('district_id', $user->district_id)->pluck('name', 'id');
        $blocks = Block::where('sub_division_id', $user->sub_division_id)->pluck('name', 'id');
        $vcdcs = Vcdc::where('block_id', $user->block_id)->pluck('name', 'id');

        return view('admin.users.edit', compact('user', 'surveys', 'districts', 'subDivisions', 'blocks', 'vcdcs'));

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

            'father_name' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'village' => 'nullable|string|max:255',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',

            'district_id' => 'required|string|max:255',
            'sub_division_id' => 'required|string|max:255',
            'block_id' => 'required|string|max:255',
            'vcdc_id' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('users/photos', 'public');
            $user->photo = $photoPath;
        }

        $user->name = $request->name ?? $user->name;
        $user->email = $request->email ?? $user->email;
        $user->phone = $request->phone ?? $user->phone;
        $user->survey_id = $request->survey_id;
        $user->is_active = $request->has('is_active');

        $user->father_name = $request->father_name;
        $user->address = $request->address;
        $user->village = $request->village;

        $user->district = $request->district_id;
        $user->sub_division = $request->sub_division_id;
        $user->block = $request->block_id;
        $user->vcdc = $request->vcdc_id;

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
