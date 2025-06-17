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

</style>

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
                        <form id="residentForm" action="{{ route('resident.store') }}" method="POST">
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
                                <h3 class="font-bold mb-2">VOTER STATUS</h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                                    <div>
                                        <label class="inline-flex items-center">
                                            <input type="radio" class="form-radio" name="voter_status" value="Voter" checked>
                                            <span class="ml-2">Registered Voter</span>
                                        </label>
                                    </div>
                                    <div>
                                        <label class="inline-flex items-center">
                                            <input type="radio" class="form-radio" name="voter_status" value="Non-Voter">
                                            <span class="ml-2">Non-Voter</span>
                                        </label>
                                    </div>
                                </div>

                                <!-- If Voter, add additional fields -->
                                <div x-data="{ isVoter: true }" x-show="isVoter" x-transition>
                                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-4" x-show="isVoter">
                                        
                                        <div>
                                            <label class="form-label">Precinct Number</label>
                                            <input type="text" class="form-input" name="precinct_number" disabled>
                                        </div>
                                    </div>
                                </div>

                                <script>
                                    document.addEventListener('alpine:init', () => {
                                        Alpine.data('voterStatus', () => ({
                                            isVoter: true,
                                            init() {
                                                // Watch for changes in voter status
                                                const voterStatusRadios = document.querySelectorAll('input[name="voter_status"]');
                                                voterStatusRadios.forEach(radio => {
                                                    radio.addEventListener('change', (e) => {
                                                        this.isVoter = (e.target.value === 'Voter');
                                                    });
                                                });
                                            }
                                        }));
                                    });
                                </script>
                            
                            <!-- Region/Province Section -->
                            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                                <div><label class="form-label">REGION</label><input type="text" class="form-input" name="region" value="NEGROS ISLAND REGION" required></div>
                                  <div><label class="form-label">PROVINCE</label><input type="text" class="form-input" name="province" value="NEGROS OCCIDENTAL" required></div>
                                  <div><label class="form-label">CITY/MUNICIPALITY</label><input type="text" class="form-input" name="city_municipality" value="HINOBA-AN" required></div>
                                <div><label class="form-label">BARANGAY</label><input type="text" class="form-input" name="barangay" required></div>
                            </div>
                            
                            <hr class="my-6 border-gray-200">
                            
                            <!-- Personal Information Section -->
                            <h2 class="text-xl font-bold mb-4">PERSONAL INFORMATION</h2>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4 ">
                                <div>
                                    <label class="form-label">Philsys Card Number</label>
                                    <input type="text" class="form-input" name="census_no">
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-4">
                                <div>
                                    <label class="form-label">Last Name</label>
                                    <input type="text" class="form-input" name="last_name" required>
                                </div>
                               
                                <div>
                                    <label class="form-label">First Name</label>
                                    <input type="text" class="form-input" name="first_name" required>
                                </div>
                                <div>
                                    <label class="form-label">Middle Name</label>
                                    <input type="text" class="form-input" name="middle_name">
                                </div>
                                <div class="col-span-1 md:col-span-1">
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
                            
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                                <div>
                                    <label class="form-label">Birth Date</label>
                                    <input type="date" class="form-input" name="birth_date" required>
                                </div>
                                <div>
                                    <label class="form-label">Birth Place</label>
                                    <input type="text" class="form-input" name="birth_place" required>
                                </div>
                                <div>
                                    <label class="form-label">Sex</label>
                                    <select class="form-select" name="sex" required>
                                        <option value="">-Select-</option>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                                <div>
                                    <label class="form-label">Civil Status</label>
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
                                    <input type="text" class="form-input" name="religion">
                                </div>
                                <div>
                                    <label class="form-label">Citizenship</label>
                                    <input type="text" class="form-input" name="citizenship" required>
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-1 gap-4 mb-4">
                                <div>
                                    <label class="form-label">Residence Address</label>
                                    <textarea class="form-textarea" name="address" rows="2" required></textarea>
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                                <div>
                                    <label class="form-label">Profession/Occupation</label>
                                    <input type="text" class="form-input" name="occupation">
                                </div>
                                <div>
                                    <label class="form-label">Contact Number</label>
                                    <input type="text" class="form-input" name="contact_number">
                                </div>
                                <div>
                                    <label class="form-label">Email Address</label>
                                    <input type="email" class="form-input" name="email">
                                </div>
                            </div>
                            
                            <!-- Educational Attainment Section -->
                            <h3 class="font-bold mb-2">HIGHEST EDUCATIONAL ATTAINMENT</h3>
                            <hr>
                            <br>
                            <div class="grid grid-cols-4 gap-4 mb-4">
                                <div>
                                    <label class="inline-flex items-center">
                                        <input type="radio" class="form-radio" name="education" value="Elementary">
                                        <span class="ml-2">Elementary</span>
                                    </label>
                                </div>
                                <div>
                                    <label class="inline-flex items-center">
                                        <input type="radio" class="form-radio" name="education" value="High School">
                                        <span class="ml-2">High School</span>
                                    </label>
                                </div>
                                <div>
                                    <label class="inline-flex items-center">
                                        <input type="radio" class="form-radio" name="education" value="College">
                                        <span class="ml-2">College</span>
                                    </label>
                                </div>
                                <div>
                                    <label class="inline-flex items-center">
                                        <input type="radio" class="form-radio" name="education" value="Post Grad">
                                        <span class="ml-2">Post Grad</span>
                                    </label>
                                </div>
                                <div>
                                    <label class="inline-flex items-center">
                                        <input type="radio" class="form-radio" name="education" value="Vocational">
                                        <span class="ml-2">Vocational</span>
                                    </label>
                                </div>
                                <div>
                                    <label class="inline-flex items-center">
                                        <input type="radio" class="form-radio" name="education" value="Master's">
                                        <span class="ml-2">Master's</span>
                                    </label>
                                </div>
                                <div>
                                    <label class="inline-flex items-center">
                                        <input type="radio" class="form-radio" name="education" value="Doctorate">
                                        <span class="ml-2">Doctorate</span>
                                    </label>
                                </div>
                                <div>
                                    <label class="inline-flex items-center">
                                        <input type="radio" class="form-radio" name="education" value="Professional">
                                        <span class="ml-2">Professional</span>
                                    </label>
                                </div>
                                <div>
                                    <label class="inline-flex items-center">
                                        <input type="radio" class="form-radio" name="education" value="Technical">
                                        <span class="ml-2">Technical</span>
                                    </label>
                                </div>
                                <div>
                                    <label class="inline-flex items-center">
                                        <input type="radio" class="form-radio" name="education" value="Other">
                                        <span class="ml-2">Other</span>
                                    </label>
                                </div>
                            </div>
                            <hr>
                            <br>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                                <div>
                                    <label class="inline-flex items-center">
                                        <input type="radio" class="form-radio" name="education_status" value="Graduate">
                                        <span class="ml-2">Graduate</span>
                                    </label>
                                </div>
                                <div>
                                    <label class="inline-flex items-center">
                                        <input type="radio" class="form-radio" name="education_status" value="Under Graduate">
                                        <span class="ml-2">Under Graduate</span>
                                    </label>
                                </div>
                            </div>
                            
                       
                            <!-- Signature Section -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                              
                                <div>
                                    <label class="form-label">Household Number</label>
                                    <input type="text" class="form-input" name="household_number" value="H#-{{ str_pad(mt_rand(1, 9999999), 7, '0', STR_PAD_LEFT) }}" readonly></div>
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
    </div>
</div>

<!-- Success/Error Messages -->
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

<!-- DataTable Initialization -->
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('multipleTable', () => ({
            datatable: null,
            init() {
                this.datatable = new simpleDatatables.DataTable('#residentTable', {
                    data: {
                        headings: ['ID', 'Name','Voter status', 'Address', 'Contact', 'Actions'],
                        data: [
                            @foreach ($resident as $res)
                                [
                                    '{{ $res->id }}',
                                    '{{ $res->last_name }}, {{ $res->first_name }}',
                                    '{{ $res->voter_status }}',
                                    '{{ $res->address }}',
                                    '{{ $res->contact_number }}',
                                    `<div class="flex space-x-2">
                                        <a href="{{ route('resident.edit', $res->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                        <form action="{{ route('resident.destroy', $res->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
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
                        { select: 1, sortable: true },
                        { select: 2, sortable: true },
                        { select: 3, sortable: true },
                        { select: 4, sortable: false }
                    ],
                    // ... (keep your existing datatable options)
                });
            },
        }));
    });
</script>

<script src="{{ asset('admin/assets/js/simple-datatables.js') }}"></script>

@endsection