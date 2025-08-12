@extends('layouts.adminLayout.index')
@section('content')
<style>
.form-input, .form-select, .form-textarea {
    width: 100%;
    padding: 0.5rem;
    border: 1px solid #d1d5db;
    border-radius: 0.375rem;
    background-color: #fff;
}

.form-input:focus, .form-select:focus, .form-textarea:focus {
    outline: none;
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}

.form-label {
    display: block;
    margin-bottom: 0.5rem;
    font-weight: 500;
    color: #374151;
}

.bg-blue-50 {
    background-color: #eff6ff;
}
</style>

@if(session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: '{{ session('success') }}',
                timer: 3000,
                showConfirmButton: false
            });
        });
    </script>
@endif

@if(session('error'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: '{{ session('error') }}',
                timer: 3000,
                showConfirmButton: false
            });
        });
    </script>
@endif

<div class="p-6">
    <div class="panel flex items-center overflow-x-auto whitespace-nowrap p-3 text-primary text-2xl font-bold">
        <h1 class="ltr:mr-4 rtl:ml-3 text-center w-full">Edit Resident Record</h1>
    </div>
    
    <div class="panel mt-6">
        <form id="residentForm" action="{{ route('resident.update', $resident->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Comelec Search Section -->
            <div x-data="comelecSearch()" class="mb-6">
                <label class="form-label">Search Voter Records</label>
                <div class="relative">
                    <input 
                        type="text"
                        x-model="query"
                        @input.debounce.300ms="search"
                        @keydown.arrow-down="highlightNext"
                        @keydown.arrow-up="highlightPrev"
                        @keydown.enter="selectHighlighted"
                        class="form-input w-full pl-10"
                        placeholder="TYPE VOTER NAME..."
                    >
                    <!-- Search icon -->
                    <div class="absolute left-3 top-2.5 text-gray-400">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="11" cy="11" r="8"></circle>
                            <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                        </svg>
                    </div>
                    
                    <!-- Loading indicator -->
                    <div x-show="loading" class="absolute right-3 top-2.5 text-gray-400">
                        <svg class="animate-spin h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </div>
                    
                    <!-- Results dropdown -->
                    <div x-show="query.length > 1 && results.length > 0" 
                         x-transition
                         class="absolute z-50 w-full mt-1 bg-white border border-gray-200 rounded-md shadow-lg max-h-60 overflow-y-auto">
                        <template x-for="(result, index) in results" :key="result.id">
                            <div 
                                class="px-4 py-2 hover:bg-gray-100 cursor-pointer"
                                :class="{ 'bg-blue-50': highlightedIndex === index }"
                                @click="selectResult(result)"
                                @mouseenter="highlightedIndex = index"
                            >
                                <div class="font-medium" x-text="result.name"></div>
                                <div class="text-sm text-gray-500">
                                    <span x-text="result.barangay"></span> | 
                                    <span x-text="result.precinct_no"></span>
                                </div>
                            </div>
                        </template>
                    </div>
                    
                    <!-- No results -->
                    <div x-show="query.length > 1 && !loading && results.length === 0"
                         class="absolute z-50 w-full mt-1 bg-white border border-gray-200 rounded-md shadow-lg px-4 py-2 text-gray-500">
                        No voters found
                    </div>
                </div>
            </div>
            
            <script>
            document.addEventListener('alpine:init', () => {
                Alpine.data('comelecSearch', () => ({
                    query: '',
                    results: [],
                    loading: false,
                    highlightedIndex: -1,
                    
                    async search() {
                        if (this.query.length < 2) {
                            this.results = [];
                            return;
                        }
                        
                        this.loading = true;
                        this.highlightedIndex = -1;
                        
                        try {
                            const response = await fetch(`/comelec/search?query=${encodeURIComponent(this.query)}`);
                            if (!response.ok) throw new Error('Search failed');
                            this.results = await response.json();
                        } catch (error) {
                            console.error('Search error:', error);
                            this.results = [];
                        } finally {
                            this.loading = false;
                        }
                    },
                    
                    highlightNext() {
                        if (this.highlightedIndex < this.results.length - 1) {
                            this.highlightedIndex++;
                        }
                    },
                    
                    highlightPrev() {
                        if (this.highlightedIndex > 0) {
                            this.highlightedIndex--;
                        }
                    },
                    
                    selectHighlighted() {
                        if (this.highlightedIndex >= 0) {
                            this.selectResult(this.results[this.highlightedIndex]);
                        }
                    },
                    
                    selectResult(result) {
                        // Parse name (LASTNAME, FIRSTNAME MIDDLENAME)
                        const [lastName, ...firstMiddle] = result.name.split(', ');
                        const [firstName, ...middleNames] = firstMiddle.join('').split(' ');
                        const middleName = middleNames.join(' ');
                        
                        // Fill form fields
                        const form = document.getElementById('residentForm');
                        form.querySelector('[name="last_name"]').value = lastName || '';
                        form.querySelector('[name="first_name"]').value = firstName || '';
                        form.querySelector('[name="middle_name"]').value = middleName || '';
                        form.querySelector('[name="barangay"]').value = result.barangay || '';
                        form.querySelector('[name="precinct_number"]').value = result.precinct_no || '';
                        
                        // Set as voter
                        form.querySelector('[name="voter_status"][value="Voter"]').checked = true;
                        
                        // Reset search
                        this.query = '';
                        this.results = [];
                    }
                }));
            });
            </script>

            <!-- Voter Status Section -->
            <div x-data="{ isVoter: '{{ old('voter_status', $resident->voter_status) }}' }" class="mb-6">
                <h3 class="font-bold mb-2 flex items-center gap-2">
                    <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2" fill="none"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4"/>
                    </svg>
                    Voter Status
                </h3>
                <div class="flex flex-col md:flex-row gap-4 mb-4">
                    <label class="flex items-center p-3 bg-white rounded-lg shadow-sm border border-gray-200 hover:border-blue-400 transition cursor-pointer w-full md:w-auto">
                        <input type="radio" class="form-radio accent-blue-600" name="voter_status" value="Voter" x-model="isVoter"
                            {{ old('voter_status', $resident->voter_status) === 'Voter' ? 'checked' : '' }}>
                        <span class="ml-3 font-medium text-gray-700">Registered Voter</span>
                    </label>
                    <label class="flex items-center p-3 bg-white rounded-lg shadow-sm border border-gray-200 hover:border-blue-400 transition cursor-pointer w-full md:w-auto">
                        <input type="radio" class="form-radio accent-blue-600" name="voter_status" value="Non-Voter" x-model="isVoter"
                            {{ old('voter_status', $resident->voter_status) === 'Non-Voter' ? 'checked' : '' }}>
                        <span class="ml-3 font-medium text-gray-700">Non-Voter</span>
                    </label>
                </div>
                <div x-show="isVoter === 'Voter'" x-transition>
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-4">
                        <div>
                            <label class="form-label">Precinct Number</label>
                            <input type="text" class="form-input" name="precinct_number" value="{{ old('precinct_number', $resident->precinct_number) }}" placeholder="Enter Precinct Number">
                        </div>
                    </div>
                </div>
            </div>

            <!-- REGION/PROVINCE SECTION -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                <div>
                    <label class="form-label">Region <span class="text-red-500">*</span></label>
                    <input type="text" class="form-input" name="region" value="{{ old('region', $resident->region) }}" required>
                </div>
                <div>
                    <label class="form-label">Province <span class="text-red-500">*</span></label>
                    <input type="text" class="form-input" name="province" value="{{ old('province', $resident->province) }}" required>
                </div>
                <div>
                    <label class="form-label">City/Municipality <span class="text-red-500">*</span></label>
                    <input type="text" class="form-input" name="city_municipality" value="{{ old('city_municipality', $resident->city_municipality) }}" required>
                </div>
                <div>
                    <label class="form-label">Barangay <span class="text-red-500">*</span></label>
                    <input type="text" class="form-input" name="barangay" value="{{ old('barangay', $resident->barangay) }}" required placeholder="Enter Barangay">
                </div>
                <div class="mb-4">
                    <label class="form-label">Purok <span class="text-red-500">*</span></label>
                    <select class="form-select" name="purok_id" required>
                        <option value="">-Select Purok-</option>
                        @foreach(\App\Models\Purok::all() as $purok)
                            <option value="{{ $purok->id }}" {{ $resident->purok_id == $purok->id ? 'selected' : '' }}>
                                {{ $purok->purok_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            
            <hr class="my-6 border-gray-200">
            
            <!-- Personal Information Section -->
            <h2 class="text-2xl font-bold mb-6 text-primary flex items-center gap-2">
                <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5.121 17.804A13.937 13.937 0 0112 15c2.5 0 4.847.655 6.879 1.804M15 11a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Personal Information
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
                <div>
                    <label class="form-label">Philsys Card Number</label>
                    <input type="text" class="form-input" name="census_no" value="{{ old('census_no', $resident->census_no) }}" placeholder="Enter Philsys Card Number">
                </div>
                <div>
                    <label class="form-label">Profile Picture</label>
                    <div class="flex items-center gap-4">
                        <div class="camera-options">
                            <input type="file" id="profilePictureInput" class="form-input hidden" name="profile_picture" accept="image/*">
                            <button type="button" onclick="document.getElementById('profilePictureInput').click()" class="btn btn-primary py-2 px-4">
                                Upload File
                            </button>
                            <button type="button" id="openCameraBtn" class="btn btn-outline-primary py-2 px-4">
                                Take Photo
                            </button>
                        </div>
                        <div class="profile-preview-container relative">
                            <div class="w-20 h-20 rounded-full bg-gray-100 flex items-center justify-center overflow-hidden border border-gray-300">
                                @if($resident->profile_picture)
                                    <img id="profilePreview" src="{{ asset('storage/public/' . $resident->profile_picture) }}" alt="Profile Preview" class="w-full h-full object-cover">
                                @else
                                    <img id="profilePreview" src="" alt="Profile Preview" class="w-full h-full object-cover hidden">
                                @endif
                                <svg id="defaultProfileIcon" class="w-8 h-8 text-gray-400 {{ $resident->profile_picture ? 'hidden' : '' }}" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                                </svg>
                            </div>
                            <button type="button" id="removePhotoBtn" class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full p-1 {{ $resident->profile_picture ? '' : 'hidden' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </div>
                    
                    <!-- Camera Modal -->
                    <div id="cameraModal" class="fixed inset-0 z-[9999] bg-black bg-opacity-75 hidden flex items-center justify-center p-4">
                        <div class="bg-white rounded-lg shadow-xl w-full max-w-sm">
                            <div class="flex justify-between items-center border-b px-4 py-3">
                                <h3 class="text-base font-bold">Take Photo</h3>
                                <button type="button" id="closeCameraModal" class="text-gray-500 hover:text-gray-700">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>
                            <div class="p-3">
                                <div class="relative bg-gray-200 rounded-lg overflow-hidden" style="padding-bottom: 75%; max-width: 320px; margin: 0 auto;">
                                    <video id="cameraFeed" autoplay playsinline class="absolute inset-0 w-full h-full object-cover"></video>
                                    <canvas id="photoCanvas" class="absolute inset-0 w-full h-full hidden"></canvas>
                                </div>
                                <div class="flex justify-center mt-3 gap-2">
                                    <button type="button" id="captureBtn" class="btn btn-primary flex items-center gap-2 text-sm px-3 py-1.5">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                        Capture
                                    </button>
                                    <button type="button" id="retakeBtn" class="btn btn-outline-danger hidden flex items-center gap-2 text-sm px-3 py-1.5">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                        </svg>
                                        Retake
                                    </button>
                                    <button type="button" id="usePhotoBtn" class="btn btn-success hidden flex items-center gap-2 text-sm px-3 py-1.5">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                        Use Photo
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-4">
                <div>
                    <label class="form-label">Last Name <span class="text-red-500">*</span></label>
                    <input type="text" class="form-input" name="last_name" value="{{ old('last_name', $resident->last_name) }}" required placeholder="Last Name">
                </div>
                <div>
                    <label class="form-label">First Name <span class="text-red-500">*</span></label>
                    <input type="text" class="form-input" name="first_name" value="{{ old('first_name', $resident->first_name) }}" required placeholder="First Name">
                </div>
                <div>
                    <label class="form-label">Middle Name</label>
                    <input type="text" class="form-input" name="middle_name" value="{{ old('middle_name', $resident->middle_name) }}" placeholder="Middle Name">
                </div>
                <div>
                    <label class="form-label">Suffix</label>
                    <select class="form-select text-sm" name="suffix">
                        <option value="">None</option>
                        <option value="Jr" {{ old('suffix', $resident->suffix) == 'Jr' ? 'selected' : '' }}>Jr.</option>
                        <option value="Sr" {{ old('suffix', $resident->suffix) == 'Sr' ? 'selected' : '' }}>Sr.</option>
                        <option value="II" {{ old('suffix', $resident->suffix) == 'II' ? 'selected' : '' }}>II</option>
                        <option value="III" {{ old('suffix', $resident->suffix) == 'III' ? 'selected' : '' }}>III</option>
                        <option value="IV" {{ old('suffix', $resident->suffix) == 'IV' ? 'selected' : '' }}>IV</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-4">
                <div>
                    <label class="form-label">Birth Date <span class="text-red-500">*</span></label>
                    <input type="date" class="form-input" name="birth_date" value="{{ old('birth_date', \Carbon\Carbon::parse($resident->birth_date)->format('Y-m-d')) }}" required>
                </div>
                <div>
                    <label class="form-label">Birth Place <span class="text-red-500">*</span></label>
                    <input type="text" class="form-input" name="birth_place" value="{{ old('birth_place', $resident->birth_place) }}" required placeholder="Birth Place">
                </div>
                <div>
                    <label class="form-label">Sex <span class="text-red-500">*</span></label>
                    <select class="form-select" name="sex" required>
                        <option value="">-Select-</option>
                        <option value="Male" {{ old('sex', $resident->sex) == 'Male' ? 'selected' : '' }}>Male</option>
                        <option value="Female" {{ old('sex', $resident->sex) == 'Female' ? 'selected' : '' }}>Female</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-4">
                <div>
                    <label class="form-label">Civil Status <span class="text-red-500">*</span></label>
                    <select class="form-select" name="civil_status" required>
                        <option value="">-Select-</option>
                        <option value="Single" {{ old('civil_status', $resident->civil_status) == 'Single' ? 'selected' : '' }}>Single</option>
                        <option value="Married" {{ old('civil_status', $resident->civil_status) == 'Married' ? 'selected' : '' }}>Married</option>
                        <option value="Widowed" {{ old('civil_status', $resident->civil_status) == 'Widowed' ? 'selected' : '' }}>Widowed</option>
                        <option value="Separated" {{ old('civil_status', $resident->civil_status) == 'Separated' ? 'selected' : '' }}>Separated</option>
                    </select>
                </div>
                <div>
                    <label class="form-label">Religion</label>
                    <input type="text" class="form-input" name="religion" value="{{ old('religion', $resident->religion) }}" placeholder="Religion">
                </div>
                <div>
                    <label class="form-label">Citizenship <span class="text-red-500">*</span></label>
                    <input type="text" class="form-input" name="citizenship" value="{{ old('citizenship', $resident->citizenship) }}" required placeholder="Citizenship">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-4">
                <div>
                    <label class="form-label">Profession/Occupation</label>
                    <input type="text" class="form-input" name="occupation" value="{{ old('occupation', $resident->occupation) }}" placeholder="Occupation">
                </div>
                <div>
                    <label class="form-label">Contact Number</label>
                    <input type="text" class="form-input" name="contact_number" value="{{ old('contact_number', $resident->contact_number) }}" placeholder="09XXXXXXXXX">
                </div>
                <div>
                    <label class="form-label">Email Address</label>
                    <input type="email" class="form-input" name="email" value="{{ old('email', $resident->email) }}" placeholder="example@email.com">
                </div>
            </div>

            <!-- Unemployed Checkbox Section -->
            <div class="mb-6" x-data="{ isUnemployed: {{ old('is_unemployed', $resident->is_unemployed ?? 0) ? 'true' : 'false' }} }">
                <div class="flex items-center mb-2">
                    <input type="hidden" name="is_unemployed" value="0">
                    <input class="form-checkbox h-5 w-5 text-blue-600" type="checkbox" id="is_unemployed" name="is_unemployed" value="1"
                        x-model="isUnemployed"
                        {{ old('is_unemployed', $resident->is_unemployed ?? 0) ? 'checked' : '' }}>
                    <label class="ml-2 block text-sm font-medium text-gray-700" for="is_unemployed">
                        Unemployed
                    </label>
                </div>
            </div>

            <!-- Overseas Filipino Worker (OFW) -->
            <div class="mb-6" x-data="{ isOFW: {{ old('is_ofw', $resident->is_ofw) ? 'true' : 'false' }} }">
                <div class="flex items-center mb-2">
                    <input type="hidden" name="is_ofw" value="0">
                    <input class="form-checkbox h-5 w-5 text-blue-600" type="checkbox" id="is_ofw" name="is_ofw" value="1"
                        x-model="isOFW" {{ old('is_ofw', $resident->is_ofw) ? 'checked' : '' }}>
                    <label class="ml-2 block text-sm font-medium text-gray-700" for="is_ofw">
                        Are you an Overseas Filipino Worker (OFW)?
                    </label>
                </div>
                <div x-show="isOFW" x-transition class="ml-7 mt-2 grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="form-label">Country of Work</label>
                        <input type="text" class="form-input" name="ofw_country" value="{{ old('ofw_country', $resident->ofw_country) }}" 
                            placeholder="Enter country where working">
                    </div>
                </div>
            </div>
            
            <!-- Special Population Section -->
            <h2 class="text-2xl font-bold mb-6 text-primary flex items-center gap-2">
                <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                </svg>
                Special Population Information
            </h2>

            <!-- Special Population Section (Alpine.js root) -->
            <div x-data="specialPopulation()" x-init="init">
                <!-- Senior Citizen -->
                <div class="mb-6">
                    <div class="flex items-center mb-2">
                        <input type="checkbox" id="is_senior_citizen" name="is_senior_citizen" value="1" 
                            class="form-checkbox h-5 w-5 text-blue-600" x-model="isSenior"
                            {{ old('is_senior_citizen', $resident->is_senior_citizen) ? 'checked' : '' }}>
                        <label for="is_senior_citizen" class="ml-2 block text-sm font-medium text-gray-700">
                            Senior Citizen (60 years old and above)
                        </label>
                    </div>
                    
                    <div x-show="isSenior" x-transition class="ml-7 grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="form-label">Senior Citizen ID</label>
                            <input type="text" class="form-input" name="senior_citizen_id" 
                                value="{{ old('senior_citizen_id', $resident->senior_citizen_id) }}" 
                                placeholder="Enter ID number">
                        </div>
                    </div>
                </div>

                <!-- Person with Disability -->
                <div class="mb-6">
                    <div class="flex items-center mb-2">
                        <input type="checkbox" id="is_pwd" name="is_pwd" value="1" 
                            class="form-checkbox h-5 w-5 text-blue-600" x-model="isPwd"
                            {{ old('is_pwd', $resident->is_pwd) ? 'checked' : '' }}>
                        <label for="is_pwd" class="ml-2 block text-sm font-medium text-gray-700">
                            Person with Disability (PWD)
                        </label>
                    </div>
                    
                    <div x-show="isPwd" x-transition class="ml-7 grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="form-label">PWD ID</label>
                            <input type="text" class="form-input" name="pwd_id" 
                                value="{{ old('pwd_id', $resident->pwd_id) }}" 
                                placeholder="Enter ID number">
                        </div>
                        <div>
                            <label class="form-label">Disability Type</label>
                            <select class="form-select" name="pwd_type">
                                <option value="">Select Type</option>
                                <option value="Physical" {{ old('pwd_type', $resident->pwd_type) == 'Physical' ? 'selected' : '' }}>Physical Disability</option>
                                <option value="Visual" {{ old('pwd_type', $resident->pwd_type) == 'Visual' ? 'selected' : '' }}>Visual Impairment</option>
                                <option value="Hearing" {{ old('pwd_type', $resident->pwd_type) == 'Hearing' ? 'selected' : '' }}>Hearing Impairment</option>
                                <option value="Intellectual" {{ old('pwd_type', $resident->pwd_type) == 'Intellectual' ? 'selected' : '' }}>Intellectual Disability</option>
                                <option value="Psychosocial" {{ old('pwd_type', $resident->pwd_type) == 'Psychosocial' ? 'selected' : '' }}>Psychosocial Disability</option>
                                <option value="Other" {{ old('pwd_type', $resident->pwd_type) == 'Other' ? 'selected' : '' }}>Other</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Solo Parent -->
                <div class="mb-6">
                    <div class="flex items-center mb-2">
                        <input type="checkbox" id="is_solo_parent" name="is_solo_parent" value="1" 
                            class="form-checkbox h-5 w-5 text-blue-600" x-model="isSoloParent"
                            {{ old('is_solo_parent', $resident->is_solo_parent) ? 'checked' : '' }}>
                        <label for="is_solo_parent" class="ml-2 block text-sm font-medium text-gray-700">
                            Solo Parent
                        </label>
                    </div>
                    
                    <div x-show="isSoloParent" x-transition class="ml-7 grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="form-label">Solo Parent ID</label>
                            <input type="text" class="form-input" name="solo_parent_id" 
                                value="{{ old('solo_parent_id', $resident->solo_parent_id) }}" 
                                placeholder="Enter ID number">
                        </div>
                        <div>
                            <label class="form-label">Number of Children</label>
                            <input type="number" class="form-input" name="number_of_children" 
                                value="{{ old('number_of_children', $resident->number_of_children) }}"
                                min="0" max="20" placeholder="Enter number of children">
                        </div>
                    </div>
                </div>

                <!-- Indigenous People (IP) -->
                <div class="mb-6">
                    <div class="flex items-center mb-2">
                        <input type="hidden" name="is_indigenous" value="0">
                        <input class="form-checkbox h-5 w-5 text-blue-600" type="checkbox" id="is_indigenous" name="is_indigenous" value="1"
                            {{ old('is_indigenous', $resident->is_indigenous ?? false) ? 'checked' : '' }}>
                        <label class="ml-2 block text-sm font-medium text-gray-700" for="is_indigenous">
                            Indigenous People (IP)
                        </label>
                    </div>
                </div>
            </div>


            <!-- Educational Attainment Section -->
            <h3 class="font-bold mb-2">HIGHEST EDUCATIONAL ATTAINMENT</h3>
            <hr>
            <br>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-4">
                <label class="flex items-center p-3 bg-white rounded-lg shadow-sm border hover:border-blue-400 transition cursor-pointer">
                    <input type="radio" class="form-radio accent-blue-600" name="education" value="Elementary" {{ old('education', $resident->education) == 'Elementary' ? 'checked' : '' }}>
                    <span class="ml-3 font-medium text-gray-700">Elementary</span>
                </label>
                <label class="flex items-center p-3 bg-white rounded-lg shadow-sm border hover:border-blue-400 transition cursor-pointer">
                    <input type="radio" class="form-radio accent-blue-600" name="education" value="High School" {{ old('education', $resident->education) == 'High School' ? 'checked' : '' }}>
                    <span class="ml-3 font-medium text-gray-700">High School</span>
                </label>
                <label class="flex items-center p-3 bg-white rounded-lg shadow-sm border hover:border-blue-400 transition cursor-pointer">
                    <input type="radio" class="form-radio accent-blue-600" name="education" value="College" {{ old('education', $resident->education) == 'College' ? 'checked' : '' }}>
                    <span class="ml-3 font-medium text-gray-700">College</span>
                </label>
                <label class="flex items-center p-3 bg-white rounded-lg shadow-sm border hover:border-blue-400 transition cursor-pointer">
                    <input type="radio" class="form-radio accent-blue-600" name="education" value="Post Grad" {{ old('education', $resident->education) == 'Post Grad' ? 'checked' : '' }}>
                    <span class="ml-3 font-medium text-gray-700">Post Grad</span>
                </label>
                <label class="flex items-center p-3 bg-white rounded-lg shadow-sm border hover:border-blue-400 transition cursor-pointer">
                    <input type="radio" class="form-radio accent-blue-600" name="education" value="Vocational" {{ old('education', $resident->education) == 'Vocational' ? 'checked' : '' }}>
                    <span class="ml-3 font-medium text-gray-700">Vocational</span>
                </label>
                <label class="flex items-center p-3 bg-white rounded-lg shadow-sm border hover:border-blue-400 transition cursor-pointer">
                    <input type="radio" class="form-radio accent-blue-600" name="education" value="Master's" {{ old('education', $resident->education) == "Master's" ? 'checked' : '' }}>
                    <span class="ml-3 font-medium text-gray-700">Master's</span>
                </label>
                <label class="flex items-center p-3 bg-white rounded-lg shadow-sm border hover:border-blue-400 transition cursor-pointer">
                    <input type="radio" class="form-radio accent-blue-600" name="education" value="Doctorate" {{ old('education', $resident->education) == 'Doctorate' ? 'checked' : '' }}>
                    <span class="ml-3 font-medium text-gray-700">Doctorate</span>
                </label>
                <label class="flex items-center p-3 bg-white rounded-lg shadow-sm border hover:border-blue-400 transition cursor-pointer">
                    <input type="radio" class="form-radio accent-blue-600" name="education" value="Professional" {{ old('education', $resident->education) == 'Professional' ? 'checked' : '' }}>
                    <span class="ml-3 font-medium text-gray-700">Professional</span>
                </label>
                <label class="flex items-center p-3 bg-white rounded-lg shadow-sm border hover:border-blue-400 transition cursor-pointer">
                    <input type="radio" class="form-radio accent-blue-600" name="education" value="Technical" {{ old('education', $resident->education) == 'Technical' ? 'checked' : '' }}>
                    <span class="ml-3 font-medium text-gray-700">Technical</span>
                </label>
                <label class="flex items-center p-3 bg-white rounded-lg shadow-sm border hover:border-blue-400 transition cursor-pointer">
                    <input type="radio" class="form-radio accent-blue-600" name="education" value="Other" {{ old('education', $resident->education) == 'Other' ? 'checked' : '' }}>
                    <span class="ml-3 font-medium text-gray-700">Other</span>
                </label>
            </div>
            <hr>
            <br>
            <div class="mb-6">
                <label class="form-label font-bold mb-2 block">Educational Status</label>
                <div class="flex flex-col md:flex-row gap-4">
                    <label class="flex items-center p-3 bg-white rounded-lg shadow-sm border border-gray-200 hover:border-blue-400 transition cursor-pointer w-full md:w-auto">
                        <input type="radio" class="form-radio accent-blue-600" name="education_status" value="Graduate" {{ old('education_status', $resident->education_status) == 'Graduate' ? 'checked' : '' }}>
                        <span class="ml-3 font-medium text-gray-700">Graduate</span>
                    </label>
                    <label class="flex items-center p-3 bg-white rounded-lg shadow-sm border border-gray-200 hover:border-blue-400 transition cursor-pointer w-full md:w-auto">
                        <input type="radio" class="form-radio accent-blue-600" name="education_status" value="Under Graduate" {{ old('education_status', $resident->education_status) == 'Under Graduate' ? 'checked' : '' }}>
                        <span class="ml-3 font-medium text-gray-700">Under Graduate</span>
                    </label>
                </div>
            </div>
            
            <!-- Signature Section -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="form-label">Household Number</label>
                    <input type="text" class="form-input" name="household_number" value="{{ old('household_number', $resident->household_number) }}" readonly>
                </div>
            </div>
            
            <div class="mt-8 flex items-center justify-end">
                <a href="{{ route('resident.index') }}" class="btn btn-outline-danger">Cancel</a>
                <button type="submit" class="btn btn-primary ltr:ml-4 rtl:mr-4">Update Resident</button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('specialPopulation', () => ({
        isSenior: {{ $resident->is_senior_citizen ? 'true' : 'false' }},
        isPwd: {{ $resident->is_pwd ? 'true' : 'false' }},
        isSoloParent: {{ $resident->is_solo_parent ? 'true' : 'false' }},
        init() {
            // Initialize with any existing values
            this.isSenior = document.querySelector('[name="is_senior_citizen"]').checked;
            this.isPwd = document.querySelector('[name="is_pwd"]').checked;
            this.isSoloParent = document.querySelector('[name="is_solo_parent"]').checked;
        }
    }));
});
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Profile picture upload preview - Fixed variable names
        const profilePictureInput = document.getElementById('profilePictureInput');
        const profilePreview = document.getElementById('profilePreview');
        const defaultProfileIcon = document.getElementById('defaultProfileIcon');
        const removePhotoBtn = document.getElementById('removePhotoBtn');
        
        if (profilePictureInput) {
            profilePictureInput.addEventListener('change', function(e) {
                if (e.target.files.length > 0) {
                    const file = e.target.files[0];
                    const reader = new FileReader();
                    
                    reader.onload = function(event) {
                        profilePreview.src = event.target.result;
                        profilePreview.classList.remove('hidden');
                        if (defaultProfileIcon) defaultProfileIcon.classList.add('hidden');
                        if (removePhotoBtn) removePhotoBtn.classList.remove('hidden');
                    }
                    
                    reader.readAsDataURL(file);
                }
            });
        }
        
        if (removePhotoBtn) {
            removePhotoBtn.addEventListener('click', function(e) {
                e.preventDefault();
                if (profilePictureInput) profilePictureInput.value = '';
                if (profilePreview) {
                    profilePreview.src = '';
                    profilePreview.classList.add('hidden');
                }
                if (defaultProfileIcon) defaultProfileIcon.classList.remove('hidden');
                this.classList.add('hidden');
            });
        }
        
        // Camera functionality - Fixed and improved
        const openCameraBtn = document.getElementById('openCameraBtn');
        const cameraModal = document.getElementById('cameraModal');
        const closeCameraModal = document.getElementById('closeCameraModal');
        const cameraFeed = document.getElementById('cameraFeed');
        const photoCanvas = document.getElementById('photoCanvas');
        const captureBtn = document.getElementById('captureBtn');
        const retakeBtn = document.getElementById('retakeBtn');
        const usePhotoBtn = document.getElementById('usePhotoBtn');
        
        let stream = null;
        
        if (openCameraBtn) {
            openCameraBtn.addEventListener('click', function() {
                cameraModal.classList.remove('hidden');
                startCamera();
            });
        }
        
        if (closeCameraModal) {
            closeCameraModal.addEventListener('click', function() {
                stopCamera();
                resetCameraModal();
                cameraModal.classList.add('hidden');
            });
        }
        
        // Close modal when clicking outside
        if (cameraModal) {
            cameraModal.addEventListener('click', function(e) {
                if (e.target === cameraModal) {
                    stopCamera();
                    resetCameraModal();
                    cameraModal.classList.add('hidden');
                }
            });
        }
        
        function startCamera() {
            navigator.mediaDevices.getUserMedia({ 
                video: { 
                    width: { ideal: 640 }, 
                    height: { ideal: 480 },
                    facingMode: 'user'
                } 
            })
            .then(function(s) {
                stream = s;
                cameraFeed.srcObject = stream;
                console.log('Camera started successfully');
            })
            .catch(function(err) {
                console.error("Error accessing camera: ", err);
                alert('Could not access camera. Please check permissions and try again.');
                if (cameraModal) cameraModal.classList.add('hidden');
            });
        }
        
        function stopCamera() {
            if (stream) {
                stream.getTracks().forEach(track => {
                    track.stop();
                    console.log('Camera track stopped');
                });
                stream = null;
                if (cameraFeed) cameraFeed.srcObject = null;
            }
        }
        
        function resetCameraModal() {
            if (photoCanvas) photoCanvas.classList.add('hidden');
            if (cameraFeed) cameraFeed.classList.remove('hidden');
            if (captureBtn) captureBtn.classList.remove('hidden');
            if (retakeBtn) retakeBtn.classList.add('hidden');
            if (usePhotoBtn) usePhotoBtn.classList.add('hidden');
        }
        
        if (captureBtn) {
            captureBtn.addEventListener('click', function() {
                const context = photoCanvas.getContext('2d');
                photoCanvas.width = cameraFeed.videoWidth;
                photoCanvas.height = cameraFeed.videoHeight;
                context.drawImage(cameraFeed, 0, 0, photoCanvas.width, photoCanvas.height);
                
                cameraFeed.classList.add('hidden');
                photoCanvas.classList.remove('hidden');
                captureBtn.classList.add('hidden');
                retakeBtn.classList.remove('hidden');
                usePhotoBtn.classList.remove('hidden');
                
                stopCamera();
            });
        }
        
        if (retakeBtn) {
            retakeBtn.addEventListener('click', function() {
                resetCameraModal();
                startCamera();
            });
        }
        
        if (usePhotoBtn) {
            usePhotoBtn.addEventListener('click', function() {
                photoCanvas.toBlob(function(blob) {
                    if (blob) {
                        const file = new File([blob], 'profile-photo.png', { type: 'image/png' });
                        
                        // Create a data transfer object to simulate file input
                        const dataTransfer = new DataTransfer();
                        dataTransfer.items.add(file);
                        profilePictureInput.files = dataTransfer.files;
                        
                        // Update preview
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            profilePreview.src = e.target.result;
                            profilePreview.classList.remove('hidden');
                            if (defaultProfileIcon) defaultProfileIcon.classList.add('hidden');
                            if (removePhotoBtn) removePhotoBtn.classList.remove('hidden');
                        };
                        reader.readAsDataURL(file);
                        
                        // Close modal and reset
                        resetCameraModal();
                        cameraModal.classList.add('hidden');
                        
                        console.log('Photo captured and set successfully');
                    } else {
                        console.error('Failed to create blob from canvas');
                        alert('Failed to capture photo. Please try again.');
                    }
                }, 'image/png', 0.8);
            });
        }
        
        // Handle page visibility change to stop camera if page is hidden
        document.addEventListener('visibilitychange', function() {
            if (document.hidden && stream) {
                stopCamera();
            }
        });
        
        // Stop camera when page is about to unload
        window.addEventListener('beforeunload', function() {
            if (stream) {
                stopCamera();
            }
        });
    });
</script>

@endsection