<?php

namespace App\Http\Controllers;

use App\Models\CertificateOfResidency;
use App\Models\ResidentModel;
use App\Models\BarangayIdDetail;
use App\Models\Official;
use Illuminate\Http\Request;

class CertificateOfResidencyController extends Controller
{
    public function index()
    {
        $certificates = CertificateOfResidency::with('resident')->latest()->get();
        $residents = ResidentModel::all();
        return view('certificate_of_residency.index', compact('certificates', 'residents'));
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

        return redirect()->route('certificate-of-residency.index')
            ->with('success', 'Certificate of Residency issued successfully!');
    }

    public function show($id)
    {
        $certificate = CertificateOfResidency::with('resident')->findOrFail($id);
        $barangayDetails = BarangayIdDetail::first();
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
        $barangayDetails = BarangayIdDetail::first();
        $officials = Official::with('position')->get();
        
        return view('certificate_of_residency.print', compact('certificate', 'barangayDetails', 'officials'));
    }
}