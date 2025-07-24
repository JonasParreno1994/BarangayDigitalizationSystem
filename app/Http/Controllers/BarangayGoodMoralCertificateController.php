<?php

namespace App\Http\Controllers;

use App\Models\BarangayGoodMoralCertificate;
use App\Models\ResidentModel;
use App\Models\Official;
use App\Models\BarangayIdDetail;
use Illuminate\Http\Request;

class BarangayGoodMoralCertificateController extends Controller
{
    public function index()
    {
        $certificates = BarangayGoodMoralCertificate::with('resident')->latest()->get();
        $residents = ResidentModel::orderBy('last_name')->get(); 
       return view('barangay_good_moral.index', compact('certificates', 'residents'));
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

        return redirect()->route('barangaygoodmoral.index')
            ->with('success', 'Good Moral Certificate issued successfully!');
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
}