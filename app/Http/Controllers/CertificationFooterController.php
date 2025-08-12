<?php

namespace App\Http\Controllers;

use App\Models\CertificationFooter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CertificationFooterController extends Controller
{
    public function index()
    {
        $footer = CertificationFooter::first();
        return view('certification-footer.index', compact('footer'));
    }

    public function create()
    {
        return view('certification-footer.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'picture1' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'logo1' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'logo1description' => 'nullable|string',
            'logo2' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'logo2description' => 'nullable|string',
            'logo3' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'logo3description' => 'nullable|string',
        ]);

        $data = $request->except(['picture1', 'logo1', 'logo2', 'logo3']);

        // Handle file uploads
        if ($request->hasFile('picture1')) {
            $data['picture1'] = $request->file('picture1')->store('certification_footer', 'public');
        }
        if ($request->hasFile('logo1')) {
            $data['logo1'] = $request->file('logo1')->store('certification_footer', 'public');
        }
        if ($request->hasFile('logo2')) {
            $data['logo2'] = $request->file('logo2')->store('certification_footer', 'public');
        }
        if ($request->hasFile('logo3')) {
            $data['logo3'] = $request->file('logo3')->store('certification_footer', 'public');
        }

        CertificationFooter::create($data);

        return redirect()->route('certification-footer.index')
            ->with('success', 'Certification footer created successfully.');
    }

    public function edit($id)
    {
        $footer = CertificationFooter::findOrFail($id);
        return view('certification-footer.edit', compact('footer'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'picture1' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'logo1' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'logo1description' => 'nullable|string',
            'logo2' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'logo2description' => 'nullable|string',
            'logo3' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'logo3description' => 'nullable|string',
        ]);

        $footer = CertificationFooter::findOrFail($id);
        $data = $request->except(['picture1', 'logo1', 'logo2', 'logo3', 'remove_picture1', 'remove_logo1', 'remove_logo2', 'remove_logo3']);

        // Handle file uploads and deletions
        $this->handleFileUpload($request, $footer, 'picture1', $data);
        $this->handleFileUpload($request, $footer, 'logo1', $data);
        $this->handleFileUpload($request, $footer, 'logo2', $data);
        $this->handleFileUpload($request, $footer, 'logo3', $data);

        // Handle image removal
        if ($request->has('remove_picture1') && $footer->picture1) {
            Storage::disk('public')->delete($footer->picture1);
            $data['picture1'] = null;
        }
        if ($request->has('remove_logo1') && $footer->logo1) {
            Storage::disk('public')->delete($footer->logo1);
            $data['logo1'] = null;
        }
        if ($request->has('remove_logo2') && $footer->logo2) {
            Storage::disk('public')->delete($footer->logo2);
            $data['logo2'] = null;
        }
        if ($request->has('remove_logo3') && $footer->logo3) {
            Storage::disk('public')->delete($footer->logo3);
            $data['logo3'] = null;
        }

        $footer->update($data);

        return redirect()->route('certification-footer.index')
            ->with('success', 'Certification footer updated successfully.');
    }

    protected function handleFileUpload($request, $footer, $field, &$data)
    {
        if ($request->hasFile($field)) {
            // Delete old file if exists
            if ($footer->$field) {
                Storage::disk('public')->delete($footer->$field);
            }
            // Store new file
            $data[$field] = $request->file($field)->store('certification_footer', 'public');
        }
    }
}