<?php

namespace App\Http\Controllers;

use App\Models\Household;
use App\Models\HouseholdMember;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class HouseholdController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $households = Household::with(['householdHead', 'members'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        return view('admin.households.index', compact('households'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.households.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'household_number' => 'nullable|string|unique:households,household_number',
            'region' => 'nullable|string|max:255',
            'province' => 'nullable|string|max:255',
            'city_municipality' => 'nullable|string|max:255',
            'barangay' => 'nullable|string|max:255',
            'household_address' => 'nullable|string|max:500',
        ]);

        $household = Household::create($validated);

        return redirect()->route('households.show', $household)
            ->with('success', 'Household created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Household $household)
    {
        $household->load(['members' => function($query) {
            $query->orderBy('is_head', 'desc')->orderBy('created_at', 'asc');
        }]);
        
        return view('admin.households.show', compact('household'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Household $household)
    {
        return view('admin.households.edit', compact('household'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Household $household)
    {
        $validated = $request->validate([
            'household_number' => [
                'required',
                'string',
                Rule::unique('households', 'household_number')->ignore($household->id)
            ],
            'region' => 'nullable|string|max:255',
            'province' => 'nullable|string|max:255',
            'city_municipality' => 'nullable|string|max:255',
            'barangay' => 'nullable|string|max:255',
            'household_address' => 'nullable|string|max:500',
            'status' => 'required|in:Active,Inactive',
        ]);

        $household->update($validated);

        return redirect()->route('households.index')
            ->with('success', 'Household updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Household $household)
    {
        $household->delete();

        return redirect()->route('households.index')
            ->with('success', 'Household deleted successfully.');
    }

    /**
     * Add member form
     */
    public function addMember(Household $household)
    {
        return view('admin.households.add-member', compact('household'));
    }

    /**
     * Store household member
     */
    public function storeMember(Request $request, Household $household)
    {
        $validated = $request->validate([
            'last_name' => 'required|string|max:255',
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'extension' => 'nullable|string|max:10',
            'place_of_birth' => 'nullable|string|max:255',
            'date_of_birth' => 'nullable|date',
            'sex' => 'required|in:Male,Female',
            'civil_status' => 'required|in:Single,Married,Widowed,Divorced,Separated',
            'citizenship' => 'nullable|string|max:255',
            'occupation' => 'nullable|string|max:255',
            'labor_employment_status' => 'nullable|in:Labor/employed,Unemployed,PWD,Solo Parent,Out of School Youth (OSY),Out of School Children (OSC),IP',
            'relationship_to_head' => 'nullable|string|max:255',
        ]);

        $validated['household_id'] = $household->id;
        
        // Handle checkbox - if not present, default to false
        $validated['is_head'] = $request->has('is_head') ? true : false;

        // If this member is marked as head, unmark other heads
        if ($validated['is_head']) {
            $household->members()->update(['is_head' => false]);
        }

        $member = HouseholdMember::create($validated);

        return redirect()->route('households.show', $household)
            ->with('success', 'Household member added successfully.');
    }

    /**
     * Edit household member
     */
    public function editMember(Household $household, HouseholdMember $member)
    {
        return view('admin.households.edit-member', compact('household', 'member'));
    }

    /**
     * Update household member
     */
    public function updateMember(Request $request, Household $household, HouseholdMember $member)
    {
        $validated = $request->validate([
            'last_name' => 'required|string|max:255',
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'extension' => 'nullable|string|max:10',
            'place_of_birth' => 'nullable|string|max:255',
            'date_of_birth' => 'nullable|date',
            'sex' => 'required|in:Male,Female',
            'civil_status' => 'required|in:Single,Married,Widowed,Divorced,Separated',
            'citizenship' => 'nullable|string|max:255',
            'occupation' => 'nullable|string|max:255',
            'labor_employment_status' => 'nullable|in:Labor/employed,Unemployed,PWD,Solo Parent,Out of School Youth (OSY),Out of School Children (OSC),IP',
            'relationship_to_head' => 'nullable|string|max:255',
        ]);

        // Handle checkbox - if not present, default to false
        $validated['is_head'] = $request->has('is_head') ? true : false;

        // If this member is marked as head, unmark other heads
        if ($validated['is_head'] && !$member->is_head) {
            $household->members()->where('id', '!=', $member->id)->update(['is_head' => false]);
        }

        $member->update($validated);

        return redirect()->route('households.show', $household)
            ->with('success', 'Household member updated successfully.');
    }

    /**
     * Delete household member
     */
    public function destroyMember(Household $household, HouseholdMember $member)
    {
        $member->delete();

        return redirect()->route('households.show', $household)
            ->with('success', 'Household member removed successfully.');
    }

    /**
     * Print household record
     */
    public function print(Household $household)
    {
        $household->load(['members' => function($query) {
            $query->orderBy('is_head', 'desc')->orderBy('created_at', 'asc');
        }]);
        
        return view('admin.households.print', compact('household'));
    }
}
