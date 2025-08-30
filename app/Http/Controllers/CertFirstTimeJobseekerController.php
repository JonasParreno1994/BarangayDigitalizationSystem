<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CertFirstTimeJobseeker;
use App\Models\ResidentModel;
use App\Models\BarangayIdDetail;
use App\Models\Purok;
use Carbon\Carbon;
use App\Models\Official;


class CertFirstTimeJobseekerController extends Controller
{
    public function index(Request $request)
    {
        $certs = CertFirstTimeJobseeker::with('resident')->latest()->get();
        $residents = ResidentModel::with('purok')->get();
        $puroks = Purok::all();
        $barangayDetails = BarangayIdDetail::first(); 

        
        $certsThisMonth = CertFirstTimeJobseeker::whereYear('date_of_issuance', now()->year)
            ->whereMonth('date_of_issuance', now()->month)
            ->count();

        
        $raw = CertFirstTimeJobseeker::selectRaw('
                MONTH(date_of_issuance) as month_num,
                DATE_FORMAT(date_of_issuance, "%M") as month,
                COUNT(*) as total
            ')
            ->whereYear('date_of_issuance', now()->year)
            ->groupBy('month_num', 'month')
            ->orderBy('month_num')
            ->get()
            ->pluck('total', 'month')
            ->toArray();

        $allMonths = collect(range(1, 12))
            ->mapWithKeys(fn($m) => [Carbon::create(null, $m, 1)->format('F') => 0])
            ->toArray();

        $monthlyCounts = array_merge($allMonths, $raw);

        $reportData = collect();
        if ($request->filled(['date_from', 'date_to'])) {
            $reportData = CertFirstTimeJobseeker::with('resident')
                ->whereBetween('date_of_issuance', [
                    $request->date_from,
                    $request->date_to
                ])
                ->orderBy('date_of_issuance', 'asc')
                ->get();
        }

        return view('cert_firstTime_Jobseeker.index', compact(
            'certs',
            'residents',
            'puroks',
            'certsThisMonth',
            'monthlyCounts',
            'reportData',
            'barangayDetails'
        ));
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'resident_id' => 'required|exists:tblresidents,id',
            'age' => 'required|integer|min:15|max:100',
            'purok' => 'required|string|max:100',
            'date_of_issuance' => 'required|date',
            'or_number' => 'nullable|string|max:50',
            'amount_paid' => 'nullable|numeric|min:0',
            'status' => 'required|string|in:Issued,Pending,Cancelled',
            'remarks' => 'nullable|string'
        ]);

        // Add barangay field (you can modify this as needed)
        $validated['barangay'] = 'Barangay Name'; // Or get from config/settings

        $cert = CertFirstTimeJobseeker::create($validated);
        $barangayDetails = BarangayIdDetail::first();
        $officials = Official::with('position')->get();

        session()->flash('print_success', 'Certificate for First Time Jobseeker issued and printed successfully!');

        return view('cert_firstTime_Jobseeker.print', compact('cert', 'barangayDetails', 'officials'));
    }

        public function print($id)
        {
            $cert = CertFirstTimeJobseeker::with('resident')->findOrFail($id);
            $barangayDetails = BarangayIdDetail::first();
            $officials = Official::with('position')->get();
    
            return view('cert_firstTime_Jobseeker.print', compact('cert', 'barangayDetails', 'officials'));
        }
        public function show($id)
    {
        $cert = CertFirstTimeJobseeker::with('resident')->findOrFail($id);
        $barangayDetails = BarangayIdDetail::first();
        $officials = Official::with('position')->get();

        return view('cert_firstTime_Jobseeker.show', compact('cert', 'barangayDetails', 'officials'));
    }

    public function destroy($id)
    {
        $cert = CertFirstTimeJobseeker::findOrFail($id);
        $cert->delete();

        return redirect()->route('cert_firstTime_Jobseeker.index')
                         ->with('success', 'Certificate for First Time Jobseeker deleted successfully!');
    }

    public function report(Request $request)
    {
        $dateFrom = $request->input('date_from');
        $dateTo = $request->input('date_to');
        $barangayDetails = BarangayIdDetail::first(); 

        
        if (!$dateFrom || !$dateTo) {
            return redirect()->back()->with('error', 'Please select both dates.');
        }

        $reportData = CertFirstTimeJobseeker::with('resident')
            ->whereBetween('date_of_issuance', [$dateFrom, $dateTo])
            ->orderBy('date_of_issuance', 'asc')
            ->get();

        return view('cert_firstTime_Jobseeker.report', compact(
            'reportData', 
            'dateFrom', 
            'dateTo',
            'barangayDetails' 
        ));
    }
}


