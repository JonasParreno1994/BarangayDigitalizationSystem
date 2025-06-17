<?php

namespace App\Http\Controllers;

use App\Models\Official;
use App\Models\Position;
use App\Models\ComelecModel;
use Illuminate\Http\Request;


class OfficialController extends Controller
{
    public function index()
    {
        $officials = Official::with(['position', 'comelec'])->get();
        $positions = Position::all();
        $comelecs = Position::all();
        return view('officials.index', compact('officials', 'positions', 'comelecs'));
    }

    public function getComelecData()
    {
        $data = ComelecModel::orderBy('name', 'ASC')->get();
        return response()->json($data);
        
    }

    public function create()
    {
        $positions = Position::all();
        return view('officials.create', compact('positions'));
        
        
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'position_id' => 'required|exists:tblposition,id', 
            'committee' => 'nullable|string|max:255',
            'status' => 'required|in:Active,Inactive'
        ]);
    
        Official::create($validated);
        return redirect()->route('officials.index')->with('success', 'Official added successfully');
    }

    public function edit($id)
    {
        $official = Official::findOrFail($id);
        $positions = Position::all();
        return view('officials.edit', compact('official', 'positions'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'position_id' => 'required|exists:positions,id',
            'committee' => 'nullable|string|max:255',
            'status' => 'required|in:Active,Inactive'
        ]);

        $official = Official::findOrFail($id);
        $official->update($validated);
        return redirect()->route('officials.index')->with('success', 'Official updated successfully');
    }

    public function destroy($id)
    {
        $official = Official::findOrFail($id);
        $official->delete();
        return redirect()->route('officials.index')->with('success', 'Official deleted successfully');
    }
}