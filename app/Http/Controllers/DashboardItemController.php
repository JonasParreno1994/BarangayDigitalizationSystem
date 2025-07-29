<?php

namespace App\Http\Controllers;

use App\Models\DashboardItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DashboardItemController extends Controller
{
    public function index()
    {
        $items = DashboardItem::all();
        return view('dashboard.items.index', compact('items'));
    }

    public function overview(){
        $dashboardItems = DashboardItem::all();
        return view('dashboard.overview', compact('dashboardItems'));
    }

    public function create()
    {
        return view('dashboard.items.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'image1' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'image2' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'image3' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'image4' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'image5' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description1' => 'required|string|max:255',
            'description2' => 'required|string|max:255',
            'description3' => 'required|string|max:255',
            'description4' => 'required|string|max:255',
            'description5' => 'required|string|max:255',
        ]);

        $data = $request->except(['image1', 'image2', 'image3', 'image4', 'image5']);

        // Handle image uploads
        for ($i = 1; $i <= 5; $i++) {
            if ($request->hasFile("image$i")) {
                $path = $request->file("image$i")->store('dashboard_images', 'public');
                $data["image{$i}_path"] = str_replace('public/', '', $path);
            }
        }

        DashboardItem::create($data);

        return redirect()->route('dashboard-items.index')
            ->with('success', 'Dashboard item created successfully.');
    }

    public function edit(DashboardItem $dashboard_item)
    {
        return view('dashboard.items.edit', compact('dashboard_item'));
    }

    public function update(Request $request, DashboardItem $dashboard_item)
    {
        $request->validate([
            'image1' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'image2' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'image3' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'image4' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'image5' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description1' => 'required|string|max:255',
            'description2' => 'required|string|max:255',
            'description3' => 'required|string|max:255',
            'description4' => 'required|string|max:255',
            'description5' => 'required|string|max:255',
        ]);

        $data = $request->except(['image1', 'image2', 'image3', 'image4', 'image5']);

        // Handle image uploads
        for ($i = 1; $i <= 5; $i++) {
            if ($request->hasFile("image$i")) {
                // Delete old image if exists
                if ($dashboard_item->{"image{$i}_path"}) {
                    Storage::delete('public/' . $dashboard_item->{"image{$i}_path"});
                }
                
                $path = $request->file("image$i")->store('public/dashboard_images');
                $data["image{$i}_path"] = str_replace('public/', '', $path);
            }
        }

        $dashboard_item->update($data);

        return redirect()->route('dashboard-items.index')
            ->with('success', 'Dashboard item updated successfully.');
    }

    public function destroy(DashboardItem $dashboard_item)
    {
        // Delete all associated images
        for ($i = 1; $i <= 5; $i++) {
            if ($dashboard_item->{"image{$i}_path"}) {
                Storage::delete('public/' . $dashboard_item->{"image{$i}_path"});
            }
        }

        $dashboard_item->delete();

        return redirect()->route('dashboard-items.index')
            ->with('success', 'Dashboard item deleted successfully.');
    }
}