<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ResidentModel;
use App\Models\BarangayIdDetail;
use App\Traits\HasBarangayDetails;
use Carbon\Carbon;
use DB;

class RbiFormCController extends Controller
{
    use HasBarangayDetails;

    public function index()
    {
        return view('rbi_form_c.index');
    }

    public function generate(Request $request)
    {
        $request->validate([
            'report_semester' => 'required|in:first,second',
            'report_year' => 'required|numeric|min:2020|max:2030',
        ]);

        try {
            $semester = $request->report_semester;
            $year = $request->report_year;
            
            // Get barangay details using trait
            $barangayDetails = $this->getBarangayDetailsForPrint();
            
            if (!$barangayDetails) {
                return back()->with('error', 'Barangay details not found. Please set up barangay information first.');
            }

            // Calculate date range for semester
            if ($semester === 'first') {
                $startDate = Carbon::create($year, 1, 1);
                $endDate = Carbon::create($year, 6, 30);
            } else {
                $startDate = Carbon::create($year, 7, 1);
                $endDate = Carbon::create($year, 12, 31);
            }

            // Get all active residents (not deceased)
            $residents = ResidentModel::where('status', '!=', 'Deceased')->get();
            
            if ($residents->isEmpty()) {
                return back()->with('error', 'No resident data found. Please add residents first.');
            }
            
            // Population by Age Group
            $populationData = $this->calculatePopulationByAge($residents);
            
            // Labor Force Data
            $laborForceData = $this->calculateLaborForce($residents);
            
            // Out of School Children/Youth
            $outOfSchoolData = $this->calculateOutOfSchool($residents);
            
            // Persons with Disabilities
            $pwdData = $this->calculatePWD($residents);
            
            // Overseas Filipino Workers
            $ofwData = $this->calculateOFW($residents);
            
            // Indigenous People
            $indigenousData = $this->calculateIndigenous($residents);
            
            // Citizenship data
            $citizenshipData = $this->calculateCitizenship($residents);

            return view('rbi_form_c.print', compact(
                'semester', 
                'year', 
                'barangayDetails', 
                'populationData',
                'laborForceData',
                'outOfSchoolData',
                'pwdData',
                'ofwData',
                'indigenousData',
                'citizenshipData',
                'residents'
            ));
        } catch (\Exception $e) {
            return back()->with('error', 'An error occurred while generating the report: ' . $e->getMessage());
        }
    }

    private function calculatePopulationByAge($residents)
    {
        $data = [];
        $ageRanges = [
            'Under 5 years old' => [0, 4],
            '5-9 years old' => [5, 9],
            '10-14 years old' => [10, 14],
            '15-19 years old' => [15, 19],
            '20-24 years old' => [20, 24],
            '25-29 years old' => [25, 29],
            '30-34 years old' => [30, 34],
            '35-39 years old' => [35, 39],
            '40-44 years old' => [40, 44],
            '45-49 years old' => [45, 49],
            '50-54 years old' => [50, 54],
            '55-59 years old' => [55, 59],
            '60-64 years old' => [60, 64],
            '65-69 years old' => [65, 69],
            '70-74 years old' => [70, 74],
            '75-79 years old' => [75, 79],
            '80-84 years old' => [80, 84],
            '85 years old and above' => [85, 150]
        ];

        foreach ($ageRanges as $range => $ages) {
            $male = 0;
            $female = 0;
            
            foreach ($residents as $resident) {
                if ($resident->birth_date) {
                    $age = Carbon::parse($resident->birth_date)->age;
                    
                    if ($age >= $ages[0] && $age <= $ages[1]) {
                        if (strtolower($resident->sex) === 'male') {
                            $male++;
                        } else {
                            $female++;
                        }
                    }
                }
            }
            
            $data[$range] = [
                'male' => $male,
                'female' => $female,
                'total' => $male + $female
            ];
        }
        
        return $data;
    }

    private function calculateLaborForce($residents)
    {
        $laborForce = 0;
        $unemployed = 0;
        
        foreach ($residents as $resident) {
            if ($resident->birth_date) {
                $age = Carbon::parse($resident->birth_date)->age;
                
                // Labor force age is typically 15 and above
                if ($age >= 15) {
                    if ($resident->occupation && $resident->occupation !== 'Unemployed' && $resident->occupation !== 'N/A') {
                        $laborForce++;
                    } elseif ($resident->is_unemployed || $resident->occupation === 'Unemployed') {
                        $unemployed++;
                    }
                }
            }
        }
        
        return [
            'labor_force' => $laborForce,
            'unemployed' => $unemployed
        ];
    }

    private function calculateOutOfSchool($residents)
    {
        $osc = 0; // Out of School Children (6-14 years)
        $osy = 0; // Out of School Youth (15-24 years)
        
        foreach ($residents as $resident) {
            if ($resident->birth_date) {
                $age = Carbon::parse($resident->birth_date)->age;
                
                // Out of School Children (6-14 years)
                if ($age >= 6 && $age <= 14) {
                    if (!$resident->education_status || $resident->education_status === 'Not Attending') {
                        $osc++;
                    }
                }
                
                // Out of School Youth (15-24 years)
                if ($age >= 15 && $age <= 24) {
                    if (!$resident->education_status || $resident->education_status === 'Not Attending') {
                        $osy++;
                    }
                }
            }
        }
        
        return [
            'osc' => $osc,
            'osy' => $osy
        ];
    }

    private function calculatePWD($residents)
    {
        $pwd = 0;
        
        foreach ($residents as $resident) {
            if ($resident->is_pwd) {
                $pwd++;
            }
        }
        
        return $pwd;
    }

    private function calculateOFW($residents)
    {
        $ofw = 0;
        
        foreach ($residents as $resident) {
            if ($resident->is_ofw) {
                $ofw++;
            }
        }
        
        return $ofw;
    }

    private function calculateIndigenous($residents)
    {
        $indigenous = 0;
        
        foreach ($residents as $resident) {
            if ($resident->is_indigenous) {
                $indigenous++;
            }
        }
        
        return $indigenous;
    }

    private function calculateCitizenship($residents)
    {
        $filipino = 0;
        $foreigner = 0;
        
        foreach ($residents as $resident) {
            $citizenship = strtolower($resident->citizenship ?? '');
            if ($citizenship === 'filipino' || $citizenship === 'philippine' || $citizenship === 'philippines' || empty($citizenship)) {
                $filipino++;
            } else {
                $foreigner++;
            }
        }
        
        return [
            'filipino' => $filipino,
            'foreigner' => $foreigner
        ];
    }
}
