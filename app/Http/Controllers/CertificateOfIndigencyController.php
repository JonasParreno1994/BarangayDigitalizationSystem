<?php

namespace App\Http\Controllers;

use App\Models\CertificateOfIndigency;
use App\Models\ResidentModel;
use App\Models\BarangayIdDetail;
use App\Models\Official;
use Carbon\Carbon;
use App\Models\CertIndigencyMinor;
use App\Traits\HasBarangayDetails;
use Illuminate\Http\Request;

class CertificateOfIndigencyController extends Controller
{
    use HasBarangayDetails;

    public function index()
    {
        $certificates = CertificateOfIndigency::with('resident')->latest()->get();
        $residents = ResidentModel::all();
        $barangayDetails = $this->getBarangayDetailsForPrint();

        // Count certificates created this month
        $certsThisMonth = CertificateOfIndigency::whereYear('date_of_issuance', now()->year)
            ->whereMonth('date_of_issuance', now()->month)
            ->count();

        // Monthly data for chart
        $raw = CertificateOfIndigency::selectRaw('
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

        return view('certificate_of_indigency.index', compact(
            'certificates', 
            'residents', 
            'certsThisMonth', 
            'monthlyCounts', 
            'barangayDetails'
        ));
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'resident_id' => 'required|exists:tblresidents,id',
            'purpose' => 'required|string|max:255',
            'date_of_issuance' => 'required|date',
            'or_number' => 'nullable|string|max:50',
            'amount_paid' => 'nullable|numeric',
            'remarks' => 'nullable|string',
            'status' => 'required|in:Pending,Issued,Cancelled'
        ]);

        $certificate = CertificateOfIndigency::create($validated);

        session()->flash('print_success', 'Certificate of Indigency issued and printed successfully!');

        $certificate = CertificateOfIndigency::with('resident')->latest()->first();
        $barangayDetails = $this->getBarangayDetailsForPrint();
        $officials = Official::with('position')->get();

        return view('certificate_of_indigency.print', compact('certificate', 'barangayDetails', 'officials'));
    }

    public function show($id)
    {
        $certificate = CertificateOfIndigency::with('resident')->findOrFail($id);
        $barangayDetails = $this->getBarangayDetailsForPrint();
        $officials = Official::with('position')->get();

        return view('certificate_of_indigency.show', compact('certificate', 'barangayDetails', 'officials'));
    }

    public function edit($id)
    {
        $certificate = CertificateOfIndigency::findOrFail($id);
        $residents = ResidentModel::all();
        return view('certificate_of_indigency.edit', compact('certificate', 'residents'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'resident_id' => 'required|exists:tblresidents,id',
            'purpose' => 'required|string|max:255',
            'date_of_issuance' => 'required|date',
            'or_number' => 'nullable|string|max:50',
            'amount_paid' => 'nullable|numeric',
            'remarks' => 'nullable|string',
            'status' => 'required|in:Pending,Issued,Cancelled'
        ]);

        $certificate = CertificateOfIndigency::findOrFail($id);
        $certificate->update($validated);

        return redirect()->route('certificate_of_indigency.index')
            ->with('success', 'Certificate of Indigency updated successfully.');
    }

    public function destroy($id)
    {
        $certificate = CertificateOfIndigency::findOrFail($id);
        $certificate->delete();

        return redirect()->route('certificate_of_indigency.index')
            ->with('success', 'Certificate of Indigency deleted successfully.');
    }

    public function print($id)
    {
        $certificate = CertificateOfIndigency::with('resident')->findOrFail($id);
        $barangayDetails = $this->getBarangayDetailsForPrint();
        $officials = Official::with('position')->get();

        return view('certificate_of_indigency.print', compact('certificate', 'barangayDetails', 'officials'));
    }

    public function report(Request $request)
    {
        $dateFrom = $request->input('date_from');
        $dateTo = $request->input('date_to');
        $barangayDetails = $this->getBarangayDetailsForPrint(); 

        if (!$dateFrom || !$dateTo) {
            return redirect()->back()->with('error', 'Please select both dates.');
        }

        $reportData = CertificateOfIndigency::with('resident')
            ->whereBetween('date_of_issuance', [$dateFrom, $dateTo])
            ->orderBy('date_of_issuance', 'asc')
            ->get();

        return view('certificate_of_indigency.report', compact(
            'reportData', 
            'dateFrom', 
            'dateTo',
            'barangayDetails' 
        ));
    }
}