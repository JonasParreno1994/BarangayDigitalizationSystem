<?php

namespace App\Http\Controllers;

use App\Models\ResidentModel;
use App\Models\CertificateOfDeath;
use App\Models\CertificationFooter;
use App\Models\BarangayIdDetail;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class CertificateOfDeathController extends Controller
{
    public function index()
    {
        $certificates = CertificateOfDeath::with('resident')->latest()->get();
        $residents = ResidentModel::where('status', '!=', 'Deceased')->get();
        return view('certificate_of_death.index', compact('certificates', 'residents'));
    }

    public function create()
    {
        $residents = ResidentModel::where('status', 'Deceased')->get();
        return view('certificate_of_death.create', compact('residents'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'resident_id' => [
                'required', 
                'exists:tblresidents,id',
                function ($attribute, $value, $fail) {
                    $existingCertificate = CertificateOfDeath::where('resident_id', $value)->first();
                    if ($existingCertificate) {
                        $fail('A death certificate already exists for this resident.');
                    }
                }
            ],
            'date_of_death' => 'required|date',
            'place_of_death' => 'required|string|max:255',
            'cause_of_death' => 'required|string|max:255',
            'date_of_issuance' => 'required|date',
            'certificate_number' => 'required|string|max:50|unique:certificate_of_death',
            'remarks' => 'nullable|string',
            'issued_by' => 'required|string|max:255',
        ]);

        // Create the death certificate
        $certificate = CertificateOfDeath::create($validated);
        
        // Update the resident's status to "Deceased"
        $resident = ResidentModel::find($validated['resident_id']);
        if ($resident) {
            $resident->update(['status' => 'Deceased']);
        }

        return redirect()->route('certificate-of-death.index')
            ->with('success', 'Death certificate created successfully and resident status updated to Deceased.');
    }

    public function show($id)
    {
        $certificate = CertificateOfDeath::with('resident')->findOrFail($id);
        return view('certificate_of_death.show', compact('certificate'));
    }

    public function edit($id)
    {
        $certificate = CertificateOfDeath::findOrFail($id);
        $residents = ResidentModel::where('status', 'Deceased')->get();
        return view('certificate_of_death.edit', compact('certificate', 'residents'));
    }

    public function update(Request $request, $id)
    {
        $certificate = CertificateOfDeath::findOrFail($id);

        $validated = $request->validate([
            'resident_id' => 'required|exists:tblresidents,id',
            'date_of_death' => 'required|date',
            'place_of_death' => 'required|string|max:255',
            'cause_of_death' => 'required|string|max:255',
            'date_of_issuance' => 'required|date',
            'certificate_number' => 'required|string|max:50|unique:certificate_of_death,certificate_number,'.$id,
            'remarks' => 'nullable|string',
            'issued_by' => 'required|string|max:255',
        ]);

        $certificate->update($validated);

        return redirect()->route('certificate-of-death.index')
            ->with('success', 'Death certificate updated successfully.');
    }

    public function destroy($id)
    {
        $certificate = CertificateOfDeath::findOrFail($id);
        $certificate->delete();

        return redirect()->route('certificate-of-death.index')
            ->with('success', 'Death certificate deleted successfully.');
    }

    public function print($id)
    {
        $certificate = CertificateOfDeath::with('resident')->findOrFail($id);
        $footer = CertificationFooter::first();
        $barangayDetails = BarangayIdDetail::first(); 
        $officials = \App\Models\Official::with('position')->get();
        
        $qrCode = QrCode::size(80)->generate(route('certificate-of-death.show', $id));
        
        return view('certificate_of_death.print', compact(
            'certificate', 
            'footer', 
            'qrCode',
            'barangayDetails',
            'officials'
        ));
    }
}