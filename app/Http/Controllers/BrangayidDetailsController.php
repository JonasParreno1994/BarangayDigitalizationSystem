<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BarangayIdDetail;
use Illuminate\Support\Facades\Storage;

class BrangayidDetailsController extends Controller
{
    public function index()
    {
        $items = BarangayIdDetail::all();
        return view('barangayiddetails.index', compact('items'));
    }

    public function create()
    {
        return view('barangayiddetails.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'logo1' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'logo2' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'heading1' => 'required|string|max:255',
            'heading2' => 'required|string|max:255',
            'heading3' => 'required|string|max:255',
            'office_info' => 'nullable|string|max:255',
            'ordinance_info' => 'nullable|string|max:255',
            'validity' => 'required|string|max:255',
            'details' => 'required|string',
            'footer_text' => 'nullable|string',
            'card_title' => 'nullable|string|max:255',
            'back_header' => 'nullable|string|max:255',
            'back_certification' => 'nullable|string',
            'back_note' => 'nullable|string',
            'back_loss_info' => 'nullable|string',
            'emergency_contact_name' => 'nullable|string|max:255',
            'emergency_contact_number' => 'nullable|string|max:20',
            'emergency_contact_address' => 'nullable|string',
            'pass_captain' => 'required|string|max:255',
            'signature' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'card_color_scheme' => 'nullable|string|in:blue,green,red,purple',
            'include_fingerprint' => 'boolean',
            'include_qr_code' => 'boolean',
            'validity_years' => 'nullable|integer|min:1|max:10'
        ]);

        $logo1Path = $request->file('logo1')->store('barangay-id/logos', 'public');
        $logo2Path = $request->file('logo2')->store('barangay-id/logos', 'public');
        $signaturePath = $request->file('signature')->store('barangay-id/signatures', 'public');

        // Get default enhanced data and merge with request data
        $defaultData = BarangayIdDetail::getDefaultEnhancedData();
        
        $data = array_merge($defaultData, [
            'logo1_path' => $logo1Path,
            'logo2_path' => $logo2Path,
            'heading1' => $request->heading1,
            'heading2' => $request->heading2,
            'heading3' => $request->heading3,
            'office_info' => $request->office_info ?? $defaultData['office_info'],
            'ordinance_info' => $request->ordinance_info ?? $defaultData['ordinance_info'],
            'validity' => $request->validity,
            'details' => $request->details,
            'footer_text' => $request->footer_text ?? $defaultData['footer_text'],
            'card_title' => $request->card_title ?? $defaultData['card_title'],
            'back_header' => $request->back_header ?? $defaultData['back_header'],
            'back_certification' => $request->back_certification ?? $defaultData['back_certification'],
            'back_note' => $request->back_note ?? $defaultData['back_note'],
            'back_loss_info' => $request->back_loss_info ?? $defaultData['back_loss_info'],
            'emergency_contact_name' => $request->emergency_contact_name ?? $defaultData['emergency_contact_name'],
            'emergency_contact_number' => $request->emergency_contact_number ?? $defaultData['emergency_contact_number'],
            'emergency_contact_address' => $request->emergency_contact_address ?? $defaultData['emergency_contact_address'],
            'pass_captain' => $request->pass_captain,
            'signature_path' => $signaturePath,
            'card_color_scheme' => $request->card_color_scheme ?? $defaultData['card_color_scheme'],
            'include_fingerprint' => $request->boolean('include_fingerprint', $defaultData['include_fingerprint']),
            'include_qr_code' => $request->boolean('include_qr_code', $defaultData['include_qr_code']),
            'validity_years' => $request->validity_years ?? $defaultData['validity_years']
        ]);

        BarangayIdDetail::create($data);

        return redirect()->route('barangayid.index')->with('success', 'Barangay ID details added successfully.');
    }

    public function edit($id)
    {
        $item = BarangayIdDetail::findOrFail($id);
        return view('barangayiddetails.edit_enhanced', compact('item'));
    }
    

    public function update(Request $request, $id)
    {
        $request->validate([
            'logo1' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'logo2' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'heading1' => 'required|string|max:255',
            'heading2' => 'required|string|max:255',
            'heading3' => 'required|string|max:255',
            'office_info' => 'nullable|string|max:255',
            'ordinance_info' => 'nullable|string|max:255',
            'validity' => 'required|string|max:255',
            'details' => 'required|string',
            'footer_text' => 'nullable|string',
            'card_title' => 'nullable|string|max:255',
            'back_header' => 'nullable|string|max:255',
            'back_certification' => 'nullable|string',
            'back_note' => 'nullable|string',
            'back_loss_info' => 'nullable|string',
            'emergency_contact_name' => 'nullable|string|max:255',
            'emergency_contact_number' => 'nullable|string|max:20',
            'emergency_contact_address' => 'nullable|string',
            'pass_captain' => 'required|string|max:255',
            'signature' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'card_color_scheme' => 'nullable|string|in:blue,green,red,purple',
            'include_fingerprint' => 'boolean',
            'include_qr_code' => 'boolean',
            'validity_years' => 'nullable|integer|min:1|max:10'
        ]);

        $item = BarangayIdDetail::findOrFail($id);

        $data = [
            'heading1' => $request->heading1,
            'heading2' => $request->heading2,
            'heading3' => $request->heading3,
            'office_info' => $request->office_info,
            'ordinance_info' => $request->ordinance_info,
            'validity' => $request->validity,
            'details' => $request->details,
            'footer_text' => $request->footer_text,
            'card_title' => $request->card_title,
            'back_header' => $request->back_header,
            'back_certification' => $request->back_certification,
            'back_note' => $request->back_note,
            'back_loss_info' => $request->back_loss_info,
            'emergency_contact_name' => $request->emergency_contact_name,
            'emergency_contact_number' => $request->emergency_contact_number,
            'emergency_contact_address' => $request->emergency_contact_address,
            'pass_captain' => $request->pass_captain,
            'card_color_scheme' => $request->card_color_scheme ?? 'blue',
            'include_fingerprint' => $request->boolean('include_fingerprint', true),
            'include_qr_code' => $request->boolean('include_qr_code', true),
            'validity_years' => $request->validity_years ?? 3
        ];

        if ($request->hasFile('logo1')) {
            Storage::delete('public/' . $item->logo1_path);
            $data['logo1_path'] = $request->file('logo1')->store('barangay-id/logos', 'public');
        }

        if ($request->hasFile('logo2')) {
            Storage::delete('public/' . $item->logo2_path);
            $data['logo2_path'] = $request->file('logo2')->store('barangay-id/logos', 'public');
        }

        if ($request->hasFile('signature')) {
            Storage::delete('public/' . $item->signature_path);
            $data['signature_path'] = $request->file('signature')->store('barangay-id/signatures', 'public');
        }

        $item->update($data);

        return redirect()->route('barangayid.index')->with('success', 'Barangay ID details updated successfully.');
    }

    public function destroy($id)
    {
        $item = BarangayIdDetail::findOrFail($id);
        
        Storage::delete([
            'public/' . $item->logo1_path,
            'public/' . $item->logo2_path,
            'public/' . $item->signature_path,
        ]);
        
        $item->delete();

        return redirect()->route('barangayid.index')->with('success', 'Barangay ID details deleted successfully.');
    }
}