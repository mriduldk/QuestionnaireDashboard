<?php

namespace App\Http\Controllers;

use App\Models\Visitor;
use Illuminate\Http\Request;

class VisitorController extends Controller
{
    public function trackVisitor()
    {
        $totalVisitors = Visitor::count();
        return response()->json(['total_visitors' => $totalVisitors]);
    }
    public function index(Request $request)
    {
        Visitor::firstOrCreate(['ip_address' => $request->ip()]);
        $totalVisitors = Visitor::count();
        return response()->json(['total_visitors' => $totalVisitors]);
    }

}
