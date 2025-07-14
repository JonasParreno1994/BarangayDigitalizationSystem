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
            ->orderBy('purok_name')
            ->get()
            ->mapWithKeys(function ($purok) {
                return [$purok->purok_name => $purok->residents_count];
            });

        return view('dashboard.residentsgraph', compact(
            'maleCount', 
            'femaleCount',
            'civilStatusCounts',
            'ageGroups',
            'purokCounts'
        ));
    }
}