<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SurveyAnswer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    /*public function index()
    {
        return view('admin.admin-dashboard');
    }*/

    public function index()
    {
        $totalSurveys = SurveyAnswer::count();
        $completedCount = SurveyAnswer::where('status', 'COMPLETED')->count();
        $draftCount = SurveyAnswer::where('status', 'DRAFT')->count();

        $trend = SurveyAnswer::selectRaw("DATE(created_at) as date, COUNT(*) as count")
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $trendLabels = $trend->pluck('date')->toArray();
        $trendData = $trend->pluck('count')->toArray();


        // Gender Distribution
        $genderCounts = SurveyAnswer::select('gender', DB::raw('COUNT(*) as count'))
            ->groupBy('gender')
            ->pluck('count', 'gender');

        // Age Group Distribution
        $ageGroups = [
            '<18' => [0, 17],
            '18-30' => [18, 30],
            '31-45' => [31, 45],
            '46-60' => [46, 60],
            '60+' => [61, 200],
        ];

        $ageCounts = [];
        foreach ($ageGroups as $label => [$min, $max]) {
            $ageCounts[$label] = SurveyAnswer::whereBetween('age', [$min, $max])->count();
        }

        // Caste Breakdown
        $casteCounts = SurveyAnswer::select('caste', DB::raw('COUNT(*) as count'))
            ->groupBy('caste')
            ->pluck('count', 'caste');

        /*$districtCounts = SurveyAnswer::select('district', DB::raw('count(*) as total'))
            ->groupBy('district')
            ->get();*/

        $districtCounts = SurveyAnswer::select('district', DB::raw('count(*) as total'))
            ->whereIn('district', ['Kokrajhar', 'Baksa', 'Chirang', 'Tamulpur', 'Udalguri'])
            ->groupBy('district')
            ->orderByRaw("FIELD(district, 'Kokrajhar', 'Baksa', 'Chirang', 'Tamulpur', 'Udalguri')")
            ->get();

        return view('admin.admin-dashboard', compact(
            'totalSurveys', 'completedCount', 'draftCount', 'trendLabels', 'trendData',
            'genderCounts', 'ageCounts', 'casteCounts',
            'districtCounts'
        ));
    }


}
