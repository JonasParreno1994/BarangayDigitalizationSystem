<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CertIndigencyMinor;
use App\Models\ResidentModel;
use App\Models\Official;

class CertIndigencyMinorController extends Controller
{
    public function index()
    {
        $certs = CertIndigencyMinor::with('resident')->latest()->get();
        $residents = ResidentModel::all();
        
        return view('cert_indigency_minor.index', compact('certs', 'residents'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'resident_id' => 'required|exists:tblresidents,id',
            'purpose' => 'required|string|max:255',
            'purok' => 'required|string|max:100',
            'childsName' => 'required|string|max:100',
            'childsAge' => 'required|string|max:10',
            'childsGender' => 'required|string|max:10',
            'date_of_issuance' => 'required|date',
            'or_number' => 'nullable|string|max:50',
            'amount_paid' => 'nullable|numeric|min:0',
            'remarks' => 'nullable|string'
        ]);

        CertIndigencyMinor::create($validated);

        return redirect()->route('cert_indigency_minor.index')
                         ->with('success', 'Certificate of Indigency for Minor issued successfully!');
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
            'date_of_issuance'
            => 'required|date',
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
}