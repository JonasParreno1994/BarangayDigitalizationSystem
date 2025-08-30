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

.relative .form-input.pl-10 {
    padding-left: 2.5rem;
}

.search-results-dropdown {
    scrollbar-width: thin;
    scrollbar-color: #d1d5db #f3f4f6;
}

.search-results-dropdown::-webkit-scrollbar {
    width: 8px;
}

.search-results-dropdown::-webkit-scrollbar-track {
    background: #f3f4f6;
}

.search-results-dropdown::-webkit-scrollbar-thumb {
    background-color: #d1d5db;
    border-radius: 4px;
}

.bg-blue-50 {
    background-color: #eff6ff;
}

/* Camera Modal Styles */
#cameraModal {
    transition: opacity 0.3s ease;
}

#photoCanvas {
    background-color: #f3f4f6;
}

#cameraFeed, #photoCanvas {
    transform: scaleX(1);
}

#removePhotoBtn {
    transition: all 0.2s ease;
}

#removePhotoBtn:hover {
    transform: scale(1.1);
    background-color: #dc2626;
}

.profile-preview-container {
    position: relative;
    width: 3rem;
    height: 3rem;
}

.profile-preview-container img {
    object-fit: cover;
    border-radius: 9999px;
}

.camera-options {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

@media (min-width: 768px) {
    .camera-options {
        flex-direction: row;
    }
}
.status-badge {
    padding: 0.25rem 0.75rem;
    border-radius: 0.375rem;
    font-size: 0.75rem;
    font-weight: 500;
    text-transform: uppercase;
}
.status-active {
    background-color: #dcfce7;
    color: #166534;
}
.status-transferred-residence {
    background-color: #fef3c7;
    color: #92400e;
}
.status-deceased {
    background-color: #fee2e2;
    color: #991b1b;
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

<div x-data="modal" class="mb-5">
    <div class="animate__animated p-6" :class="[$store.app.animation]">
        <!-- Main content section -->
        <div x-data="multipleTable">
            <div class="panel flex items-center overflow-x-auto whitespace-nowrap p-3 text-primary text-2xl font-bold">
                <button type="button" class="btn btn-success" @click="toggle">Add Resident</button>
                <h1 class="ltr:mr-4 rtl:ml-3 text-center w-full">List of Barangay Residents</h1>
            </div>
            <div class="panel mt-6">
                <table id="residentTable" class="whitespace-nowrap"></table>
            </div>
        </div>
        
         <!-- Add Resident Modal -->
        <div class="fixed inset-0 z-[999] hidden overflow-y-auto bg-[black]/60" :class="open && '!block'">
            <div class="flex min-h-screen items-start justify-center px-12" @click.self="open = false">
                <div x-show="open" x-transition x-transition.duration.300 class="panel my-8 w-full max-w-[70vw] h-[90vh] overflow-auto rounded-lg border-0 p-0">
                    <div class="flex items-center justify-between bg-[#fbfbfb] px-5 py-3 dark:bg-[#121c2c]">
                        <div class="text-lg font-bold">INDIVIDUAL RECORDS OF BARANGAY INHABITANT</div>
                        <button type="button" class="text-white-dark hover:text-dark" @click="toggle">
                            <svg xmlns="" width="24px" height="24px" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="h-6 w-6">
                                <line x1="18" y1="6" x2="6" y2="18"></line>
                                <line x1="6" y1="6" x2="18" y2="18"></line>
                            </svg>
                        </button>
                    </div>
                    
                    <div class="p-7">
                        <form id="residentForm" action="{{ route('resident.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

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
                                        <svg xmlns="" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <circle cx="11" cy="11" r="8"></circle>
                                            <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                                        </svg>
                                    </div>
                                    
                                    <!-- Loading indicator -->
                                    <div x-show="loading" class="absolute right-3 top-2.5 text-gray-400">
                                        <svg class="animate-spin h-5 w-5" xmlns="" fill="none" viewBox="0 0 24 24">
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
                            <div x-data="{ isVoter: true }" class="mb-6">
                                <h3 class="font-bold mb-2 flex items-center gap-2">
                                    <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2" fill="none"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4"/>
                                    </svg>
                                    Voter Status
                                </h3>
                                <div class="flex flex-col md:flex-row gap-4 mb-4">
                                    <label class="flex items-center p-3 bg-white rounded-lg shadow-sm border border-gray-200 hover:border-blue-400 transition cursor-pointer w-full md:w-auto">
                                        <input type="radio" class="form-radio accent-blue-600" name="voter_status" value="Voter" x-model="isVoter" :checked="isVoter" @click="isVoter = true">
                                        <span class="ml-3 font-medium text-gray-700">Registered Voter</span>
                                    </label>
                                    <label class="flex items-center p-3 bg-white rounded-lg shadow-sm border border-gray-200 hover:border-blue-400 transition cursor-pointer w-full md:w-auto">
                                        <input type="radio" class="form-radio accent-blue-600" name="voter_status" value="Non-Voter" x-model="isVoter" :checked="!isVoter" @click="isVoter = false">
                                        <span class="ml-3 font-medium text-gray-700">Non-Voter</span>
                                    </label>
                                    <div>
                                        <input type="text" class="form-input" name="precinct_number" placeholder="Enter Precinct Number">
                                    </div>
                                </div>
                                
                            </div>
                            <script>
                                document.addEventListener('alpine:init', () => {
                                    Alpine.data('voterStatus', () => ({
                                        isVoter: true,
                                        updateVoter(val) {
                                            this.isVoter = val;
                                        },
                                        init() {
                                            // Set initial state based on checked radio
                                            const checked = document.querySelector('input[name="voter_status"]:checked');
                                            this.isVoter = checked ? checked.value === 'Voter' : true;
                                        }
                                    }));
                                });
                            </script>

                          
                             <!-- Address Information Section -->
                             <h2 class="text-2xl font-bold mb-6 text-primary flex items-center gap-2">
                                <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 11c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 22s8-6.5 8-13a8 8 0 10-16 0c0 6.5 8 13 8 13z" />
                                </svg>
                                Resident Address
                            </h2>
                            

                            <div class="flex gap-4 mb-6">
                                <div class="flex-1">
                                    <label class="form-label">Purok <span class="text-red-500">*</span></label>
                                    <select class="form-select w-full" name="purok_id" required>
                                        <option value="">-Select Purok-</option>
                                        @foreach(\App\Models\Purok::all() as $purok)
                                            <option value="{{ $purok->id }}">
                                                {{ $purok->purok_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="flex-1">
                                    <label class="form-label">Barangay <span class="text-red-500">*</span></label>
                                    <input type="text" class="form-input w-full" name="barangay" required placeholder="Enter Barangay">
                                </div>
                                <div class="flex-1">
                                    <label class="form-label">City/Municipality <span class="text-red-500">*</span></label>
                                    <input type="text" class="form-input w-full" name="city_municipality" value="HINOBA-AN" required>
                                </div>
                                <div class="flex-1">
                                    <label class="form-label">Province <span class="text-red-500">*</span></label>
                                    <input type="text" class="form-input w-full" name="province" value="NEGROS OCCIDENTAL" required>
                                </div>
                                <div class="flex-1">
                                    <label class="form-label">Region <span class="text-red-500">*</span></label>
                                    <input type="text" class="form-input w-full" name="region" value="NEGROS ISLAND REGION" required>
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

                            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-5">
                                <div >
                                    <label class="form-label">Philsys Card Number</label>
                                    <input type="text" class="form-input" name="census_no" placeholder="Enter Philsys Card Number">
                                </div>
                                <div>
                                    <label class="form-label">Profile Picture</label>
                                    <div class="flex items-center gap-4">
                                        <div class="camera-options">
                                            <input type="file" id="profile_picture_input" class="form-input hidden" name="profile_picture" accept="image/*">
                                            <button type="button" onclick="document.getElementById('profile_picture_input').click()" class="btn btn-primary py-2 px-4">
                                                Upload File
                                            </button>
                                            <button type="button" id="openCameraBtn" class="btn btn-outline-primary py-2 px-4">
                                                Take Photo
                                            </button>
                                        </div>
                                        <div class="profile-preview-container">
                                            <div class="w-20 h-20 rounded-full bg-gray-100 flex items-center justify-center overflow-hidden border border-gray-300">
                                                <img id="profilePreview" src="" alt="Profile Preview" class="w-full h-full object-cover hidden">
                                                <svg id="defaultProfileIcon" class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                                                </svg>
                                            </div>
                                            <button type="button" id="removePhotoBtn" class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full p-1 hidden">
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
                                                    <button id="captureBtn" class="btn btn-primary flex items-center gap-2 text-sm px-3 py-1.5">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                                                        </svg>
                                                        Capture
                                                    </button>
                                                    <button id="retakeBtn" class="btn btn-outline-danger hidden flex items-center gap-2 text-sm px-3 py-1.5">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                                        </svg>
                                                        Retake
                                                    </button>
                                                    <button id="usePhotoBtn" class="btn btn-success hidden flex items-center gap-2 text-sm px-3 py-1.5">
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
                                    <input type="text" class="form-input" name="last_name" required placeholder="Last Name">
                                </div>
                                <div>
                                    <label class="form-label">First Name <span class="text-red-500">*</span></label>
                                    <input type="text" class="form-input" name="first_name" required placeholder="First Name">
                                </div>
                                <div>
                                    <label class="form-label">Middle Name</label>
                                    <input type="text" class="form-input" name="middle_name" placeholder="Middle Name">
                                </div>
                                <div>
                                    <label class="form-label">Suffix</label>
                                    <select class="form-select text-sm" name="suffix">
                                        <option value="">None</option>
                                        <option value="Jr">Jr.</option>
                                        <option value="Sr">Sr.</option>
                                        <option value="II">II</option>
                                        <option value="III">III</option>
                                        <option value="IV">IV</option>
                                    </select>
                                </div>
                            </div>

                            <div class="flex gap-4 mb-4 items-start">
                                <!-- Birth Date -->
                                <div class="w-1/5">
                                    <label class="form-label">Birth Date <span class="text-red-500">*</span></label>
                                    <input type="date" class="form-input w-full" name="birth_date" required>
                                </div>
                            
                                <!-- Birth Place -->
                                <div class="w-1/5">
                                    <label class="form-label">Birth Place <span class="text-red-500">*</span></label>
                                    <input type="text" class="form-input w-full" name="birth_place" required placeholder="Birth Place">
                                </div>
                            
                                <!-- Sex -->
                                <div class="w-1/5">
                                    <label class="form-label">Sex <span class="text-red-500">*</span></label>
                                    <select class="form-select w-full" name="sex" required>
                                        <option value="">-Select-</option>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                    </select>
                                </div>
                            
                                <!-- Civil Status -->
                                <div class="w-1/5">
                                    <label class="form-label">Civil Status <span class="text-red-500">*</span></label>
                                    <select class="form-select w-full" name="civil_status" required>
                                        <option value="">-Select-</option>
                                        <option value="Single">Single</option>
                                        <option value="Married">Married</option>
                                        <option value="Widowed">Widowed</option>
                                        <option value="Separated">Separated</option>
                                    </select>
                                </div>
                            
                                <!-- Religion -->
                                <div class="w-1/5">
                                    <label class="form-label">Religion</label>
                                    <input type="text" class="form-input w-full" name="religion" placeholder="Religion">
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-4">
                               
                                <div>
                                    <label class="form-label">Citizenship <span class="text-red-500">*</span></label>
                                    <input type="text" class="form-input" name="citizenship" required placeholder="Citizenship">
                                </div>
                                <div>
                                    <label class="form-label">Profession/Occupation</label>
                                    <input type="text" class="form-input" name="occupation" placeholder="Occupation">
                                </div>
                                <div>
                                    <label class="form-label">Contact Number</label>
                                    <input type="text" class="form-input" name="contact_number" placeholder="09XXXXXXXXX">
                                </div>
                                <div>
                                    <label class="form-label">Email Address</label>
                                    <input type="email" class="form-input" name="email" placeholder="example@email.com">
                                </div>
                            </div>

                            
                            <div class="mb-6">
                                <label class="form-label">Initial Status</label>
                                <select class="form-select" name="status">
                                    <option value="Active" selected>Active</option>
                                    <option value="Transferred Residence">Transferred Residence</option>
                                    <option value="Deceased">Deceased</option>
                                </select>
                            </div>

                            <!-- Unemployed Checkbox Section -->
                            <div class="mb-6" x-data="{ isUnemployed: {{ old('is_unemployed', 0) ? 'true' : 'false' }} }">
                                <div class="flex items-center mb-2">
                                    <input type="hidden" name="is_unemployed" value="0">
                                    <input class="form-checkbox h-5 w-5 text-blue-600" type="checkbox" id="is_unemployed" name="is_unemployed" value="1"
                                        x-model="isUnemployed"
                                        {{ old('is_unemployed', 0) ? 'checked' : '' }}>
                                    <label class="ml-2 block text-sm font-medium text-gray-700" for="is_unemployed">
                                        Unemployed
                                    </label>
                                </div>
                            </div>

                            <!-- Overseas Filipino Worker (OFW) -->
                            <div class="mb-6" x-data="{ isOFW: {{ old('is_ofw') ? 'true' : 'false' }} }">
                                <div class="flex items-center mb-2">
                                    <input type="hidden" name="is_ofw" value="0">
                                    <input class="form-checkbox h-5 w-5 text-blue-600" type="checkbox" id="is_ofw" name="is_ofw" value="1"
                                        x-model="isOFW" {{ old('is_ofw') ? 'checked' : '' }}>
                                    <label class="ml-2 block text-sm font-medium text-gray-700" for="is_ofw">
                                        Overseas Filipino Worker (OFW)
                                    </label>
                                </div>
                                <div x-show="isOFW" x-transition class="ml-7 mt-2 grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="form-label">Country of Work</label>
                                        <input type="text" class="form-input" name="ofw_country" value="{{ old('ofw_country') }}" 
                                            placeholder="Enter country where working">
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Educational Attainment Section -->
                            <h3 class="font-bold mb-2">HIGHEST EDUCATIONAL ATTAINMENT</h3>
                            <hr class="my-6 border-gray-200">
                            <div class="flex gap-4 mb-2 items-start">
                                <label class="flex items-center p-3 bg-white rounded-lg shadow-sm border hover:border-blue-400 transition cursor-pointer">
                                    <input type="radio" class="form-radio accent-blue-600" name="education" value="Elementary">
                                    <span class="ml-3 font-medium text-gray-700">Elementary</span>
                                </label>
                                <label class="flex items-center p-3 bg-white rounded-lg shadow-sm border hover:border-blue-400 transition cursor-pointer">
                                    <input type="radio" class="form-radio accent-blue-600" name="education" value="High School">
                                    <span class="ml-3 font-medium text-gray-700">High School</span>
                                </label>
                                <label class="flex items-center p-3 bg-white rounded-lg shadow-sm border hover:border-blue-400 transition cursor-pointer">
                                    <input type="radio" class="form-radio accent-blue-600" name="education" value="College">
                                    <span class="ml-3 font-medium text-gray-700">College</span>
                                </label>
                                <label class="flex items-center p-3 bg-white rounded-lg shadow-sm border hover:border-blue-400 transition cursor-pointer">
                                    <input type="radio" class="form-radio accent-blue-600" name="education" value="Post Grad">
                                    <span class="ml-3 font-medium text-gray-700">Post Grad</span>
                                </label>
                                <label class="flex items-center p-3 bg-white rounded-lg shadow-sm border hover:border-blue-400 transition cursor-pointer">
                                    <input type="radio" class="form-radio accent-blue-600" name="education" value="Vocational">
                                    <span class="ml-3 font-medium text-gray-700">Vocational</span>
                                </label>
                                <label class="flex items-center p-3 bg-white rounded-lg shadow-sm border hover:border-blue-400 transition cursor-pointer">
                                    <input type="radio" class="form-radio accent-blue-600" name="education" value="Master's">
                                    <span class="ml-3 font-medium text-gray-700">Master's</span>
                                </label>
                                <label class="flex items-center p-3 bg-white rounded-lg shadow-sm border hover:border-blue-400 transition cursor-pointer">
                                    <input type="radio" class="form-radio accent-blue-600" name="education" value="Doctorate">
                                    <span class="ml-3 font-medium text-gray-700">Doctorate</span>
                                </label>
                                <label class="flex items-center p-3 bg-white rounded-lg shadow-sm border hover:border-blue-400 transition cursor-pointer">
                                    <input type="radio" class="form-radio accent-blue-600" name="education" value="Professional">
                                    <span class="ml-3 font-medium text-gray-700">Professional</span>
                                </label>
                                <label class="flex items-center p-3 bg-white rounded-lg shadow-sm border hover:border-blue-400 transition cursor-pointer">
                                    <input type="radio" class="form-radio accent-blue-600" name="education" value="Technical">
                                    <span class="ml-3 font-medium text-gray-700">Technical</span>
                                </label>
                                <label class="flex items-center p-3 bg-white rounded-lg shadow-sm border hover:border-blue-400 transition cursor-pointer">
                                    <input type="radio" class="form-radio accent-blue-600" name="education" value="Other">
                                    <span class="ml-3 font-medium text-gray-700">Other</span>
                                </label>
                            </div>
                            <hr>
                            <br>
                            <div class="mb-6">
                                <label class="form-label font-bold mb-2 block">Educational Status</label>
                                <div class="flex flex-col md:flex-row gap-4">
                                    <label class="flex items-center p-3 bg-white rounded-lg shadow-sm border border-gray-200 hover:border-blue-400 transition cursor-pointer w-full md:w-auto">
                                        <input type="radio" class="form-radio accent-blue-600" name="education_status" value="Graduate">
                                        <span class="ml-3 font-medium text-gray-700">Graduate</span>
                                    </label>
                                    <label class="flex items-center p-3 bg-white rounded-lg shadow-sm border border-gray-200 hover:border-blue-400 transition cursor-pointer w-full md:w-auto">
                                        <input type="radio" class="form-radio accent-blue-600" name="education_status" value="Under Graduate">
                                        <span class="ml-3 font-medium text-gray-700">Under Graduate</span>
                                    </label>
                                </div>
                            </div>
                            <hr class="my-6 border-gray-200">
                            
                             <!-- Special Population Section -->
                             <h2 class="text-2xl font-bold mb-6 text-primary flex items-center gap-2">
                                <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                </svg>
                                Special Population Information
                            </h2>

                            <!-- Senior Citizen -->
                            <div class="mb-6" x-data="{ isSenior: false }">
                                <div class="flex items-center mb-2">
                                    <input type="checkbox" id="is_senior_citizen" name="is_senior_citizen" value="1" 
                                        class="form-checkbox h-5 w-5 text-blue-600" x-model="isSenior">
                                    <label for="is_senior_citizen" class="ml-2 block text-sm font-medium text-gray-700">
                                        Senior Citizen (60 years old and above)
                                    </label>
                                </div>
                                
                                <div x-show="isSenior" x-transition class="ml-7 grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="form-label">Senior Citizen ID</label>
                                        <input type="text" class="form-input" name="senior_citizen_id" placeholder="Enter ID number">
                                    </div>
                                </div>
                            </div>

                            <!-- Person with Disability -->
                            <div class="mb-6" x-data="{ isPwd: false }">
                                <div class="flex items-center mb-2">
                                    <input type="checkbox" id="is_pwd" name="is_pwd" value="1" 
                                        class="form-checkbox h-5 w-5 text-blue-600" x-model="isPwd">
                                    <label for="is_pwd" class="ml-2 block text-sm font-medium text-gray-700">
                                        Person with Disability (PWD)
                                    </label>
                                </div>
                                
                                <div x-show="isPwd" x-transition class="ml-7 grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="form-label">PWD ID</label>
                                        <input type="text" class="form-input" name="pwd_id" placeholder="Enter ID number">
                                    </div>
                                    <div>
                                        <label class="form-label">Disability Type</label>
                                        <select class="form-select" name="pwd_type">
                                            <option value="">Select Type</option>
                                            <option value="Physical">Physical Disability</option>
                                            <option value="Visual">Visual Impairment</option>
                                            <option value="Hearing">Hearing Impairment</option>
                                            <option value="Intellectual">Intellectual Disability</option>
                                            <option value="Psychosocial">Psychosocial Disability</option>
                                            <option value="Other">Other</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- Solo Parent -->
                            <div class="mb-6" x-data x-init="$watch('$store.specialPopulation.isSoloParent', value => isSoloParent = value)" x-effect="isSoloParent = $store.specialPopulation.isSoloParent" x-modelable="isSoloParent" :isSoloParent="$store.specialPopulation.isSoloParent">
                                <div class="flex items-center mb-2">
                                    <input type="checkbox" id="is_solo_parent" name="is_solo_parent" value="1" 
                                        class="form-checkbox h-5 w-5 text-blue-600" x-model="$store.specialPopulation.isSoloParent">
                                    <label for="is_solo_parent" class="ml-2 block text-sm font-medium text-gray-700">
                                        Solo Parent
                                    </label>
                                </div>
                                
                                <div x-show="$store.specialPopulation.isSoloParent" x-transition class="ml-7 grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <div>
                                        <label class="form-label">Solo Parent ID</label>
                                        <input type="text" class="form-input" name="solo_parent_id" placeholder="Enter ID number">
                                    </div>
                                    <div>
                                        <label class="form-label">Number of Children</label>
                                        <input type="number" class="form-input" name="number_of_children" 
                                            min="0" max="20" placeholder="Enter number of children">
                                    </div>
                                </div>
                            </div>

                            <!-- Indigenous People (IP) -->
                            <div class="mb-6">
                                <div class="flex items-center mb-2">
                                    <input type="hidden" name="is_indigenous" value="0">
                                    <input class="form-checkbox h-5 w-5 text-blue-600" type="checkbox" id="is_indigenous" name="is_indigenous" value="1"
                                        {{ old('is_indigenous') ? 'checked' : '' }}>
                                    <label class="ml-2 block text-sm font-medium text-gray-700" for="is_indigenous">
                                        Indigenous People (IP)
                                    </label>
                                </div>
                            </div>

                            <!-- Signature Section -->
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                                <div>
                                    <label class="form-label">Household Number</label>
                                    <input type="text" class="form-input" name="household_number">
                                </div>
                            </div>
                            <div class="mt-8 flex items-center justify-end">
                                <button type="button" class="btn btn-outline-danger" @click="toggle">Cancel</button>
                                <button type="submit" class="btn btn-primary ltr:ml-4 rtl:mr-4">Save Resident</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Status Change Modal -->
        <div class="fixed inset-0 z-[999] hidden overflow-y-auto bg-[black]/60" id="statusModal">
            <div class="flex min-h-screen items-center justify-center px-4">
                <div class="panel w-full max-w-md rounded-lg border-0 p-0">
                    <div class="flex items-center justify-between bg-[#fbfbfb] px-5 py-3 dark:bg-[#121c2c]">
                        <div class="text-lg font-bold">Change Status</div>
                        <button type="button" class="text-white-dark hover:text-dark" onclick="closeStatusModal()">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="h-6 w-6">
                                <line x1="18" y1="6" x2="6" y2="18"></line>
                                <line x1="6" y1="6" x2="18" y2="18"></line>
                            </svg>
                        </button>
                    </div>
                    
                    <div class="p-5">
                        <form id="statusForm">
                            @csrf
                            <div class="mb-4">
                                <label class="form-label">Select New Status <span class="text-red-500">*</span></label>
                                <select class="form-select" name="status" required>
                                    <option value="">Select Status</option>
                                    <option value="Active">Active</option>
                                    <option value="Transferred Residence">Transferred Residence</option>
                                    <option value="Deceased">Deceased</option>
                                </select>
                            </div>
                            <div class="mb-4">
                                <p class="text-sm text-gray-600">
                                    Current resident: <span id="currentResidentName" class="font-medium"></span>
                                </p>
                                <p class="text-sm text-gray-600">
                                    Current status: <span id="currentStatus" class="font-medium"></span>
                                </p>
                            </div>
                            <div class="flex justify-end gap-3">
                                <button type="button" class="btn btn-outline-danger" onclick="closeStatusModal()">Cancel</button>
                                <button type="submit" class="btn btn-primary">Update Status</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

            <!-- View Resident Modal -->
            <div class="fixed inset-0 z-[999] hidden overflow-y-auto bg-[black]/60" id="viewResidentModal">
                <div class="flex min-h-screen items-start justify-center px-4">
                    <div class="panel my-8 w-full max-w-4xl overflow-hidden rounded-lg border-0 p-0">
                        <div class="flex items-center justify-between bg-[#fbfbfb] px-5 py-3 dark:bg-[#121c2c]">
                            <div class="text-lg font-bold">RESIDENT DETAILS</div>
                            <button type="button" class="text-white-dark hover:text-dark" onclick="closeViewModal()">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="h-6 w-6">
                                    <line x1="18" y1="6" x2="6" y2="18"></line>
                                    <line x1="6" y1="6" x2="18" y2="18"></line>
                                </svg>
                            </button>
                        </div>
                        
                        <div class="p-5" id="residentDetailsContent">
                            <!-- Content will be loaded here via AJAX -->
                            <div class="text-center py-10">
                                <svg class="animate-spin h-8 w-8 text-blue-500 mx-auto" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                <p class="mt-3">Loading resident details...</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.store('specialPopulation', {
        isSenior: false,
        isPwd: false,
        isSoloParent: false,
    });
    Alpine.data('specialPopulation', () => ({
        init() {
            this.$store.specialPopulation.isSenior = document.querySelector('[name="is_senior_citizen"]').checked;
            this.$store.specialPopulation.isPwd = document.querySelector('[name="is_pwd"]').checked;
            this.$store.specialPopulation.isSoloParent = document.querySelector('[name="is_solo_parent"]').checked;
        }
    }));
});
</script>

    <!-- Camera Integration JavaScript -->
<script>
        document.addEventListener('DOMContentLoaded', function() {
        const profilePictureInput = document.getElementById('profile_picture_input');
        const profilePreview = document.getElementById('profilePreview');
        const defaultProfileIcon = document.getElementById('defaultProfileIcon');
        const removePhotoBtn = document.getElementById('removePhotoBtn');
        const openCameraBtn = document.getElementById('openCameraBtn');
        const cameraModal = document.getElementById('cameraModal');
        const closeCameraModal = document.getElementById('closeCameraModal');
        const cameraFeed = document.getElementById('cameraFeed');
        const photoCanvas = document.getElementById('photoCanvas');
        const captureBtn = document.getElementById('captureBtn');
        const retakeBtn = document.getElementById('retakeBtn');
        const usePhotoBtn = document.getElementById('usePhotoBtn');
        
        let stream = null;
        let capturedPhoto = null;

        // Handle file upload
        profilePictureInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    profilePreview.src = event.target.result;
                    profilePreview.classList.remove('hidden');
                    defaultProfileIcon.classList.add('hidden');
                    removePhotoBtn.classList.remove('hidden');
                };
                reader.readAsDataURL(file);
            }
        });

        // Remove photo
        removePhotoBtn.addEventListener('click', function() {
            profilePreview.src = '';
            profilePreview.classList.add('hidden');
            defaultProfileIcon.classList.remove('hidden');
            removePhotoBtn.classList.add('hidden');
            profilePictureInput.value = '';
        });

        // Open camera modal
        openCameraBtn.addEventListener('click', async function() {
            cameraModal.classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
            
            try {
                stream = await navigator.mediaDevices.getUserMedia({ 
                    video: { 
                        facingMode: 'user',
                        width: { ideal: 640 },  // Reduced from 1280
                        height: { ideal: 480 }  // Reduced from 720
                    },
                    audio: false 
                });
                cameraFeed.srcObject = stream;
                
                // Reset camera UI
                cameraFeed.classList.remove('hidden');
                photoCanvas.classList.add('hidden');
                captureBtn.classList.remove('hidden');
                retakeBtn.classList.add('hidden');
                usePhotoBtn.classList.add('hidden');
            } catch (err) {
                console.error("Error accessing camera: ", err);
                Swal.fire({
                    icon: 'error',
                    title: 'Camera Error',
                    text: 'Could not access the camera. Please check permissions and try again.',
                });
                closeCamera();
            }
        });

        // Close camera modal
        closeCameraModal.addEventListener('click', function() {
            closeCamera();
            cameraModal.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        });

        // Capture photo
        captureBtn.addEventListener('click', function() {
            const context = photoCanvas.getContext('2d');
            
            // Set canvas dimensions to match video stream
            photoCanvas.width = cameraFeed.videoWidth;
            photoCanvas.height = cameraFeed.videoHeight;
            
            // Draw current video frame to canvas
            context.drawImage(cameraFeed, 0, 0, photoCanvas.width, photoCanvas.height);
            
            // Switch UI to preview mode
            cameraFeed.classList.add('hidden');
            photoCanvas.classList.remove('hidden');
            captureBtn.classList.add('hidden');
            retakeBtn.classList.remove('hidden');
            usePhotoBtn.classList.remove('hidden');
        });

        // Retake photo
        retakeBtn.addEventListener('click', function() {
            cameraFeed.classList.remove('hidden');
            photoCanvas.classList.add('hidden');
            captureBtn.classList.remove('hidden');
            retakeBtn.classList.add('hidden');
            usePhotoBtn.classList.add('hidden');
        });

        // Use photo
        usePhotoBtn.addEventListener('click', function() {
            // Convert canvas to blob and create a File object
            photoCanvas.toBlob(function(blob) {
                const file = new File([blob], 'profile-photo.jpg', { type: 'image/jpeg' });
                
                // Create a data URL for preview
                const dataUrl = photoCanvas.toDataURL('image/jpeg');
                profilePreview.src = dataUrl;
                profilePreview.classList.remove('hidden');
                defaultProfileIcon.classList.add('hidden');
                removePhotoBtn.classList.remove('hidden');
                
                // Create a fake FileList to assign to the input
                const dataTransfer = new DataTransfer();
                dataTransfer.items.add(file);
                profilePictureInput.files = dataTransfer.files;
                
                // Close camera
                closeCamera();
                cameraModal.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            }, 'image/jpeg', 0.9);
        });

        // Clean up camera stream when modal is closed
        function closeCamera() {
            if (stream) {
                stream.getTracks().forEach(track => track.stop());
                stream = null;
            }
            cameraFeed.srcObject = null;
        }

        // Close modal when clicking outside
        cameraModal.addEventListener('click', function(e) {
            if (e.target === cameraModal) {
                closeCamera();
                cameraModal.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            }
        });
    });
</script>


<script>
let currentResidentId = null;

// Status Modal Functions
function showStatusModal(residentId, residentName, currentStatus) {
    // Prevent changing status of deceased residents
    if (currentStatus === 'Deceased') {
        Swal.fire({
            icon: 'error',
            title: 'Cannot Change Status',
            text: 'The status of a deceased resident cannot be changed.',
        });
        return;
    }
    
    currentResidentId = residentId;
    document.getElementById('currentResidentName').textContent = residentName;
    document.getElementById('currentStatus').textContent = currentStatus;
    document.getElementById('statusModal').classList.remove('hidden');
    document.body.classList.add('overflow-hidden');
}
function closeStatusModal() {
    document.getElementById('statusModal').classList.add('hidden');
    document.body.classList.remove('overflow-hidden');
    document.getElementById('statusForm').reset();
    currentResidentId = null;
}
document.addEventListener('DOMContentLoaded', function() {
    // Status form submission
    const statusForm = document.getElementById('statusForm');
    if (statusForm) {
        statusForm.addEventListener('submit', function(e) {
            e.preventDefault();
            if (!currentResidentId) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'No resident selected.',
                });
                return;
            }
            const formData = new FormData(this);
            const status = formData.get('status');
            if (!status) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Please select a status.',
                });
                return;
            }
            Swal.fire({
                title: 'Confirm Status Change',
                text: `Are you sure you want to change the status to "${status}"?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, update it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    updateResidentStatus(currentResidentId, status);
                }
            });
        });
    }
});
function updateResidentStatus(residentId, status) {
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || 
                      document.querySelector('input[name="_token"]')?.value;
    if (!csrfToken) {
        Swal.fire({
            icon: 'error',
            title: 'Error!',
            text: 'CSRF token not found. Please refresh the page.',
        });
        return;
    }
    fetch(`/residentFolder/${residentId}/status`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
            'Accept': 'application/json',
        },
        body: JSON.stringify({ status: status })
    })
    .then(response => {
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: data.message,
                timer: 2000,
                showConfirmButton: false
            }).then(() => {
                window.location.reload();
            });
            closeStatusModal();
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: data.message || 'An error occurred while updating the status.',
            });
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire({
            icon: 'error',
            title: 'Error!',
            text: 'An error occurred while updating the status. Please try again.',
        });
    });
}

// DataTable Initialization with Status Column
document.addEventListener('alpine:init', () => {
    Alpine.data('multipleTable', () => ({
        datatable: null,
        init() {
            this.datatable = new simpleDatatables.DataTable('#residentTable', {
                data: {
                    headings: ['ID', 'Photo', 'Name', 'Voter Status', 'Status', 'Address', 'Contact', 'Actions'],
                    data: [
                        @foreach ($resident as $res)
                            [
                                '{{ $res->id }}',
                                `@if($res->profile_picture)
                                    <img src="{{ asset('storage/public/profile_pictures/' . basename($res->profile_picture)) }}" alt="Profile" class="w-10 h-10 rounded-full object-cover">
                                @else
                                    <div class="w-10 h-10 rounded-full bg-gray-300 flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                    </div>
                                @endif`,
                                '{{ $res->last_name }}, {{ $res->first_name }}',
                                '{{ $res->voter_status }}',
                                `<span class="status-badge status-{{ strtolower(str_replace(' ', '-', $res->status ?? 'active')) }}">
                                    {{ $res->status ?? 'Active' }}
                                </span>`,
                                '{{ $res->address }}',
                                '{{ $res->contact_number ?? 'N/A' }}',
                                `<div class="dropdown">
                                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                                        Actions
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 ml-1" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                    <ul class="dropdown-menu min-w-[120px] absolute z-10 hidden bg-white shadow-lg rounded-md py-1 mt-1">
                                        <li>
                                            <button type="button" class="dropdown-item" onclick="showResidentModal({{ $res->id }})">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                                View
                                            </button>
                                        </li>
                                        @if($res->status !== 'Deceased')
                                        <li>
                                            <button type="button" class="dropdown-item" onclick="printResidentID({{ $res->id }})">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                                                </svg>
                                                Print ID
                                            </button>
                                        </li>
                                        @endif
                                        <li>
                                            <a href="{{ route('resident.edit', $res->id) }}" class="dropdown-item">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                                Edit
                                            </a>
                                        </li>
                                        @if($res->status !== 'Deceased')
                                        <li>
                                            <button type="button" class="dropdown-item" onclick="showStatusModal({{ $res->id }}, '{{ addslashes($res->last_name . ', ' . $res->first_name) }}', '{{ $res->status ?? 'Active' }}')">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                                </svg>
                                                Change Status
                                            </button>
                                        </li>
                                        @endif
                                    </ul>
                                </div>`
                            ],
                        @endforeach
                    ],
                },
                searchable: true,
                perPage: 10,
                perPageSelect: [10, 20, 30, 50, 100],
                columns: [
                    { select: 0, sortable: true },
                    { select: 1, sortable: false, type: 'html' },
                    { select: 2, sortable: true },
                    { select: 3, sortable: true },
                    { select: 4, sortable: true, type: 'html' },
                    { select: 5, sortable: true },
                    { select: 6, sortable: false },
                    { select: 7, sortable: false, type: 'html' }
                ],
            });
        },
    }));
});

// Resident Modal Functions
function showResidentModal(residentId) {
    document.getElementById('viewResidentModal').classList.remove('hidden');
    
    fetch(`/residentFolder/${residentId}/view`)
        .then(response => response.text())
        .then(html => {
            document.getElementById('residentDetailsContent').innerHTML = html;
        })
        .catch(error => {
            console.error('Error loading resident details:', error);
            document.getElementById('residentDetailsContent').innerHTML = `
                <div class="text-center py-10 text-red-500">
                    <svg xmlns="" class="h-12 w-12 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    <p class="mt-3">Failed to load resident details. Please try again.</p>
                </div>
            `;
        });
}

function printResidentID(residentId) {
    const printWindow = window.open(
        `/residentFolder/${residentId}/printid`, 
        '_blank',
        'toolbar=0,location=0,menubar=0,scrollbars=1,resizable=1'
    );
    if (printWindow) {
        printWindow.moveTo(0, 0);
        printWindow.resizeTo(screen.availWidth, screen.availHeight);
        printWindow.focus();
    }
}

function closeViewModal() {
    document.getElementById('viewResidentModal').classList.add('hidden');
}

// Close modal when clicking outside
document.getElementById('viewResidentModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeViewModal();
    }
});

// Delete Confirmation
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.delete-resident').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const form = this.closest('form');
            
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
});

// Form Validation
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

// Add this to your script section
document.addEventListener('DOMContentLoaded', function() {
    // Close dropdowns when clicking outside
    document.addEventListener('click', function(event) {
        if (!event.target.closest('.dropdown')) {
            document.querySelectorAll('.dropdown-menu').forEach(function(menu) {
                menu.classList.add('hidden');
            });
        }
    });

    // Toggle dropdown when clicking the button
    document.querySelectorAll('.dropdown-toggle').forEach(function(button) {
        button.addEventListener('click', function() {
            const menu = this.nextElementSibling;
            document.querySelectorAll('.dropdown-menu').forEach(function(otherMenu) {
                if (otherMenu !== menu) {
                    otherMenu.classList.add('hidden');
                }
            });
            menu.classList.toggle('hidden');
        });
    });
});
</script>
<script src="{{ asset('admin/assets/js/simple-datatables.js') }}"></script>
@endsection
