<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ResidentModel;
use App\Models\BarangayIdDetail;
use Carbon\Carbon;

class SpecialReportController extends Controller
{
    
    public function index()
    {
        return view('reports.special.index');
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
}