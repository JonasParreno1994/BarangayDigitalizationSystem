<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\ResidentModel;
use App\Models\FilesCategoryModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    public function index($residentId)
    {
        $resident = ResidentModel::with('files.category')->findOrFail($residentId);
        $categories = FilesCategoryModel::all();
        return view('files.index', compact('resident', 'categories'));
    }

    public function create($residentId)
    {
        $resident = ResidentModel::findOrFail($residentId);
        $categories = FilesCategoryModel::all();
        return view('files.create', compact('resident', 'categories'));
    }

    public function store(Request $request, $residentId)
    {
        $request->validate([
            'category_id' => 'required|exists:tblfilescategory,id',
            'file' => 'required|file|max:10240', // 10MB max
            'description' => 'nullable|string|max:500',
        ]);

        $resident = ResidentModel::findOrFail($residentId);

        try {
            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('resident_files', $fileName, 'public');

            File::create([
                'resident_id' => $resident->id,
                'category_id' => $request->category_id,
                'file_name' => $file->getClientOriginalName(),
                'file_path' => $filePath,
                'file_type' => $file->getClientMimeType(),
                'file_size' => $file->getSize(),
                'description' => $request->description,
                'upload_date' => now(),
            ]);

            return redirect()->route('resident.files.index', $resident->id)
                ->with('success', 'File uploaded successfully!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error uploading file: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function show($residentId, $fileId)
    {
        $file = File::where('resident_id', $residentId)->findOrFail($fileId);
        return view('files.show', compact('file'));
    }

    public function download($residentId, $fileId)
    {
        $file = File::where('resident_id', $residentId)->findOrFail($fileId);
        
        if (!Storage::disk('public')->exists($file->file_path)) {
            abort(404);
        }

        return Storage::disk('public')->download($file->file_path, $file->file_name);
    }

    public function destroy($residentId, $fileId)
    {
        $file = File::where('resident_id', $residentId)->findOrFail($fileId);
        
        try {
            Storage::disk('public')->delete($file->file_path);
            $file->delete();
            
            return redirect()->route('resident.files.index', $residentId)
                ->with('success', 'File deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->route('resident.files.index', $residentId)
                ->with('error', 'Error deleting file: ' . $e->getMessage());
        }
    }
}