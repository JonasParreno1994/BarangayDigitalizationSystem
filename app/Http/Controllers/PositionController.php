<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Position;
use Illuminate\Support\Facades\DB;

class PositionController extends Controller
{
    public function index()
    {
        $position = Position::all();
        return view('positionFolder.index', compact('position'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'position' => 'required|string|max:255',
        ]);
    
        Position::create($validated);
        return redirect()->route('positionFolder.index')->with('success', 'Position added successfully');
    }
    
    public function destroy($id)
    {
        try {
            
            $position = Position::findOrFail($id);
            
          
            if ($position->officials()->count() > 0) {
                return redirect()->route('position.index')
                    ->with('error', 'Cannot delete position because it is assigned to one or more officials.');
            }
            
            
            $position->delete();
            
            return redirect()->route('position.index')
                ->with('success', 'Position deleted successfully');
                
        } catch (\Exeptions $e) {
            return redirect()->route('position.index')
                ->with('error', 'Error deleting position: ' . $e->getMessage());
        }
    }

  
}