<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\District;
use App\Models\Vcdc;
use Illuminate\Http\Request;

class VcdcController extends Controller
{
    public function index()
    {
        //$vcdcs = Vcdc::with('block')->latest()->get();
        $vcdcs = Vcdc::with('district')->latest()->get();
        return view('admin.vcdcs.index', compact('vcdcs'));
    }

    public function create()
    {
        //$blocks = Block::pluck('name', 'id');
        $districts = District::pluck('name', 'id');
        return view('admin.vcdcs.create', compact('districts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'district_id' => 'required|exists:districts,id',
        ]);

        Vcdc::create($request->only('name', 'district_id'));

        return redirect()->route('vcdcs.index')->with('success', 'VCDC created successfully.');
    }

    public function edit(Vcdc $vcdc)
    {
        //$blocks = Block::pluck('name', 'id');
        $districts = District::pluck('name', 'id');
        return view('admin.vcdcs.edit', compact('vcdc', 'districts'));
    }

    public function update(Request $request, Vcdc $vcdc)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'district_id' => 'required|exists:districts,id',
        ]);

        $vcdc->update($request->only('name', 'district_id'));

        return redirect()->route('vcdcs.index')->with('success', 'VCDC updated successfully.');
    }

    public function destroy(Vcdc $vcdc)
    {
        $vcdc->delete();
        return redirect()->route('vcdcs.index')->with('success', 'VCDC deleted successfully.');
    }
}
