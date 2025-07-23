<?php

namespace App\Http\Controllers;

use App\Models\CertificateOfIndigency;
use App\Models\ResidentModel;
use App\Models\BarangayIdDetail;
use App\Models\Official;
use Illuminate\Http\Request;

class CertificateOfIndigencyController extends Controller
{
    public function index()
    {
        $certificates = CertificateOfIndigency::with('resident')->get();
        $residents = ResidentModel::all();
        return view('certificate_of_indigency.index', compact('certificates', 'residents'));
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

        return redirect()->route('certificate_of_indigency.index')
            ->with('success', 'Certificate of Indigency created successfully.');
    }

    public function show($id)
    {
        $certificate = CertificateOfIndigency::with('resident')->findOrFail($id);
        $barangayDetails = BarangayIdDetail::first();
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
        $barangayDetails = BarangayIdDetail::first();
        $officials = Official::with('position')->get();

        return view('certificate_of_indigency.print', compact('certificate', 'barangayDetails', 'officials'));
    }
}