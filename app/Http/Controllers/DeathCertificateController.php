<?php

namespace App\Http\Controllers;

use App\Models\DeathCertificate;
use App\Models\ResidentModel; 
use App\Models\Purok;
use App\Models\BarangayIdDetail;
use App\Models\Official;
use Illuminate\Http\Request;

class DeathCertificateController extends Controller
{
    public function index()
    {
        $deathCertificates = DeathCertificate::with('resident')->latest()->get();
        $residents = ResidentModel::orderBy('last_name')->get();
        return view('death-certificate.index', compact('deathCertificates', 'residents'));
    }

    public function create()
    {
        $residents = ResidentModel::orderBy('last_name')->get();
        return view('death-certificate.create', compact('residents'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'resident_id' => 'required|exists:tblresidents,id',
            'date_of_death' => 'required|date',
            'time_of_death' => 'nullable|date_format:H:i',
            'place_of_death' => 'required|string|max:255',
            'cause_of_death' => 'required|string|max:255',
            'civil_status_at_death' => 'required|string|max:255',
            'purok' => 'nullable|string|max:50',
            'date_of_issuance' => 'required|date',
            'status' => 'required|string|in:Issued,Pending,Cancelled',
            'remarks' => 'nullable|string',
        ]);

        DeathCertificate::create($validated);

        return redirect()->route('death-certificate.index')
            ->with('success', 'Death Certificate issued successfully.');
    }

    public function show(DeathCertificate $deathCertificate)
    {
        return view('death-certificate.show', compact('deathCertificate'));
    }

    public function edit(DeathCertificate $deathCertificate)
    {
        $residents = ResidentModel::orderBy('last_name')->get();
        return view('death-certificate.edit', compact('deathCertificate', 'residents'));
    }

    public function update(Request $request, DeathCertificate $deathCertificate)
    {
        $validated = $request->validate([
            'resident_id' => 'required|exists:tblresidents,id',
            'date_of_death' => 'required|date',
            'time_of_death' => 'nullable|date_format:H:i',
            'place_of_death' => 'required|string|max:255',
            'cause_of_death' => 'required|string|max:255',
            'civil_status_at_death' => 'required|string|max:255',
            'purok' => 'nullable|string|max:50',
            'date_of_issuance' => 'required|date',
            'status' => 'required|string|in:Issued,Pending,Cancelled',
            'remarks' => 'nullable|string',
        ]);

        $deathCertificate->update($validated);

        return redirect()->route('death-certificate.index')
            ->with('success', 'Death Certificate updated successfully.');
    }

    public function destroy(DeathCertificate $deathCertificate)
    {
        $deathCertificate->delete();

        return redirect()->route('death-certificate.index')
            ->with('success', 'Death Certificate deleted successfully.');
    }

    public function print(DeathCertificate $deathCertificate){
        $barangayDetails = BarangayIdDetail::first();
        $officials = Official::with('position')->get();

        $official_pos3 = $officials->first(fn($official) =>
            stripos($official->position->name, 'Barangay Secretary') !== false
        );

        return view('death-certificate.print', compact('deathCertificate', 'barangayDetails', 'officials', 'official_pos3'));
    }
}