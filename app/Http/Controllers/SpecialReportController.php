<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ResidentModel;
use App\Models\BarangayIdDetail;
use App\Models\Purok;
use Carbon\Carbon;

class SpecialReportController extends Controller
{
    
    public function index()
    {
        $puroks = \App\Models\Purok::all();
        return view('reports.special.index', compact('puroks'));
    }

    public function generate(Request $request)
    {
        $request->validate([
            'report_type' => 'required|in:seniors,pwds,solo_parents,all',
            'age_range' => 'nullable|string|in:60-69,70-79,80+,all',
            'pwd_type' => 'nullable|string',
            'civil_status' => 'nullable|string|in:Single,Married,Widowed,Separated,all',
        ]);

        $reportType = $request->report_type;
        $ageRange = $request->age_range;
        $pwdType = $request->pwd_type;
        $civilStatus = $request->civil_status;

        $query = ResidentModel::query();

        switch ($reportType) {
            case 'seniors':
                $query->where('is_senior_citizen', true);
                break;
            case 'pwds':
                $query->where('is_pwd', true);
                if ($pwdType && $pwdType !== 'all') {
                    $query->where('pwd_type', $pwdType);
                }
                break;
            case 'solo_parents':
                $query->where('is_solo_parent', true);
                break;
            case 'all':
                $query->where(function($q) {
                    $q->where('is_senior_citizen', true)
                      ->orWhere('is_pwd', true)
                      ->orWhere('is_solo_parent', true);
                });
                break;
        }

        // Apply age filter for seniors
        if ($ageRange && $ageRange !== 'all' && in_array($reportType, ['seniors', 'all'])) {
            $today = Carbon::today();
            
            switch ($ageRange) {
                case '60-69':
                    $query->whereRaw("TIMESTAMPDIFF(YEAR, birth_date, ?) BETWEEN 60 AND 69", [$today]);
                    break;
                case '70-79':
                    $query->whereRaw("TIMESTAMPDIFF(YEAR, birth_date, ?) BETWEEN 70 AND 79", [$today]);
                    break;
                case '80+':
                    $query->whereRaw("TIMESTAMPDIFF(YEAR, birth_date, ?) >= 80", [$today]);
                    break;
            }
        }

        // Apply civil status filter for solo parents
        if ($civilStatus && $civilStatus !== 'all' && in_array($reportType, ['solo_parents', 'all'])) {
            $query->where('civil_status', $civilStatus);
        }

        $residents = $query->orderBy('last_name')->get();
        $barangayDetails = BarangayIdDetail::latest()->first();

        return view('reports.special.results', compact('residents', 'reportType', 'ageRange', 'pwdType', 'civilStatus', 'barangayDetails'));
    }

    /**
     * Generate printable version of the report
     */
    public function print(Request $request)
    {
        $reportType = $request->report_type;
        $ageRange = $request->age_range;
        $pwdType = $request->pwd_type;
        $civilStatus = $request->civil_status;

        $query = ResidentModel::query();

        switch ($reportType) {
            case 'seniors':
                $query->where('is_senior_citizen', true);
                break;
            case 'pwds':
                $query->where('is_pwd', true);
                if ($pwdType && $pwdType !== 'all') {
                    $query->where('pwd_type', $pwdType);
                }
                break;
            case 'solo_parents':
                $query->where('is_solo_parent', true);
                break;
            case 'all':
                $query->where(function($q) {
                    $q->where('is_senior_citizen', true)
                      ->orWhere('is_pwd', true)
                      ->orWhere('is_solo_parent', true);
                });
                break;
        }

        if ($ageRange && $ageRange !== 'all' && in_array($reportType, ['seniors', 'all'])) {
            $today = Carbon::today();
            
            switch ($ageRange) {
                case '60-69':
                    $query->whereRaw("TIMESTAMPDIFF(YEAR, birth_date, ?) BETWEEN 60 AND 69", [$today]);
                    break;
                case '70-79':
                    $query->whereRaw("TIMESTAMPDIFF(YEAR, birth_date, ?) BETWEEN 70 AND 79", [$today]);
                    break;
                case '80+':
                    $query->whereRaw("TIMESTAMPDIFF(YEAR, birth_date, ?) >= 80", [$today]);
                    break;
            }
        }

        if ($civilStatus && $civilStatus !== 'all' && in_array($reportType, ['solo_parents', 'all'])) {
            $query->where('civil_status', $civilStatus);
        }

        $residents = $query->orderBy('last_name')->get();
        $barangayDetails = BarangayIdDetail::latest()->first();

        return view('reports.special.print', compact('residents', 'reportType', 'ageRange', 'pwdType', 'civilStatus', 'barangayDetails'));
    }

    public function generatePurokReport(Request $request){
        $request->validate([
            'purok_id' => 'required|exists:puroks,id',
            'report_type' => 'nullable|in:all,seniors,pwds,solo_parents',
            'gender' => 'nullable|in:all,Male,Female',
            'civil_status' => 'nullable|in:all,Single,Married,Widowed,Separated'
        ]);

        $purokId = $request->purok_id;
        $reportType = $request->report_type ?? 'all';
        $gender = $request->gender ?? 'all';
        $civilStatus = $request->civil_status ?? 'all';

        $query = ResidentModel::where('purok_id', $purokId);

        // Apply report type filters
        if ($reportType !== 'all') {
            switch ($reportType) {
                case 'seniors':
                    $query->where('is_senior_citizen', true);
                    break;
                case 'pwds':
                    $query->where('is_pwd', true);
                    break;
                case 'solo_parents':
                    $query->where('is_solo_parent', true);
                    break;
            }
        }

        // Apply gender filter - CHANGED FROM 'gender' TO 'sex'
        if ($gender !== 'all') {
            $query->where('sex', $gender);
        }

        // Apply civil status filter
        if ($civilStatus !== 'all') {
            $query->where('civil_status', $civilStatus);
        }

        $residents = $query->orderBy('last_name')->get();
        $purok = Purok::findOrFail($purokId);
        $barangayDetails = BarangayIdDetail::latest()->first();

        return view('reports.special.purok-results', compact(
            'residents', 
            'purok',
            'reportType',
            'gender',
            'civilStatus',
            'barangayDetails'
        ));
    }

    public function printPurokReport(Request $request) {
        $purokId = $request->purok_id;
        $reportType = $request->report_type ?? 'all';
        $gender = $request->gender ?? 'all';
        $civilStatus = $request->civilStatus ?? 'all';

        $query = ResidentModel::where('purok_id', $purokId);

        if ($reportType !== 'all') {
            switch ($reportType) {
                case 'seniors':
                    $query->where('is_senior_citizen', true);
                    break;
                case 'pwds':
                    $query->where('is_pwd', true);
                    break;
                case 'solo_parents':
                    $query->where('is_solo_parent', true);
                    break;
            }
        }

        // Apply gender filter - CHANGED FROM 'gender' TO 'sex'
        if ($gender !== 'all') {
            $query->where('sex', $gender);
        }

        if ($civilStatus !== 'all') {
            $query->where('civil_status', $civilStatus);
        }

        $residents = $query->orderBy('last_name')->get();
        $purok = Purok::findOrFail($purokId);
        $barangayDetails = BarangayIdDetail::latest()->first();

        return view('reports.special.purok-print', compact(
            'residents', 
            'purok',
            'reportType',
            'gender',
            'civilStatus',
            'barangayDetails'
        ));
    }

    public function generateAgeBracketReport(Request $request)
    {
        $request->validate([
            'age_bracket' => 'required|in:5-9,10-14,15-19,20-24,25-29,30-34,35-39,40-44,45-49,50-59,60-64,65-69,70-74,75-79,80+,all',
        ]);

        $ageBracket = $request->age_bracket;
        $today = Carbon::today();

        $query = ResidentModel::query();

        if ($ageBracket !== 'all') {
            list($minAge, $maxAge) = $this->parseAgeBracket($ageBracket);
            
            if ($maxAge !== null) {
                $query->whereRaw("TIMESTAMPDIFF(YEAR, birth_date, ?) BETWEEN ? AND ?", 
                    [$today, $minAge, $maxAge]);
            } else {
                $query->whereRaw("TIMESTAMPDIFF(YEAR, birth_date, ?) >= ?", 
                    [$today, $minAge]);
            }
        }

        $residents = $query->orderBy('last_name')->get();
        $barangayDetails = BarangayIdDetail::latest()->first();

        return view('reports.special.age-bracket-results', compact(
            'residents', 
            'ageBracket',
            'barangayDetails'
        ));
    }

    public function generateSectorReport(Request $request)
    {
        $request->validate([
            'sector_type' => 'required|in:labor_force,unemployed,out_of_school_children,out_of_school_youth,ofw,indigenous',
        ]);

        $sectorType = $request->sector_type;
        $today = Carbon::today();

        $query = ResidentModel::query();

        switch ($sectorType) {
            case 'labor_force':
                // Assuming labor force is anyone employed (occupation not empty)
                $query->whereNotNull('occupation')->where('occupation', '!=', '');
                break;
                
            case 'unemployed':
                $query->where('is_unemployed', true);
                break;
                
            case 'out_of_school_children':
                // Children aged 6-14 not in school
                $query->whereRaw("TIMESTAMPDIFF(YEAR, birth_date, ?) BETWEEN 6 AND 14", [$today])
                     ->where(function($q) {
                         $q->whereNull('education_status')
                           ->orWhere('education_status', '!=', 'Currently Enrolled');
                     });
                break;
                
            case 'out_of_school_youth':
                // Youth aged 15-24 not in school
                $query->whereRaw("TIMESTAMPDIFF(YEAR, birth_date, ?) BETWEEN 15 AND 24", [$today])
                     ->where(function($q) {
                         $q->whereNull('education_status')
                           ->orWhere('education_status', '!=', 'Currently Enrolled');
                     });
                break;
                
            case 'ofw':
                $query->where('is_ofw', true);
                break;
                
            case 'indigenous':
                // Assuming IP status is stored in a custom field (you may need to add this)
                $query->where('is_indigenous', true);
                break;
        }

        $residents = $query->orderBy('last_name')->get();
        $barangayDetails = BarangayIdDetail::latest()->first();

        return view('reports.special.sector-results', compact(
            'residents', 
            'sectorType',
            'barangayDetails'
        ));
    }

    public function printAgeBracketReport(Request $request)
    {
        // Similar to generateAgeBracketReport but returns printable view
        $ageBracket = $request->age_bracket;
        $today = Carbon::today();

        $query = ResidentModel::query();

        if ($ageBracket !== 'all') {
            list($minAge, $maxAge) = $this->parseAgeBracket($ageBracket);
            
            if ($maxAge !== null) {
                $query->whereRaw("TIMESTAMPDIFF(YEAR, birth_date, ?) BETWEEN ? AND ?", 
                    [$today, $minAge, $maxAge]);
            } else {
                $query->whereRaw("TIMESTAMPDIFF(YEAR, birth_date, ?) >= ?", 
                    [$today, $minAge]);
            }
        }

        $residents = $query->orderBy('last_name')->get();
        $barangayDetails = BarangayIdDetail::latest()->first();

        return view('reports.special.age-bracket-print', compact(
            'residents', 
            'ageBracket',
            'barangayDetails'
        ));
    }

    public function printSectorReport(Request $request)
    {
        // Similar to generateSectorReport but returns printable view
        $sectorType = $request->sector_type;
        $today = Carbon::today();

        $query = ResidentModel::query();

        switch ($sectorType) {
            case 'labor_force':
                $query->whereNotNull('occupation')->where('occupation', '!=', '');
                break;
                
            case 'unemployed':
                $query->where(function($q) {
                    $q->whereNull('occupation')->orWhere('occupation', '');
                });
                break;
                
            case 'out_of_school_children':
                $query->whereRaw("TIMESTAMPDIFF(YEAR, birth_date, ?) BETWEEN 6 AND 14", [$today])
                     ->where(function($q) {
                         $q->whereNull('education_status')
                           ->orWhere('education_status', '!=', 'Currently Enrolled');
                     });
                break;
                
            case 'out_of_school_youth':
                $query->whereRaw("TIMESTAMPDIFF(YEAR, birth_date, ?) BETWEEN 15 AND 24", [$today])
                     ->where(function($q) {
                         $q->whereNull('education_status')
                           ->orWhere('education_status', '!=', 'Currently Enrolled');
                     });
                break;
                
            case 'ofw':
                $query->where('occupation', 'like', '%OFW%')
                     ->orWhere('occupation', 'like', '%Overseas%');
                break;
                
            case 'indigenous':
                $query->where('is_indigenous', true);
                break;
        }

        $residents = $query->orderBy('last_name')->get();
        $barangayDetails = BarangayIdDetail::latest()->first();

        return view('reports.special.sector-print', compact(
            'residents', 
            'sectorType',
            'barangayDetails'
        ));
    }

    private function parseAgeBracket($bracket)
    {
        if ($bracket === '80+') {
            return [80, null];
        }

        $parts = explode('-', $bracket);
        return [intval($parts[0]), intval($parts[1])];
    }
}