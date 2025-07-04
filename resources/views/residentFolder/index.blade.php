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
            <div class="flex min-h-screen items-start justify-center px-4" @click.self="open = false">
                <div x-show="open" x-transition x-transition.duration.300 class="panel my-8 w-full max-w-4xl overflow-hidden rounded-lg border-0 p-0">
                    <div class="flex items-center justify-between bg-[#fbfbfb] px-5 py-3 dark:bg-[#121c2c]">
                        <div class="text-lg font-bold">INDIVIDUAL RECORDS OF BARANGAY INHABITANT</div>
                        <button type="button" class="text-white-dark hover:text-dark" @click="toggle">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="h-6 w-6">
                                <line x1="18" y1="6" x2="6" y2="18"></line>
                                <line x1="6" y1="6" x2="18" y2="18"></line>
                            </svg>
                        </button>
                    </div>
                    
                    <div class="p-5">
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
                                            <input type="text" class="form-input" name="precinct_number" placeholder="Enter Precinct Number">
                                        </div>
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

                            <!-- REGION/PROVINCE SECTION -->
                            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                                <div>
                                    <label class="form-label">Region <span class="text-red-500">*</span></label>
                                    <input type="text" class="form-input" name="region" value="NEGROS ISLAND REGION" required>
                                </div>
                                <div>
                                    <label class="form-label">Province <span class="text-red-500">*</span></label>
                                    <input type="text" class="form-input" name="province" value="NEGROS OCCIDENTAL" required>
                                </div>
                                <div>
                                    <label class="form-label">City/Municipality <span class="text-red-500">*</span></label>
                                    <input type="text" class="form-input" name="city_municipality" value="HINOBA-AN" required>
                                </div>
                                <div>
                                    <label class="form-label">Barangay <span class="text-red-500">*</span></label>
                                    <input type="text" class="form-input" name="barangay" required placeholder="Enter Barangay">
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

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-4">
                                <div>
                                    <label class="form-label">Birth Date <span class="text-red-500">*</span></label>
                                    <input type="date" class="form-input" name="birth_date" required>
                                </div>
                                <div>
                                    <label class="form-label">Birth Place <span class="text-red-500">*</span></label>
                                    <input type="text" class="form-input" name="birth_place" required placeholder="Birth Place">
                                </div>
                                <div>
                                    <label class="form-label">Sex <span class="text-red-500">*</span></label>
                                    <select class="form-select" name="sex" required>
                                        <option value="">-Select-</option>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                    </select>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-4">
                                <div>
                                    <label class="form-label">Civil Status <span class="text-red-500">*</span></label>
                                    <select class="form-select" name="civil_status" required>
                                        <option value="">-Select-</option>
                                        <option value="Single">Single</option>
                                        <option value="Married">Married</option>
                                        <option value="Widowed">Widowed</option>
                                        <option value="Separated">Separated</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="form-label">Religion</label>
                                    <input type="text" class="form-input" name="religion" placeholder="Religion">
                                </div>
                                <div>
                                    <label class="form-label">Citizenship <span class="text-red-500">*</span></label>
                                    <input type="text" class="form-input" name="citizenship" required placeholder="Citizenship">
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label">Residence Address <span class="text-red-500">*</span></label>
                                <textarea class="form-textarea" name="address" rows="2" required placeholder="Complete Address"></textarea>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-4">
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
                            
                            <!-- Educational Attainment Section -->
                            <h3 class="font-bold mb-2">HIGHEST EDUCATIONAL ATTAINMENT</h3>
                            <hr>
                            <br>
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-4">
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
                            
                            <!-- Signature Section -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                <div>
                                    <label class="form-label">Household Number</label>
                                    <input type="text" class="form-input" name="household_number" value="H#-{{ str_pad(mt_rand(1, 9999999), 7, '0', STR_PAD_LEFT) }}" readonly>
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
// DataTable Initialization
document.addEventListener('alpine:init', () => {
    Alpine.data('multipleTable', () => ({
        datatable: null,
        init() {
            this.datatable = new simpleDatatables.DataTable('#residentTable', {
                data: {
                    headings: ['ID', 'Photo', 'Name', 'Voter status', 'Address', 'Contact', 'Actions'],
                    data: [
                        @foreach ($resident as $res)
                            [
                                '{{ $res->id }}',
                                `@if($res->profile_picture)
                                    <img src="{{ asset('storage/public/profile_pictures/' . basename($res->profile_picture)) }}" alt="Profile" class="w-10 h-10 rounded-full object-cover">
                                @else
                                    <div class="w-10 h-10 rounded-full bg-gray-300 flex items-center justify-center">
                                        <svg xmlns="" class="h-6 w-6 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                    </div>
                                @endif`,
                                '{{ $res->last_name }}, {{ $res->first_name }}',
                                '{{ $res->voter_status }}',
                                '{{ $res->address }}',
                                '{{ $res->contact_number }}',
                                `<div class="flex space-x-2">
                                    <button class="btn btn-sm btn-info" onclick="showResidentModal({{ $res->id }})">View</button>
                                    <button class="btn btn-sm btn-success" onclick="printResidentID({{ $res->id }})">Print ID</button>
                                    <a href="{{ route('resident.edit', $res->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                    <form action="{{ route('resident.destroy', $res->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-sm btn-danger delete-resident">
                                            Delete
                                        </button>
                                    </form>
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
                    { select: 4, sortable: true },
                    { select: 5, sortable: false },
                    { select: 6, sortable: false, type: 'html' }
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
</script>

<script src="{{ asset('admin/assets/js/simple-datatables.js') }}"></script>
@endsection