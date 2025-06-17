<?php

namespace App\Http\Controllers;
use App\Models\FilesCategoryModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FilesCategoryController extends Controller
{
    public function index()
    {
        $filescategory = FilesCategoryModel::all();
        return view('filesCategory.index', compact('filescategory'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_name' => 'required|string|max:255',
        ]);
    
        FilesCategoryModel::create($validated);
        return redirect()->route('filescategory.index')->with('success', 'Files Category added successfully');
    }

    public function destroy($id)
    {
        try {
            
            $filescategory = FilesCategoryModel::findOrFail($id);
            
          
            if ($filescategory->filescategory()->count() > 0) {
                return redirect()->route('filescategory.index')
                    ->with('error', 'Cannot delete position because it is assigned to one or more officials.');
            }
            
            
            $position->delete();
            
            return redirect()->route('filescategory.index')
                ->with('success', 'Files Category deleted successfully');
                
        } catch (\Exeptions $e) {
            return redirect()->route('filescategory.index')
                ->with('error', 'Error deleting position: ' . $e->getMessage());
        }
    }
}
