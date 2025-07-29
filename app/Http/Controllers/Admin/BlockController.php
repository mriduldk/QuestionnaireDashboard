<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Block;
use App\Models\SubDivision;
use Illuminate\Http\Request;

class BlockController extends Controller
{
    public function index()
    {
        $blocks = Block::with('subDivision')->latest()->get();
        return view('admin.blocks.index', compact('blocks'));
    }

    public function create()
    {
        $subDivisions = SubDivision::pluck('name', 'id');
        return view('admin.blocks.create', compact('subDivisions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'sub_division_id' => 'required|exists:sub_divisions,id',
        ]);

        Block::create($request->only('name', 'sub_division_id'));

        return redirect()->route('blocks.index')->with('success', 'Block created successfully.');
    }

    public function edit(Block $block)
    {
        $subDivisions = SubDivision::pluck('name', 'id');
        return view('admin.blocks.edit', compact('block', 'subDivisions'));
    }

    public function update(Request $request, Block $block)
    {
        $request->validate([
            'name' => 'required|string',
            'sub_division_id' => 'required|exists:sub_divisions,id',
        ]);

        $block->update($request->only('name', 'sub_division_id'));

        return redirect()->route('blocks.index')->with('success', 'Block updated successfully.');
    }

    public function destroy(Block $block)
    {
        $block->delete();
        return redirect()->route('blocks.index')->with('success', 'Block deleted successfully.');
    }
}
