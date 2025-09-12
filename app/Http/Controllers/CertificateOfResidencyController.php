<?php

namespace App\Http\Controllers;

use App\Models\CertificateOfResidency;
use App\Models\ResidentModel;
use App\Models\BarangayIdDetail;
use App\Models\Official;
use App\Traits\HasBarangayDetails;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CertificateOfResidencyController extends Controller
{
    use HasBarangayDetails;
    public function index()
    {
        $certificates = CertificateOfResidency::with('resident')->latest()->get();
        $residents = ResidentModel::all();
        $barangayDetails = $this->getBarangayDetailsForPrint();

        // Count certificates created this month
        $certsThisMonth = CertificateOfResidency::whereYear('date_of_issuance', now()->year)
            ->whereMonth('date_of_issuance', now()->month)
            ->count();

        // Monthly data for chart
        $raw = CertificateOfResidency::selectRaw('
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

        return view('certificate_of_residency.index', compact(
            'certificates', 
            'residents', 
            'certsThisMonth', 
            'monthlyCounts', 
            'barangayDetails'
        ));
    }

    public function create()
    {
        $residents = ResidentModel::all();
        return view('certificate_of_residency.create', compact('residents'));
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
            'status' => 'required|string|in:Issued,Pending,Cancelled',
            'remarks' => 'nullable|string',
        ]);

        $certificate = CertificateOfResidency::create($validated);

         session()->flash('print_success', 'Certificate of Residency issued and printed successfully!');

        $certificate = CertificateOfResidency::with('resident')->latest()->first();
        $barangayDetails = $this->getBarangayDetailsForPrint();
        $officials = Official::with('position')->get();

        return view('certificate_of_residency.print', compact('certificate', 'barangayDetails', 'officials'));
    }

    public function show($id)
    {
        $certificate = CertificateOfResidency::with('resident')->findOrFail($id);
        $barangayDetails = $this->getBarangayDetailsForPrint();
        $officials = Official::with('position')->get();
        
        return view('certificate_of_residency.show', compact('certificate', 'barangayDetails', 'officials'));
    }

    public function edit($id)
    {
        $certificate = CertificateOfResidency::findOrFail($id);
        $residents = ResidentModel::all();
        return view('certificate_of_residency.edit', compact('certificate', 'residents'));
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
            'status' => 'required|string|in:Issued,Pending,Cancelled',
            'remarks' => 'nullable|string',
        ]);

        $certificate = CertificateOfResidency::findOrFail($id);
        $certificate->update($validated);

        return redirect()->route('certificate-of-residency.index')
            ->with('success', 'Certificate updated successfully!');
    }

    public function destroy($id)
    {
        $certificate = CertificateOfResidency::findOrFail($id);
        $certificate->delete();

        return redirect()->route('certificate-of-residency.index')
            ->with('success', 'Certificate deleted successfully!');
    }

    public function print($id)
    {
        $certificate = CertificateOfResidency::with('resident')->findOrFail($id);
        $barangayDetails = $this->getBarangayDetailsForPrint();
        $officials = Official::with('position')->get();
        
        return view('certificate_of_residency.print', compact('certificate', 'barangayDetails', 'officials'));
    }

    public function report(Request $request)
    {
        $dateFrom = $request->input('date_from');
        $dateTo = $request->input('date_to');
        $barangayDetails = $this->getBarangayDetailsForPrint(); 

        if (!$dateFrom || !$dateTo) {
            return redirect()->back()->with('error', 'Please select both dates.');
        }

        $reportData = CertificateOfResidency::with('resident')
            ->whereBetween('date_of_issuance', [$dateFrom, $dateTo])
            ->orderBy('date_of_issuance', 'asc')
            ->get();

        return view('certificate_of_residency.report', compact(
            'reportData', 
            'dateFrom', 
            'dateTo',
            'barangayDetails' 
        ));
    }
}