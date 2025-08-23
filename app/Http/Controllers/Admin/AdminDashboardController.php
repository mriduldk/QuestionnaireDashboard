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
        $todaySurveyCount = SurveyAnswer::whereDate('created_at', today())->count();
        //$draftCount = SurveyAnswer::where('status', 'DRAFT')->count();

        $trend = SurveyAnswer::selectRaw("DATE(created_at) as date, COUNT(*) as count")
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $trendLabels = $trend->pluck('date')->toArray();
        $trendData = $trend->pluck('count')->toArray();

        // $districtCounts = DB::table('survey_answers')
        //     ->select(
        //         DB::raw("JSON_UNQUOTE(JSON_EXTRACT(form_specs, '$[0].components[0].answer')) as district"),
        //         DB::raw("COUNT(*) as total")
        //     )
        //     ->groupBy(DB::raw("JSON_UNQUOTE(JSON_EXTRACT(form_specs, '$[0].components[0].answer'))"))
        //     ->get();

        $districtCounts = DB::table(DB::raw("( 
                SELECT JSON_UNQUOTE(JSON_EXTRACT(form_specs, '$[0].components[0].answer')) as district 
                FROM survey_answers
            ) as t"))
            ->select('district', DB::raw('COUNT(*) as total'))
            ->groupBy('district')
            ->get();




        /*$districtCounts = SurveyAnswer::select('district', DB::raw('count(*) as total'))
            ->groupBy('district')
            ->get();*/

        // $districtCounts = SurveyAnswer::select('district', DB::raw('count(*) as total'))
        //     ->whereIn('district', ['Kokrajhar', 'Chirang', 'Baksa', 'Tamulpur', 'Udalguri'])
        //     ->groupBy('district')
        //     ->orderByRaw("FIELD(district, 'Kokrajhar', 'Chirang', 'Baksa', 'Tamulpur', 'Udalguri')")
        //     ->get();

        // dd($districtCounts);

        return view('admin.admin-dashboard', compact(
            'totalSurveys', 'todaySurveyCount', 'trendLabels', 'trendData',
            'districtCounts'
        ));
    }


}
