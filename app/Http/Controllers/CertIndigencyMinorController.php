<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CertIndigencyMinor;
use App\Models\ResidentModel;
use App\Models\BarangayIdDetail;
use App\Models\Purok;
use Carbon\Carbon;
use App\Models\Official;

class CertIndigencyMinorController extends Controller
{
    public function index(Request $request)
    {
        $certs = CertIndigencyMinor::with('resident')->latest()->get();
        $residents = ResidentModel::all();
        $puroks = Purok::all();
        $barangayDetails = BarangayIdDetail::first(); 

        
        $certsThisMonth = CertIndigencyMinor::whereYear('date_of_issuance', now()->year)
            ->whereMonth('date_of_issuance', now()->month)
            ->count();

        
        $raw = CertIndigencyMinor::selectRaw('
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
            $reportData = CertIndigencyMinor::with('resident')
                ->whereBetween('date_of_issuance', [
                    $request->date_from,
                    $request->date_to
                ])
                ->orderBy('date_of_issuance', 'asc')
                ->get();
        }

        return view('cert_indigency_minor.index', compact(
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
        'purpose' => 'required|string|max:255',
        'purok' => 'required|string|max:100',
        'childsName' => 'required|string|max:100',
        'childsAge' => 'required|string|max:10',
        'childsGender' => 'required|string|in:Son,Daughter',
        'status' => 'required|string|in:Issued,Pending,Cancelled',
        'date_of_issuance' => 'required|date',
        'or_number' => 'nullable|string|max:50',
        'amount_paid' => 'nullable|numeric|min:0',
        'remarks' => 'nullable|string'
    ]);

    $cert = CertIndigencyMinor::create($validated);
    $barangayDetails = BarangayIdDetail::first();
    $officials = Official::with('position')->get();

    session()->flash('print_success', 'Certificate of Indigency for Minor issued and printed successfully!');

    return view('cert_indigency_minor.print', compact('cert', 'barangayDetails', 'officials'));
    }

    public function show($id)
    {
        $cert = CertIndigencyMinor::with('resident')->findOrFail($id);
        $barangayDetails = BarangayIdDetail::first();
        $officials = Official::with('position')->get();

        return view('cert_indigency_minor.show', compact('cert', 'barangayDetails', 'officials'));
    }

    public function edit($id)
    {
        $cert = CertIndigencyMinor::findOrFail($id);
        $residents = ResidentModel::orderBy('last_name')->get();
        return view('cert_indigency_minor.edit', compact('cert', 'residents'));
    }

    public function update(Request $request, $id)
    {
        $cert = CertIndigencyMinor::findOrFail($id);

        $validated = $request->validate([
            'resident_id' => 'required|exists:tblresidents,id',
            'purpose' => 'required|string|max:255',
            'purok' => 'required|string|max:100',
            'childsName' => 'required|string|max:100',
            'childsAge' => 'required|string|max:10',
            'childsGender' => 'required|string|max:10',
            'status' => 'required|string|in:Issued,Pending,Cancelled',
            'date_of_issuance' => 'required|date',
            'or_number' => 'nullable|string|max:50',
            'amount_paid' => 'nullable|numeric|min:0',
            'remarks' => 'nullable|string'
        ]);
        $cert->update($validated);
        return redirect()->route('cert_indigency_minor.index')
                         ->with('success', 'Certificate of Indigency for Minor updated successfully!');
}

    public function destroy($id)
    {
        $cert = CertIndigencyMinor::findOrFail($id);
        $cert->delete();

        return redirect()->route('cert_indigency_minor.index')
                         ->with('success', 'Certificate of Indigency for Minor deleted successfully!');
    }
    public function print($id)
    {
        $cert = CertIndigencyMinor::with('resident')->findOrFail($id);
        $barangayDetails = BarangayIdDetail::first();
        $officials = Official::with('position')->get();

        return view('cert_indigency_minor.print', compact('cert', 'barangayDetails', 'officials'));
    }
    public function report(Request $request)
    {
        $dateFrom = $request->input('date_from');
        $dateTo = $request->input('date_to');
        $barangayDetails = BarangayIdDetail::first(); 

        
        if (!$dateFrom || !$dateTo) {
            return redirect()->back()->with('error', 'Please select both dates.');
        }

        $reportData = CertIndigencyMinor::with('resident')
            ->whereBetween('date_of_issuance', [$dateFrom, $dateTo])
            ->orderBy('date_of_issuance', 'asc')
            ->get();

        return view('cert_indigency_minor.report', compact(
            'reportData', 
            'dateFrom', 
            'dateTo',
            'barangayDetails' 
        ));
    }
}