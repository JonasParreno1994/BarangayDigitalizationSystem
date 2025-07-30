<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\FilesCategoryModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    public function index()
    {
        $categories = FilesCategoryModel::all();
        $documents = Document::with(['category', 'user'])->latest()->get();
        return view('documents.index', compact('documents','categories'));
    }

    public function create()
    {
        $categories = FilesCategoryModel::all();
        return view('documents.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:tblfilescategory,id',
            'document' => 'required|file|mimes:pdf,doc,docx,xls,xlsx,jpg,jpeg,png|max:30720',
        ]);

        $file = $request->file('document');
        $filePath = $file->store('public/documents');

        Document::create([
            'title' => $request->title,
            'description' => $request->description,
            'file_path' => $filePath,
            'category_id' => $request->category_id,
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('documents.index')->with('success', 'Document uploaded successfully.');
    }

    public function show(Document $document)
    {
        return view('documents.show', compact('document'));
    }

    public function edit(Document $document)
    {
        $categories = FilesCategoryModel::all();
        return view('documents.edit', compact('document', 'categories'));
    }

    public function update(Request $request, Document $document)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:tblfilescategory,id',
            'document' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,jpg,jpeg,png|max:30720',
        ]);

        $data = [
            'title' => $request->title,
            'description' => $request->description,
            'category_id' => $request->category_id,
        ];

        if ($request->hasFile('document')) {
            // Delete old file
            Storage::delete($document->file_path);
            
            // Store new file
            $file = $request->file('document');
            $data['file_path'] = $file->store('public/documents');
        }

        $document->update($data);

        return redirect()->route('documents.index')->with('success', 'Document updated successfully.');
    }

    public function destroy(Document $document)
    {
        Storage::delete($document->file_path);
        $document->delete();
        return redirect()->route('documents.index')->with('success', 'Document deleted successfully.');
    }

    public function download(Document $document)
    {
        return Storage::download($document->file_path);
    }
}