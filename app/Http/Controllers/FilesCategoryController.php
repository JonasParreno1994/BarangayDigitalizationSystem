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
            $category = FilesCategoryModel::findOrFail($id);
            
            if ($category->documents()->count() > 0) {
                return redirect()->route('filescategory.index')
                    ->with('error', 'Cannot delete category because it has associated documents.');
            }
            
            $category->delete();
            
            return redirect()->route('filescategory.index')
                ->with('success', 'Category deleted successfully');
                
        } catch (\Exception $e) {
            return redirect()->route('filescategory.index')
                ->with('error', 'Error deleting category: ' . $e->getMessage());
        }
    }
}
