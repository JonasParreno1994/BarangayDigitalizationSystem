<?php

namespace App\Http\Controllers;

use App\Models\Purok;
use Illuminate\Http\Request;

class PurokController extends Controller
{
    public function index()
    {
        $puroks = Purok::all();
        return view('puroklist.puroklist', compact('puroks'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'purok_name' => 'required|string|max:255',
            'description' => 'nullable|string'
        ]);

        Purok::create($request->all());

        return redirect()->route('purok.index')
            ->with('success', 'Purok created successfully.');
    }

    public function destroy($id)
    {
        $purok = Purok::findOrFail($id);
        $purok->delete();

        return redirect()->route('purok.index')
            ->with('success', 'Purok deleted successfully');
    }
}