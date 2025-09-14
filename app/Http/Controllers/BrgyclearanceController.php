<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BarangayClearance;
use App\Models\BarangayIdDetail;
use App\Models\ResidentModel;
use App\Models\Official;
use App\Traits\HasBarangayDetails;
use Carbon\Carbon;

class BrgyclearanceController extends Controller
{
    use HasBarangayDetails;
    public function index()
    {
        $clearances = BarangayClearance::with('resident')->latest()->get();
        $residents = ResidentModel::orderBy('last_name')->get();
        
        // Generate monthly data for chart (same structure as minor's certificate)
        $raw = BarangayClearance::selectRaw('
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
        
        return view('barangayclearance.index', compact('clearances', 'residents', 'monthlyCounts'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'resident_id' => 'required|exists:tblresidents,id',
            'purpose' => 'required|string|max:255',
            'cedula_number' => 'nullable|string|max:50',
            'date_of_issuance' => 'required|date',
            'or_number' => 'nullable|string|max:50',
            'amount_paid' => 'nullable|numeric|min:0',
            'status' => 'required|in:Issued,Pending,Cancelled',
            'remarks' => 'nullable|string'
        ]);

        BarangayClearance::create($validated);

        session()->flash('print_success', 'Barangay Clearance issued and printed successfully!');

        $clearance = BarangayClearance::with('resident')->latest()->first();
        $barangayDetails = $this->getBarangayDetailsForPrint();
        $officials = Official::with('position')->get();

        return view('barangayclearance.print', compact('clearance', 'barangayDetails', 'officials'));
    }

    public function show($id)
    {
        $clearance = BarangayClearance::with('resident')->findOrFail($id);
        return view('barangayclearance.show', compact('clearance'));
    }

    public function edit($id)
    {
        $clearance = BarangayClearance::findOrFail($id);
        $residents = ResidentModel::orderBy('last_name')->get();
        return view('barangayclearance.edit', compact('clearance', 'residents'));
    }

    public function update(Request $request, $id)
    {
        $clearance = BarangayClearance::findOrFail($id);
        
        $validated = $request->validate([
            'resident_id' => 'required|exists:tblresidents,id',
            'purpose' => 'required|string|max:255',
            'cedula_number' => 'nullable|string|max:50',
            'date_of_issuance' => 'required|date',
            'or_number' => 'nullable|string|max:50',
            'amount_paid' => 'nullable|numeric|min:0',
            'status' => 'required|in:Issued,Pending,Cancelled',
            'remarks' => 'nullable|string'
        ]);

        $clearance->update($validated);

        return redirect()->route('barangayclearance.index')
                         ->with('success', 'Barangay Clearance updated successfully!');
    }

    public function destroy($id)
    {
        $clearance = BarangayClearance::findOrFail($id);
        $clearance->delete();

        return redirect()->route('barangayclearance.index')
                         ->with('success', 'Barangay Clearance deleted successfully!');
    }

    public function print($id){
        $clearance = BarangayClearance::with('resident')->findOrFail($id);
        $barangayDetails = $this->getBarangayDetailsForPrint(); 
        
        $officials = Official::with('position')
            ->active()
            ->get()
            ->sortBy(function($official) {
                if (str_contains($official->position->name, 'Punong Barangay')) {
                    return 0;
                } elseif (str_contains($official->position->name, 'Secretary')) {
                    return 1;
                } elseif (str_contains($official->position->name, 'Treasurer')) {
                    return 2;
                } else {
                    return 3;
                }
            });
        
        return view('barangayclearance.print', compact('clearance', 'barangayDetails', 'officials'));
    }

    public function report(Request $request)
    {
        $dateFrom = $request->input('date_from', now()->startOfYear()->format('Y-m-d'));
        $dateTo = $request->input('date_to', now()->format('Y-m-d'));

        $reportData = BarangayClearance::with('resident')
            ->whereBetween('date_of_issuance', [$dateFrom, $dateTo])
            ->orderBy('date_of_issuance', 'desc')
            ->get();

        $barangayDetails = $this->getBarangayDetailsForPrint();

        return view('barangayclearance.report', compact('reportData', 'dateFrom', 'dateTo', 'barangayDetails'));
    }
}