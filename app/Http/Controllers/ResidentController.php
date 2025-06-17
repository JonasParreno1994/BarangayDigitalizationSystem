<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ResidentModel;
use Illuminate\Support\Facades\DB;

class ResidentController extends Controller
{
    public function index()
    {
        $resident = ResidentModel::all();
        return view('residentFolder.index', compact('resident'));
    }

    public function store(Request $request){
    $validated = $request->validate([
        'last_name' => 'required',
        'first_name' => 'required',
        'birth_date' => 'required|date',
        'sex' => 'required',
        'civil_status' => 'required',
        'citizenship' => 'required',
        'address' => 'required',
        'voter_status' => 'required|in:Voter,Non-Voter',
        'voter_id' => 'nullable|required_if:voter_status,Voter',
        'precinct_number' => 'nullable|required_if:voter_status,Voter'
        // Add validation for other required fields
    ]);

    ResidentModel::create($validated);

    return redirect()->route('resident.index')
        ->with('success', 'Resident added successfully');
    }


}
