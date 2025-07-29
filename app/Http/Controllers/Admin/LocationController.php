<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SubDivision;
use App\Models\Block;
use App\Models\Vcdc;

class LocationController extends Controller
{
    public function getSubDivisions($districtId)
    {
        return SubDivision::where('district_id', $districtId)->pluck('name', 'id');
    }

    public function getBlocks($subDivisionId)
    {
        return Block::where('sub_division_id', $subDivisionId)->pluck('name', 'id');
    }

    public function getVcdcs($blockId)
    {
        return Vcdc::where('block_id', $blockId)->pluck('name', 'id');
    }
}

