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
                            <div x-data="voterStatus()" class="mb-6">
                                <h3 class="font-bold mb-2 flex items-center gap-2">
                                    <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2" fill="none"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4"/>
                                    </svg>
                                    Voter Status
                                </h3>
                                <div class="flex flex-col md:flex-row gap-4 mb-4">
                                    <label class="flex items-center p-3 bg-white rounded-lg shadow-sm border border-gray-200 hover:border-blue-400 transition cursor-pointer w-full md:w-auto">
                                        <input type="radio" class="form-radio accent-blue-600" name="voter_status" value="Voter" x-model="isVoter" :checked="isVoter" @change="updateVoter(true)">
                                        <span class="ml-3 font-medium text-gray-700">Registered Voter</span>
                                    </label>
                                    <label class="flex items-center p-3 bg-white rounded-lg shadow-sm border border-gray-200 hover:border-blue-400 transition cursor-pointer w-full md:w-auto">
                                        <input type="radio" class="form-radio accent-blue-600" name="voter_status" value="Non-Voter" x-model="isVoter" :checked="!isVoter" @change="updateVoter(false)">
                                        <span class="ml-3 font-medium text-gray-700">Non-Voter</span>
                                    </label>
                                </div>
                                <div x-show="isVoter" x-transition>
                                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-4">
                                        <div>
                                            <label class="form-label">Precinct Number</label>
                                            <input type="text" class="form-input" name="precinct_number" value="{{ old('precinct_number', $resident->precinct_number) }}" placeholder="Enter Precinct Number">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <script>
                                document.addEventListener('alpine:init', () => {
                                    Alpine.data('voterStatus', () => ({
                                        isVoter: {{ $resident->voter_status === 'Voter' ? 'true' : 'false' }},
                                        updateVoter(val) {
                                            this.isVoter = val;
                                        }
                                    }));
                                });
                            </script>

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
                                    <input type="file" class="form-input" name="profile_picture" accept="image/*">
                                    <div class="w-14 h-14 rounded-full bg-gray-100 flex items-center justify-center overflow-hidden border border-gray-300">
                                        @if($resident->profile_picture)
                                            <img src="{{ asset('storage/public/' . $resident->profile_picture) }}" alt="Profile" class="w-full h-full object-cover">
                                        @else
                                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h14v-2c0-2.66-5.33-4-8-4z"/>
                                            </svg>
                                        @endif
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
                                <input type="date" class="form-input" name="birth_date" value="{{ old('birth_date', $resident->birth_date) }}" required>
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

                        <div class="mb-4">
                            <label class="form-label">Residence Address <span class="text-red-500">*</span></label>
                            <textarea class="form-textarea" name="address" rows="2" required placeholder="Complete Address">{{ old('address', $resident->address) }}</textarea>
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

                        <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                const form = document.getElementById('residentForm');
                                
                                form.addEventListener('submit', function(e) {
                                    const requiredFields = form.querySelectorAll('[required]');
                                    let isValid = true;
                                    
                                    requiredFields.forEach(field => {
                                        if (!field.value.trim()) {
                                            field.style.borderColor = 'red';
                                            isValid = false;
                                            
                                            if (!field.nextElementSibling || !field.nextElementSibling.classList.contains('error-message')) {
                                                const errorMsg = document.createElement('div');
                                                errorMsg.className = 'error-message text-red-500 text-sm mt-1';
                                                errorMsg.textContent = 'This field is required';
                                                field.parentNode.insertBefore(errorMsg, field.nextSibling);
                                            }
                                        } else {
                                            field.style.borderColor = '';
                                            const errorMsg = field.nextElementSibling;
                                            if (errorMsg && errorMsg.classList.contains('error-message')) {
                                                errorMsg.remove();
                                            }
                                        }
                                    });
                                    
                                    if (!isValid) {
                                        e.preventDefault();
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Validation Error',
                                            text: 'Please fill in all required fields',
                                        });
                                    }
                                });
                                
                                form.querySelectorAll('[required]').forEach(field => {
                                    field.addEventListener('input', function() {
                                        if (this.value.trim()) {
                                            this.style.borderColor = '';
                                            const errorMsg = this.nextElementSibling;
                                            if (errorMsg && errorMsg.classList.contains('error-message')) {
                                                errorMsg.remove();
                                            }
                                        }
                                    });
                                });
                            });
                        </script>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection