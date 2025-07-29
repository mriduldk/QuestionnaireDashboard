<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Vcdc;
use App\Models\Block;
use Illuminate\Http\Request;

class VcdcController extends Controller
{
    public function index()
    {
        $vcdcs = Vcdc::with('block')->latest()->get();
        return view('admin.vcdcs.index', compact('vcdcs'));
    }

    public function create()
    {
        $blocks = Block::pluck('name', 'id');
        return view('admin.vcdcs.create', compact('blocks'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'block_id' => 'required|exists:blocks,id',
        ]);

        Vcdc::create($request->only('name', 'block_id'));

        return redirect()->route('vcdcs.index')->with('success', 'VCDC created successfully.');
    }

    public function edit(Vcdc $vcdc)
    {
        $blocks = Block::pluck('name', 'id');
        return view('admin.vcdcs.edit', compact('vcdc', 'blocks'));
    }

    public function update(Request $request, Vcdc $vcdc)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'block_id' => 'required|exists:blocks,id',
        ]);

        $vcdc->update($request->only('name', 'block_id'));

        return redirect()->route('vcdcs.index')->with('success', 'VCDC updated successfully.');
    }

    public function destroy(Vcdc $vcdc)
    {
        $vcdc->delete();
        return redirect()->route('vcdcs.index')->with('success', 'VCDC deleted successfully.');
    }
}
