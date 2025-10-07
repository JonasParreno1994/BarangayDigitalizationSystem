<?php

namespace App\Http\Controllers;

use App\Models\BarangayCertificate;
use App\Models\ResidentModel;
use App\Models\Official;
use App\Traits\HasBarangayDetails;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BarangayCertificateController extends Controller
{
    use HasBarangayDetails;
    
    public function index()
    {
        $certificates = BarangayCertificate::with('resident')->orderBy('id')->get();
        $residents = ResidentModel::all();
        $barangayDetails = $this->getBarangayDetailsForPrint();

        // Count certificates created this month
        $certsThisMonth = BarangayCertificate::whereYear('date_of_issuance', now()->year)
            ->whereMonth('date_of_issuance', now()->month)
            ->count();

        // Monthly data for chart
        $raw = BarangayCertificate::selectRaw('
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

        return view('barangay_certificate.index', compact(
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
        return view('barangay_certificate.create', compact('residents'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'resident_id' => 'required|exists:tblresidents,id',
            'purpose' => 'required|string|max:255',
            'residence_period_months' => 'nullable|integer|min:0|max:11',
            'residence_period_years' => 'nullable|integer|min:0',
            'cedula_number' => 'nullable|string|max:50',
            'date_of_issuance' => 'required|date',
            'or_number' => 'nullable|string|max:50',
            'amount_paid' => 'nullable|numeric',
            'status' => 'required|string|in:Issued,Pending,Cancelled',
            'remarks' => 'nullable|string',
        ]);

        $certificate = BarangayCertificate::create($validated);

        session()->flash('print_success', 'Barangay Certificate issued successfully!');

        $certificate = BarangayCertificate::with('resident')->latest()->first();
        $barangayDetails = $this->getBarangayDetailsForPrint();
        $officials = Official::with('position')->get();

        return view('barangay_certificate.print', compact('certificate', 'barangayDetails', 'officials'));
    }

    public function show($id)
    {
        $certificate = BarangayCertificate::with('resident')->findOrFail($id);
        return view('barangay_certificate.show', compact('certificate'));
    }

    public function edit($id)
    {
        $certificate = BarangayCertificate::findOrFail($id);
        
        // If it's an AJAX request, return JSON data
        if (request()->ajax()) {
            return response()->json([
                'id' => $certificate->id,
                'resident_id' => $certificate->resident_id,
                'purpose' => $certificate->purpose,
                'residence_period_months' => $certificate->residence_period_months,
                'residence_period_years' => $certificate->residence_period_years,
                'cedula_number' => $certificate->cedula_number,
                'date_of_issuance' => $certificate->date_of_issuance->format('Y-m-d'),
                'or_number' => $certificate->or_number,
                'amount_paid' => $certificate->amount_paid,
                'status' => $certificate->status,
                'remarks' => $certificate->remarks,
            ]);
        }
        
        $residents = ResidentModel::all();
        return view('barangay_certificate.edit', compact('certificate', 'residents'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'resident_id' => 'required|exists:tblresidents,id',
            'purpose' => 'required|string|max:255',
            'residence_period_months' => 'nullable|integer|min:0|max:11',
            'residence_period_years' => 'nullable|integer|min:0',
            'cedula_number' => 'nullable|string|max:50',
            'date_of_issuance' => 'required|date',
            'or_number' => 'nullable|string|max:50',
            'amount_paid' => 'nullable|numeric',
            'status' => 'required|string|in:Issued,Pending,Cancelled',
            'remarks' => 'nullable|string',
        ]);

        $certificate = BarangayCertificate::findOrFail($id);
        $certificate->update($validated);

        // If it's an AJAX request, return JSON response
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Certificate updated successfully!'
            ]);
        }

        return redirect()->route('barangay-certificate.index')
            ->with('success', 'Certificate updated successfully!');
    }

    public function destroy($id)
    {
        $certificate = BarangayCertificate::findOrFail($id);

        // Permanently delete the record if SoftDeletes is enabled, otherwise normal delete
        if (method_exists($certificate, 'forceDelete')) {
            $certificate->forceDelete();
        } else {
            $certificate->delete();
        }

        return redirect()->route('barangay-certificate.index')
            ->with('success', 'Barangay Certificate deleted successfully!');
    }

    public function print($id)
    {
        $certificate = BarangayCertificate::with('resident')->findOrFail($id);
        $barangayDetails = $this->getBarangayDetailsForPrint();
        $officials = Official::with('position')->get();
        
        return view('barangay_certificate.print', compact('certificate', 'barangayDetails', 'officials'));
    }

    public function report(Request $request)
    {
        $dateFrom = $request->input('date_from');
        $dateTo = $request->input('date_to');
        $barangayDetails = $this->getBarangayDetailsForPrint(); 

        if (!$dateFrom || !$dateTo) {
            return redirect()->back()->with('error', 'Please select both dates.');
        }

        $reportData = BarangayCertificate::with('resident')
            ->whereBetween('date_of_issuance', [$dateFrom, $dateTo])
            ->orderBy('date_of_issuance', 'asc')
            ->get();

        return view('barangay_certificate.report', compact(
            'reportData', 
            'dateFrom', 
            'dateTo',
            'barangayDetails' 
        ));
    }
}