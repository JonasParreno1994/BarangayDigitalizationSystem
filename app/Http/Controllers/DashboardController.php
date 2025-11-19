<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ResidentModel;
use App\Models\Purok;

class DashboardController extends Controller
{
    public function residentsgraph()
    {
     
        $maleCount = ResidentModel::where('sex', 'Male')->count();
        $femaleCount = ResidentModel::where('sex', 'Female')->count();
        
        $civilStatusCounts = ResidentModel::select('civil_status')
            ->selectRaw('count(*) as count')
            ->groupBy('civil_status')
            ->pluck('count', 'civil_status');
            
        $ageGroups = [
            '0-17' => ResidentModel::whereRaw('TIMESTAMPDIFF(YEAR, birth_date, CURDATE()) BETWEEN 0 AND 17')->count(),
            '18-30' => ResidentModel::whereRaw('TIMESTAMPDIFF(YEAR, birth_date, CURDATE()) BETWEEN 18 AND 30')->count(),
            '31-45' => ResidentModel::whereRaw('TIMESTAMPDIFF(YEAR, birth_date, CURDATE()) BETWEEN 31 AND 45')->count(),
            '46-60' => ResidentModel::whereRaw('TIMESTAMPDIFF(YEAR, birth_date, CURDATE()) BETWEEN 46 AND 60')->count(),
            '61+' => ResidentModel::whereRaw('TIMESTAMPDIFF(YEAR, birth_date, CURDATE()) > 60')->count(),
        ];

       
        $purokCounts = Purok::withCount('residents')
        ->get()
        ->mapWithKeys(function ($purok) {
            return [$purok->purok_name => $purok->residents_count];
        });

        // Senior Citizen Prediction Analytics
        $currentYear = now()->year;
        $analytics = [];

        // Get prediction data for next 10 years
        for ($i = 0; $i <= 10; $i++) {
            $year = $currentYear + $i;
            $birthYear = $year - 60;
            
            $count = ResidentModel::query()
                ->where('is_senior_citizen', false)
                ->whereYear('birth_date', $birthYear)
                ->count();
            
            $analytics[] = [
                'year' => $year,
                'count' => $count
            ];
        }

        // Monthly breakdown for next year
        $nextYear = $currentYear + 1;
        $birthYearNext = $nextYear - 60;
        $monthlyData = [];
        
        for ($month = 1; $month <= 12; $month++) {
            $count = ResidentModel::query()
                ->where('is_senior_citizen', false)
                ->whereYear('birth_date', $birthYearNext)
                ->whereMonth('birth_date', $month)
                ->count();
            
            $monthlyData[] = [
                'month' => $month,
                'month_name' => date('F', mktime(0, 0, 0, $month, 1)),
                'count' => $count
            ];
        }

        // By Purok breakdown for next year (senior predictions)
        $seniorPurokData = [];
        $puroks = Purok::all();
        
        foreach ($puroks as $purok) {
            $count = ResidentModel::query()
                ->where('is_senior_citizen', false)
                ->where('purok_id', $purok->id)
                ->whereYear('birth_date', $birthYearNext)
                ->count();
            
            $seniorPurokData[] = [
                'purok_name' => $purok->purok_name,
                'count' => $count
            ];
        }
    

        return view('dashboard.residentsgraph', compact(
            'maleCount', 
            'femaleCount',
            'civilStatusCounts',
            'ageGroups',
            'purokCounts',
            'analytics',
            'monthlyData',
            'seniorPurokData',
            'currentYear'
        ));
    }
}