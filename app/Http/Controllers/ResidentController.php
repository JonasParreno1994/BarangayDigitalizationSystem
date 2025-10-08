<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ResidentModel;
use App\Models\Purok;
use App\Models\BarangayIdDetail;
use App\Models\BarangayClearance;
use App\Models\CertificateOfIndigency;
use App\Models\File;
use App\Models\BarangayGoodMoralCertificate;
use App\Models\CertificateOfResidency;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;


class ResidentController extends Controller
{
    public function index()
    {
        $resident = ResidentModel::with('purok')->get();
        return view('residentFolder.index', compact('resident'));
    }

    public function create()
    {
        $puroks = Purok::all();
        return view('residentFolder.create', compact('puroks'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'last_name' => 'required|string|max:255',
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'suffix' => 'nullable|string|max:10',
            'birth_date' => 'required|date',
            'birth_place' => 'required|string|max:255',
            'sex' => 'required|string|in:Male,Female',
            'civil_status' => 'required|string|in:Single,Married,Widowed,Separated',
            'religion' => 'nullable|string|max:255',
            'citizenship' => 'required|string|max:255',
            'purok_id' => 'required|exists:puroks,id',
            'address' => 'nullable|string|max:500',
            'occupation' => 'nullable|string|max:255',
            'contact_number' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif,jfif|max:2048',
            'voter_status' => 'required|string|in:Voter,Non-Voter',
            'precinct_number' => 'nullable|string|max:50',
            'education' => 'nullable|string|max:255',
            'education_status' => 'nullable|string|max:255',
            'household_number' => 'required|string|max:50',
            'region' => 'required|string|max:255',
            'province' => 'required|string|max:255',
            'city_municipality' => 'required|string|max:255',
            'barangay' => 'required|string|max:255',
            'census_no' => 'nullable|string|max:255',
            'is_senior_citizen' => 'nullable|boolean',
            'senior_citizen_id' => 'nullable|string|max:50',
            'is_pwd' => 'nullable|boolean',
            'pwd_id' => 'nullable|string|max:50',
            'pwd_type' => 'nullable|string|max:50',
            'is_solo_parent' => 'nullable|boolean',
            'solo_parent_id' => 'nullable|string|max:50',
            'number_of_children' => 'nullable|integer|min:0|max:20',
            'is_indigenous' => 'nullable|boolean',
            'is_ofw' => 'nullable|boolean',
            'ofw_country' => 'nullable|string|max:255',
            'is_unemployed' => 'nullable|boolean',
        ]);

        try {
            // Handle file upload
            if ($request->hasFile('profile_picture')) {
                $image = $request->file('profile_picture');
                $filename = time() . '.' . $image->getClientOriginalExtension();
                $path = $image->storeAs('public/profile_pictures', $filename);
                $validatedData['profile_picture'] = 'profile_pictures/' . $filename;
            }

            // Get purok name and set as address
            $purok = Purok::find($validatedData['purok_id']);
            $validatedData['address'] = $purok->purok_name;

            $resident = ResidentModel::create($validatedData);
            return redirect()->route('resident.index')
                ->with('success', 'Resident record created successfully!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error creating resident record: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function updateStatus(Request $request, $id)
    {
        $validatedData = $request->validate([
            'status' => 'required|string|in:Active,Transferred Residence,Deceased'
        ]);

        try {
            $resident = ResidentModel::findOrFail($id);
            $resident->update($validatedData);
            
            return response()->json([
                'success' => true,
                'message' => 'Status updated successfully!',
                'new_status' => $validatedData['status']
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating status: ' . $e->getMessage()
            ], 500);
        }
    }

    public function print($id)
    {
        $resident = ResidentModel::with('purok')->findOrFail($id);
        return view('residentFolder.print', compact('resident'));
    }

    public function printid($id)
    {
        $resident = ResidentModel::with('purok')->findOrFail($id);
        $barangayDetails = BarangayIdDetail::first();
        
        // If no barangay details exist, create one with defaults
        if (!$barangayDetails) {
            $barangayDetails = (object) BarangayIdDetail::getDefaultEnhancedData();
        }
        
        // Ensure profile pictures directory exists
        $profilePicturesPath = storage_path('app/public/profile_pictures');
        if (!file_exists($profilePicturesPath)) {
            mkdir($profilePicturesPath, 0755, true);
        }
        
        $birthDate = new \DateTime($resident->birth_date);
        $today = new \DateTime();
        $age = $today->diff($birthDate)->y;
        
        $address = ($resident->purok ? $resident->purok->purok_name : $resident->address) . ', ' . $resident->barangay;
        
        $middleInitial = $resident->middle_name ? substr($resident->middle_name, 0, 1) . '.' : '';
        $fullName = $resident->first_name . ' ' . $middleInitial . ' ' . $resident->last_name;
        $fullName = preg_replace('/\s+/', ' ', trim($fullName));
        
        $qrCode = QrCode::size(80)->generate($resident->household_number ?? 'MHBB-' . date('Y') . '-' . str_pad($resident->id, 4, '0', STR_PAD_LEFT));
        
        return view('residentFolder.printid', compact(
            'resident', 
            'age', 
            'address', 
            'fullName',
            'qrCode',
            'barangayDetails'
        ));
    }

    public function view($id)
    {
        $resident = ResidentModel::with('purok')->findOrFail($id);
        return view('residentFolder.view', compact('resident'));
    }

    public function printrbi($id)
    {
        $resident = ResidentModel::with('purok')->findOrFail($id);
        
        $birthDate = new \DateTime($resident->birth_date);
        $today = new \DateTime();
        $age = $today->diff($birthDate)->y;
        
        $address = ($resident->purok ? $resident->purok->purok_name : $resident->address) . ', ' . $resident->barangay;
        
        $middleInitial = $resident->middle_name ? substr($resident->middle_name, 0, 1) . '.' : '';
        $fullName = $resident->first_name . ' ' . $middleInitial . ' ' . $resident->last_name;
        $fullName = preg_replace('/\s+/', ' ', trim($fullName));
        
        return view('residentFolder.printrbi', compact(
            'resident', 
            'age', 
            'address', 
            'fullName'
        ));
    }

      public function edit($id)
    {
        $resident = ResidentModel::with('purok')->findOrFail($id);
        
        // Prevent editing deceased residents
        if ($resident->status === 'Deceased') {
            return redirect()->route('resident.index')
                ->with('error', 'Cannot edit a deceased resident.');
        }
        
        $puroks = Purok::all();
        return view('residentFolder.edit', compact('resident', 'puroks'));
    }

    public function update(Request $request, $id)
    {
        \Log::info('Update method called for resident: ' . $id);
        \Log::info($request->all());
        
        $validatedData = $request->validate([
            'last_name' => 'required|string|max:255',
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'suffix' => 'nullable|string|max:10',
            'birth_date' => 'required|date',
            'birth_place' => 'required|string|max:255',
            'sex' => 'required|string|in:Male,Female',
            'civil_status' => 'required|string|in:Single,Married,Widowed,Separated',
            'religion' => 'nullable|string|max:255',
            'citizenship' => 'required|string|max:255',
            'purok_id' => 'required|exists:puroks,id',
            'address' => 'nullable|string|max:500',
            'occupation' => 'nullable|string|max:255',
            'contact_number' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif,jfif|max:2048',
            'voter_status' => 'required|string|in:Voter,Non-Voter',
            'precinct_number' => 'nullable|string|max:50',
            'education' => 'nullable|string|max:255',
            'education_status' => 'nullable|string|max:255',
            'household_number' => 'required|string|max:50',
            'region' => 'required|string|max:255',
            'province' => 'required|string|max:255',
            'city_municipality' => 'required|string|max:255',
            'barangay' => 'required|string|max:255',
            'census_no' => 'nullable|string|max:255',
            'is_senior_citizen' => 'nullable|boolean',
            'senior_citizen_id' => 'nullable|string|max:50',
            'is_pwd' => 'nullable|boolean',
            'pwd_id' => 'nullable|string|max:50',
            'pwd_type' => 'nullable|string|max:50',
            'is_solo_parent' => 'nullable|boolean',
            'solo_parent_id' => 'nullable|string|max:50',
            'number_of_children' => 'nullable|integer|min:0|max:20',
            'is_indigenous' => 'nullable|boolean',
            'is_ofw' => 'nullable|boolean',
            'ofw_country' => 'nullable|string|max:255',
            'is_unemployed' => 'nullable|boolean',
        ]);

        try {
            $resident = ResidentModel::findOrFail($id);
            
            if ($request->hasFile('profile_picture')) {
                if ($resident->profile_picture) {
                    Storage::delete('public/' . $resident->profile_picture);
                }

                // Prevent updating deceased residents
            if ($resident->status === 'Deceased') {
                return redirect()->route('resident.index')
                    ->with('error', 'Cannot update a deceased resident.');
            }
                
                $image = $request->file('profile_picture');
                $filename = time() . '.' . $image->getClientOriginalExtension();
                $path = $image->storeAs('public/profile_pictures', $filename);
                $validatedData['profile_picture'] = 'profile_pictures/' . $filename;
            }

            // Update address with purok name
            $purok = Purok::find($validatedData['purok_id']);
            $validatedData['address'] = $purok->purok_name;

            $resident->update($validatedData);
            
            return redirect()->route('resident.index')
                ->with('success', 'Resident record updated successfully!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error updating resident record: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            $resident = ResidentModel::findOrFail($id);
            
           
            \App\Models\BarangayClearance::where('resident_id', $id)->delete();
            \App\Models\CertificateOfIndigency::where('resident_id', $id)->delete();
            \App\Models\CertificateOfResidency::where('resident_id', $id)->delete();
            \App\Models\File::where('resident_id', $id)->delete();


            
            $goodMorals = \App\Models\BarangayGoodMoralCertificate::where('resident_id', $id)->get();
            foreach ($goodMorals as $certificate) {
                if (method_exists($certificate, 'forceDelete')) {
                    $certificate->forceDelete();
                } else {
                    $certificate->delete();
                }
            }
            
            if ($resident->profile_picture) {
                Storage::delete('public/' . $resident->profile_picture);
            }
            
            $resident->delete();
            
            return redirect()->route('resident.index')
                ->with('success', 'Resident and all associated certificates deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->route('resident.index')
                ->with('error', 'Error deleting resident: ' . $e->getMessage());
        }
    }

    /**
     * Search residents for auto-fill functionality
     */
    public function search(Request $request)
    {
        $query = $request->get('query');
        
        if (empty($query)) {
            return response()->json([]);
        }

        $residents = ResidentModel::where(function($q) use ($query) {
                $q->where('first_name', 'LIKE', "%{$query}%")
                  ->orWhere('last_name', 'LIKE', "%{$query}%")
                  ->orWhere('middle_name', 'LIKE', "%{$query}%")
                  ->orWhereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ["%{$query}%"])
                  ->orWhereRaw("CONCAT(first_name, ' ', COALESCE(middle_name, ''), ' ', last_name) LIKE ?", ["%{$query}%"]);
            })
            ->where('status', '!=', 'Deceased')
            ->select('id', 'first_name', 'middle_name', 'last_name', 'suffix', 'birth_date', 'birth_place', 
                     'sex', 'civil_status', 'citizenship', 'occupation')
            ->limit(10)
            ->get();

        return response()->json($residents->map(function($resident) {
            return [
                'id' => $resident->id,
                'full_name' => $resident->getFullNameAttribute(),
                'first_name' => $resident->first_name,
                'middle_name' => $resident->middle_name,
                'last_name' => $resident->last_name,
                'suffix' => $resident->suffix,
                'birth_date' => $resident->birth_date ? $resident->birth_date->format('Y-m-d') : null,
                'birth_place' => $resident->birth_place,
                'sex' => $resident->sex,
                'civil_status' => $resident->civil_status,
                'citizenship' => $resident->citizenship,
                'occupation' => $resident->occupation,
            ];
        }));
    }
}