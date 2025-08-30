<?php

namespace App\Http\Controllers;

use App\Models\BarangayGoodMoralCertificate;
use App\Models\ResidentModel;
use App\Models\Official;
use App\Models\BarangayIdDetail;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BarangayGoodMoralCertificateController extends Controller
{
    public function index()
    {
        $certificates = BarangayGoodMoralCertificate::with('resident')->latest()->get();
        $residents = ResidentModel::orderBy('last_name')->get(); 
        $barangayDetails = BarangayIdDetail::first();

        // Count certificates created this month
        $certsThisMonth = BarangayGoodMoralCertificate::whereYear('date_of_issuance', now()->year)
            ->whereMonth('date_of_issuance', now()->month)
            ->count();

        // Monthly data for chart
        $raw = BarangayGoodMoralCertificate::selectRaw('
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

        return view('barangay_good_moral.index', compact(
            'certificates', 
            'residents', 
            'certsThisMonth', 
            'monthlyCounts', 
            'barangayDetails'
        ));
    }

    public function create()
    {
        $residents = ResidentModel::orderBy('last_name')->get();
        return view('barangay_good_moral.create', compact('residents'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'resident_id' => 'required|exists:tblresidents,id',
            'purpose' => 'required|string|max:255',
            'cedula_number' => 'nullable|string|max:50',
            'date_of_issuance' => 'required|date',
            'or_number' => 'nullable|string|max:50',
            'amount_paid' => 'nullable|numeric',
            'status' => 'required|in:Issued,Pending,Cancelled',
            'remarks' => 'nullable|string'
        ]);

        $certificate = BarangayGoodMoralCertificate::create($validated);

        session()->flash('print_success', 'Good Moral Certificate issued and printed successfully!');

        $certificate = BarangayGoodMoralCertificate::with('resident')->latest()->first();
        $barangayDetails = BarangayIdDetail::first();
        $officials = Official::with('position')->get();

        return view('barangay_good_moral.print', compact('certificate', 'barangayDetails', 'officials'));
    }

    public function show($id)
    {
        $certificate = BarangayGoodMoralCertificate::with('resident')->findOrFail($id);
        return view('barangay_good_moral.show', compact('certificate'));
    }

    public function edit($id)
    {
        $certificate = BarangayGoodMoralCertificate::findOrFail($id);
        $residents = ResidentModel::orderBy('last_name')->get();
        return view('barangay_good_moral.edit', compact('certificate', 'residents'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'resident_id' => 'required|exists:tblresidents,id',
            'purpose' => 'required|string|max:255',
            'cedula_number' => 'nullable|string|max:50',
            'date_of_issuance' => 'required|date',
            'or_number' => 'nullable|string|max:50',
            'amount_paid' => 'nullable|numeric',
            'status' => 'required|in:Issued,Pending,Cancelled',
            'remarks' => 'nullable|string'
        ]);

        $certificate = BarangayGoodMoralCertificate::findOrFail($id);
        $certificate->update($validated);

        return redirect()->route('barangaygoodmoral.index')
            ->with('success', 'Good Moral Certificate updated successfully!');
    }

    public function destroy($id)
    {
        $certificate = BarangayGoodMoralCertificate::findOrFail($id);

        if (method_exists($certificate, 'forceDelete')) {
            $certificate->forceDelete();
        } else {
            $certificate->delete();
        }

        return redirect()->route('barangaygoodmoral.index')
            ->with('success', 'Good Moral Certificate deleted successfully!');
    }

    public function print($id){
    $certificate = BarangayGoodMoralCertificate::with('resident')->findOrFail($id);
    $officials = Official::with('position')->get();
    $barangayDetails = BarangayIdDetail::first();

    return view('barangay_good_moral.print', compact('certificate', 'officials', 'barangayDetails'));
    }

    public function report(Request $request)
    {
        $dateFrom = $request->input('date_from');
        $dateTo = $request->input('date_to');
        $barangayDetails = BarangayIdDetail::first(); 

        if (!$dateFrom || !$dateTo) {
            return redirect()->back()->with('error', 'Please select both dates.');
        }

        $reportData = BarangayGoodMoralCertificate::with('resident')
            ->whereBetween('date_of_issuance', [$dateFrom, $dateTo])
            ->orderBy('date_of_issuance', 'asc')
            ->get();

        return view('barangay_good_moral.report', compact(
            'reportData', 
            'dateFrom', 
            'dateTo',
            'barangayDetails' 
        ));
    }
}