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
            'validity' => 'required|string|max:255',
            'details' => 'required|string',
            'pass_captain' => 'required|string|max:255',
            'signature' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $logo1Path = $request->file('logo1')->store('barangay-id/logos', 'public');
        $logo2Path = $request->file('logo2')->store('barangay-id/logos', 'public');
        $signaturePath = $request->file('signature')->store('barangay-id/signatures', 'public');

        BarangayIdDetail::create([
            'logo1_path' => $logo1Path,
            'logo2_path' => $logo2Path,
            'heading1' => $request->heading1,
            'heading2' => $request->heading2,
            'heading3' => $request->heading3,
            'validity' => $request->validity,
            'details' => $request->details,
            'pass_captain' => $request->pass_captain,
            'signature_path' => $signaturePath,
        ]);

        return redirect()->route('barangayid.index')->with('success', 'Barangay ID details added successfully.');
    }

    public function edit($id)
    {
        $item = BarangayIdDetail::findOrFail($id);
        return view('barangayidDetails.edit', compact('item'));
    }
    

    public function update(Request $request, $id)
    {
        $request->validate([
            'logo1' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'logo2' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'heading1' => 'required|string|max:255',
            'heading2' => 'required|string|max:255',
            'heading3' => 'required|string|max:255',
            'validity' => 'required|string|max:255',
            'details' => 'required|string',
            'pass_captain' => 'required|string|max:255',
            'signature' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $item = BarangayIdDetail::findOrFail($id);

        $data = [
            'heading1' => $request->heading1,
            'heading2' => $request->heading2,
            'heading3' => $request->heading3,
            'validity' => $request->validity,
            'details' => $request->details,
            'pass_captain' => $request->pass_captain,
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