<?php

namespace App\Http\Controllers;

use App\Models\BarangayDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BarangayDetailController extends Controller
{
    public function index()
    {
        $barangayDetails = BarangayDetail::first();
        return view('admin.barangay-details.index', compact('barangayDetails'));
    }

    public function create()
    {
        return view('admin.barangay-details.create');
    }

    public function store(Request $request)
    {
        $validated = $this->validateBarangayDetails($request);
        
        // Handle file uploads
        $validated = $this->handleFileUploads($request, $validated);
        
        // Apply default fee values for any null fees
        $validated = $this->applyDefaultFees($validated);
        
        BarangayDetail::create($validated);
        
        return redirect()->route('barangay-details.index')
            ->with('success', 'Barangay details created successfully!');
    }

    public function edit($id)
    {
        $barangayDetails = BarangayDetail::findOrFail($id);
        return view('admin.barangay-details.edit', compact('barangayDetails'));
    }

    public function update(Request $request, $id)
    {
        $barangayDetails = BarangayDetail::findOrFail($id);
        $validated = $this->validateBarangayDetails($request);
        
        // Handle file uploads
        $validated = $this->handleFileUploads($request, $validated, $barangayDetails);
        
        $barangayDetails->update($validated);
        
        return redirect()->route('barangay-details.index')
            ->with('success', 'Barangay details updated successfully!');
    }

    public function destroy($id)
    {
        $barangayDetails = BarangayDetail::findOrFail($id);
        
        // Delete associated files
        $this->deleteAssociatedFiles($barangayDetails);
        
        $barangayDetails->delete();
        
        return redirect()->route('barangay-details.index')
            ->with('success', 'Barangay details deleted successfully!');
    }

    private function validateBarangayDetails(Request $request)
    {
        return $request->validate([
            // Location Information
            'region' => 'nullable|string|max:255',
            'province' => 'nullable|string|max:255',
            'city_municipality' => 'nullable|string|max:255',
            'barangay_name' => 'required|string|max:255',
            'district' => 'nullable|string|max:255',
            'zip_code' => 'nullable|string|max:10',
            'complete_address' => 'nullable|string',
            
            // Official Information
            'captain_name' => 'nullable|string|max:255',
            'captain_title' => 'nullable|string|max:255',
            'secretary_name' => 'nullable|string|max:255',
            'secretary_title' => 'nullable|string|max:255',
            'treasurer_name' => 'nullable|string|max:255',
            'treasurer_title' => 'nullable|string|max:255',
            
            // Contact Information
            'barangay_contact' => 'nullable|string|max:255',
            'barangay_email' => 'nullable|email|max:255',
            'emergency_contact' => 'nullable|string|max:255',
            'office_hours' => 'nullable|string|max:255',
            
            // Header Information
            'heading1' => 'nullable|string|max:255',
            'heading2' => 'nullable|string|max:255',
            'heading3' => 'nullable|string|max:255',
            'document_footer' => 'nullable|string',
            
            // File uploads
            'logo1' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'logo2' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'municipal_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'captain_signature' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'secretary_signature' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            
            // Certificate Settings
            'certificate_validity_period' => 'nullable|string|max:255',
            'or_number_prefix' => 'nullable|string|max:10',
            'document_series_prefix' => 'nullable|string|max:10',
            
            // Fees
            'clearance_fee' => 'nullable|numeric|min:0',
            'residency_fee' => 'nullable|numeric|min:0',
            'indigency_fee' => 'nullable|numeric|min:0',
            'good_moral_fee' => 'nullable|numeric|min:0',
            'death_cert_fee' => 'nullable|numeric|min:0',
            'jobseeker_fee' => 'nullable|numeric|min:0',
            'id_replacement_fee' => 'nullable|numeric|min:0',
            
            // Additional Information
            'barangay_established_date' => 'nullable|date',
            'total_area' => 'nullable|string|max:255',
            'total_population' => 'nullable|integer|min:0',
            'total_households' => 'nullable|integer|min:0',
            'barangay_classification' => 'nullable|string|max:255',
            'income_classification' => 'nullable|string|max:255',
            
            'is_active' => 'boolean'
        ]);
    }

    private function handleFileUploads(Request $request, array $validated, $existingDetails = null)
    {
        $fileFields = [
            'logo1' => 'logo1_path',
            'logo2' => 'logo2_path',
            'municipal_logo' => 'municipal_logo_path',
            'captain_signature' => 'captain_signature_path',
            'secretary_signature' => 'secretary_signature_path'
        ];

        foreach ($fileFields as $inputName => $dbField) {
            if ($request->hasFile($inputName)) {
                // Delete old file if exists
                if ($existingDetails && $existingDetails->$dbField) {
                    Storage::disk('public')->delete($existingDetails->$dbField);
                }
                
                // Store new file
                $validated[$dbField] = $request->file($inputName)->store('barangay-files', 'public');
            }
        }

        return $validated;
    }

    private function deleteAssociatedFiles($barangayDetails)
    {
        $fileFields = ['logo1_path', 'logo2_path', 'municipal_logo_path', 'captain_signature_path', 'secretary_signature_path'];
        
        foreach ($fileFields as $field) {
            if ($barangayDetails->$field) {
                Storage::disk('public')->delete($barangayDetails->$field);
            }
        }
    }
}
