<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BarangayClearance;
use App\Models\BarangayIdDetail;
use App\Models\ResidentModel;
use App\Models\Official;

class BrgyclearanceController extends Controller
{
    public function index()
    {
        $clearances = BarangayClearance::with('resident')->latest()->get();
        $residents = ResidentModel::orderBy('last_name')->get();
        
        return view('barangayclearance.index', compact('clearances', 'residents'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'resident_id' => 'required|exists:tblresidents,id',
            'purpose' => 'required|string|max:255',
            'cedula_number' => 'nullable|string|max:50',
            'date_of_issuance' => 'required|date',
            'or_number' => 'nullable|string|max:50',
            'amount_paid' => 'nullable|numeric|min:0',
            'status' => 'required|in:Issued,Pending,Cancelled',
            'remarks' => 'nullable|string'
        ]);

        BarangayClearance::create($validated);

        return redirect()->route('barangayclearance.index')
                         ->with('success', 'Barangay Clearance issued successfully!');
    }

    public function show($id)
    {
        $clearance = BarangayClearance::with('resident')->findOrFail($id);
        return view('barangayclearance.show', compact('clearance'));
    }

    public function edit($id)
    {
        $clearance = BarangayClearance::findOrFail($id);
        $residents = ResidentModel::orderBy('last_name')->get();
        return view('barangayclearance.edit', compact('clearance', 'residents'));
    }

    public function update(Request $request, $id)
    {
        $clearance = BarangayClearance::findOrFail($id);
        
        $validated = $request->validate([
            'resident_id' => 'required|exists:tblresidents,id',
            'purpose' => 'required|string|max:255',
            'cedula_number' => 'nullable|string|max:50',
            'date_of_issuance' => 'required|date',
            'or_number' => 'nullable|string|max:50',
            'amount_paid' => 'nullable|numeric|min:0',
            'status' => 'required|in:Issued,Pending,Cancelled',
            'remarks' => 'nullable|string'
        ]);

        $clearance->update($validated);

        return redirect()->route('barangayclearance.index')
                         ->with('success', 'Barangay Clearance updated successfully!');
    }

    public function destroy($id)
    {
        $clearance = BarangayClearance::findOrFail($id);
        $clearance->delete();

        return redirect()->route('barangayclearance.index')
                         ->with('success', 'Barangay Clearance deleted successfully!');
    }

    public function print($id){
    $clearance = BarangayClearance::with('resident')->findOrFail($id);
    $barangayDetails = BarangayIdDetail::first(); 
    
 
    $officials = Official::with('position')
        ->active()
        ->get()
        ->sortBy(function($official) {
         
            if (str_contains($official->position->name, 'Punong Barangay')) {
                return 0;
            } elseif (str_contains($official->position->name, 'Secretary')) {
                return 1;
            } elseif (str_contains($official->position->name, 'Treasurer')) {
                return 2;
            } else {
                return 3;
            }
        });
    
    return view('barangayclearance.print', compact('clearance', 'barangayDetails', 'officials'));
    }
}