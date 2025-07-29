<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SubDivision;
use App\Models\District;
use Illuminate\Http\Request;

class SubDivisionController extends Controller
{
    public function index()
    {
        $subDivisions = SubDivision::with('district')->latest()->get();
        return view('admin.sub_divisions.index', compact('subDivisions'));
    }

    public function create()
    {
        $districts = District::pluck('name', 'id');
        return view('admin.sub_divisions.create', compact('districts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'district_id' => 'required|exists:districts,id',
        ]);

        SubDivision::create($request->only('name', 'district_id'));

        return redirect()->route('sub-divisions.index')->with('success', 'Sub-Division created successfully.');
    }

    public function edit(SubDivision $subDivision)
    {
        $districts = District::pluck('name', 'id');
        return view('admin.sub_divisions.edit', compact('subDivision', 'districts'));
    }

    public function update(Request $request, SubDivision $subDivision)
    {
        $request->validate([
            'name' => 'required|string',
            'district_id' => 'required|exists:districts,id',
        ]);

        $subDivision->update($request->only('name', 'district_id'));

        return redirect()->route('sub-divisions.index')->with('success', 'Sub-Division updated successfully.');
    }

    public function destroy(SubDivision $subDivision)
    {
        $subDivision->delete();
        return redirect()->route('sub-divisions.index')->with('success', 'Sub-Division deleted successfully.');
    }
}
