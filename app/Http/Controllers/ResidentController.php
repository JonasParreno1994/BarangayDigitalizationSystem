<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ResidentModel;
use App\Models\Purok;
use App\Models\BarangayIdDetail;
use App\Models\BarangayClearance;
use App\Models\CertificateOfIndigency;
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

    public function print($id)
    {
        $resident = ResidentModel::with('purok')->findOrFail($id);
        return view('residentFolder.print', compact('resident'));
    }

    public function printid($id)
    {
        $resident = ResidentModel::with('purok')->findOrFail($id);
        $barangayDetails = BarangayIdDetail::first();
        
        $birthDate = new \DateTime($resident->birth_date);
        $today = new \DateTime();
        $age = $today->diff($birthDate)->y;
        
        $address = ($resident->purok ? $resident->purok->purok_name : $resident->address) . ', ' . $resident->barangay;
        
        $middleInitial = $resident->middle_name ? substr($resident->middle_name, 0, 1) . '.' : '';
        $fullName = $resident->first_name . ' ' . $middleInitial . ' ' . $resident->last_name;
        $fullName = preg_replace('/\s+/', ' ', trim($fullName));
        
        $qrCode = QrCode::size(80)->generate($resident->household_number);
        
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

    public function edit($id)
    {
        $resident = ResidentModel::with('purok')->findOrFail($id);
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
        ]);

        try {
            $resident = ResidentModel::findOrFail($id);
            
            if ($request->hasFile('profile_picture')) {
                if ($resident->profile_picture) {
                    Storage::delete('public/' . $resident->profile_picture);
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
}