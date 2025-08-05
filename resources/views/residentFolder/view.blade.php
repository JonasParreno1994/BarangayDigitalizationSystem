<div class="space-y-8">
    <!-- Personal Information Section -->
    <div class="bg-white rounded-lg shadow p-6 border">
        <h2 class="text-xl font-bold mb-4 flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 15c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
            PERSONAL INFORMATION
        </h2>
        <div class="flex flex-col md:flex-row md:items-center gap-6 mb-4">
            <!-- Profile Image -->
            <div class="flex-shrink-0 flex justify-center md:justify-start">
                @if($resident->profile_picture)
                    <img src="{{ asset('storage/public/profile_pictures/' . basename($resident->profile_picture)) }}" alt="Profile Image" class="w-32 h-32 rounded-full object-cover border shadow">
                @else
                    <div class="w-32 h-32 rounded-full bg-gray-200 flex items-center justify-center border shadow text-gray-400 text-6xl">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                @endif
            </div>
            <!-- Personal Details -->
            <div class="flex-1">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <label class="form-label">Last Name</label>
                        <div class="form-input bg-gray-100">{{ $resident->last_name }}</div>
                    </div>
                    <div>
                        <label class="form-label">First Name</label>
                        <div class="form-input bg-gray-100">{{ $resident->first_name }}</div>
                    </div>
                    <div>
                        <label class="form-label">Middle Name</label>
                        <div class="form-input bg-gray-100">{{ $resident->middle_name }}</div>
                    </div>
                    <div>
                        <label class="form-label">Suffix</label>
                        <div class="form-input bg-gray-100">{{ $resident->suffix ?: 'None' }}</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
            <div>
                <label class="form-label">Birth Date</label>
                <div class="form-input bg-gray-100">{{ \Carbon\Carbon::parse($resident->birth_date)->format('F d, Y') }}</div>
            </div>
            <div>
                <label class="form-label">Age</label>
                <div class="form-input bg-gray-100">{{ \Carbon\Carbon::parse($resident->birth_date)->age }} years old</div>
            </div>
            <div>
                <label class="form-label">Sex</label>
                <div class="form-input bg-gray-100">{{ $resident->sex }}</div>
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
            <div>
                <label class="form-label">Civil Status</label>
                <div class="form-input bg-gray-100">{{ $resident->civil_status }}</div>
            </div>
            <div>
                <label class="form-label">Citizenship</label>
                <div class="form-input bg-gray-100">{{ $resident->citizenship }}</div>
            </div>
            <div>
                <label class="form-label">Religion</label>
                <div class="form-input bg-gray-100">{{ $resident->religion ?? 'N/A' }}</div>
            </div>
        </div>
    </div>

    <!-- Special Population Information Section -->
    <div class="bg-white rounded-lg shadow p-6 border">
        <h2 class="text-xl font-bold mb-4 flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
            </svg>
            SPECIAL POPULATION INFORMATION
        </h2>

        <!-- Senior Citizen Information -->
        <div class="mb-6 border-b pb-4">
            <h3 class="text-lg font-semibold mb-3 flex items-center gap-2 text-orange-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                SENIOR CITIZEN INFORMATION
            </h3>
            
            @if($resident->is_senior_citizen)
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="form-label">Status</label>
                        <div class="form-input bg-green-100 text-green-800 font-bold">REGISTERED SENIOR CITIZEN</div>
                    </div>
                    <div>
                        <label class="form-label">Senior Citizen ID</label>
                        <div class="form-input bg-gray-100">{{ $resident->senior_citizen_id ?? 'Not specified' }}</div>
                    </div>
                    <div>
                        <label class="form-label">Age</label>
                        <div class="form-input bg-gray-100">{{ $resident->age }} years old</div>
                    </div>
                    <div>
                        <label class="form-label">Benefits Received</label>
                        <div class="form-input bg-gray-100">
                            {{ $resident->senior_benefits ?? 'Not specified' }}
                        </div>
                    </div>
                </div>
            @else
                <div class="text-center py-2 text-gray-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mx-auto mb-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <p>This resident is not registered as a Senior Citizen</p>
                </div>
            @endif
        </div>

        <!-- PWD Information -->
        <div class="mb-6 border-b pb-4">
            <h3 class="text-lg font-semibold mb-3 flex items-center gap-2 text-red-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
                PERSON WITH DISABILITY (PWD) INFORMATION
            </h3>
            
            @if($resident->is_pwd)
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="form-label">Status</label>
                        <div class="form-input bg-green-100 text-green-800 font-bold">REGISTERED PWD</div>
                    </div>
                    <div>
                        <label class="form-label">PWD ID Number</label>
                        <div class="form-input bg-gray-100">{{ $resident->pwd_id ?? 'Not specified' }}</div>
                    </div>
                    <div>
                        <label class="form-label">Disability Type</label>
                        <div class="form-input bg-gray-100">{{ $resident->pwd_type ?? 'Not specified' }}</div>
                    </div>
                    <div>
                        <label class="form-label">Benefits Received</label>
                        <div class="form-input bg-gray-100">
                            {{ $resident->pwd_benefits ?? 'Not specified' }}
                        </div>
                    </div>
                </div>
            @else
                <div class="text-center py-2 text-gray-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mx-auto mb-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <p>This resident is not registered as a Person with Disability</p>
                </div>
            @endif
        </div>

        <!-- Solo Parent Information -->
        <div class="mb-2">
            <h3 class="text-lg font-semibold mb-3 flex items-center gap-2 text-blue-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
                SOLO PARENT INFORMATION
            </h3>
            
            @if($resident->is_solo_parent)
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="form-label">Status</label>
                        <div class="form-input bg-green-100 text-green-800 font-bold">REGISTERED SOLO PARENT</div>
                    </div>
                    <div>
                        <label class="form-label">Solo Parent ID</label>
                        <div class="form-input bg-gray-100">{{ $resident->solo_parent_id ?? 'Not specified' }}</div>
                    </div>
                    <div>
                        <label class="form-label">Civil Status</label>
                        <div class="form-input bg-gray-100">{{ $resident->civil_status }}</div>
                    </div>
                    <div>
                        <label class="form-label">Number of Children</label>
                        <div class="form-input bg-gray-100">
                            {{ $resident->number_of_children ?? 'Not specified' }}
                        </div>
                    </div>
                    <div>
                        <label class="form-label">Benefits Received</label>
                        <div class="form-input bg-gray-100">
                            {{ $resident->solo_parent_benefits ?? 'Not specified' }}
                        </div>
                    </div>
                </div>
            @else
                <div class="text-center py-2 text-gray-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mx-auto mb-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <p>This resident is not registered as a Solo Parent</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Address Information Section -->
    <div class="bg-white rounded-lg shadow p-6 border">
        <h2 class="text-xl font-bold mb-4 flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2h5" /></svg>
            ADDRESS INFORMATION
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-4">
            <div>
                <label class="form-label">Region</label>
                <div class="form-input bg-gray-100">{{ $resident->region }}</div>
            </div>
            <div>
                <label class="form-label">Province</label>
                <div class="form-input bg-gray-100">{{ $resident->province }}</div>
            </div>
            <div>
                <label class="form-label">City/Municipality</label>
                <div class="form-input bg-gray-100">{{ $resident->city_municipality }}</div>
            </div>
            <div>
                <label class="form-label">Barangay</label>
                <div class="form-input bg-gray-100">{{ $resident->barangay }}</div>
            </div>
        </div>
       <div class="mb-4">
            <label class="form-label">Purok</label>
            <div class="form-input bg-gray-100">
                {{ \App\Models\Purok::find($resident->purok_id)->purok_name ?? 'No purok selected' }}
            </div>
        </div>
    </div>

    <!-- Contact Information Section -->
    <div class="bg-white rounded-lg shadow p-6 border">
        <h2 class="text-xl font-bold mb-4 flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m0 4v2m0 4v2m0 4v2m0 4v2" /></svg>
            CONTACT INFORMATION
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
            <div>
                <label class="form-label">Contact Number</label>
                <div class="form-input bg-gray-100">{{ $resident->contact_number ?? 'N/A' }}</div>
            </div>
            <div>
                <label class="form-label">Email Address</label>
                <div class="form-input bg-gray-100">{{ $resident->email ?? 'N/A' }}</div>
            </div>
        </div>
    </div>

    <!-- Other Information Section -->
    <div class="bg-white rounded-lg shadow p-6 border">
        <h2 class="text-xl font-bold mb-4 flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0 10c-2.21 0-4-1.79-4-4h2a2 2 0 004 0h2c0 2.21-1.79 4-4 4z" /></svg>
            OTHER INFORMATION
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
            <div>
                <label class="form-label">Voter Status</label>
                <div class="form-input bg-gray-100">{{ $resident->voter_status }}</div>
            </div>
            @if($resident->voter_status === 'Voter')
            <div>
                <label class="form-label">Precinct Number</label>
                <div class="form-input bg-gray-100">{{ $resident->precinct_number ?? 'N/A' }}</div>
            </div>
            @endif
            <div>
                <label class="form-label">Occupation</label>
                <div class="form-input bg-gray-100">{{ $resident->occupation ?? 'N/A' }}</div>
            </div>
            <div>
                <label class="form-label">Education</label>
                <div class="form-input bg-gray-100">{{ $resident->education ?? 'N/A' }}</div>
            </div>
            <div>
                <label class="form-label">Education Status</label>
                <div class="form-input bg-gray-100">{{ $resident->education_status ?? 'N/A' }}</div>
            </div>
            <div>
                <label class="form-label">Household Number</label>
                <div class="form-input bg-gray-100">{{ $resident->household_number ?? 'N/A' }}</div>
            </div>
        </div>
        <div class="flex justify-end px-5 py-3 border-t space-x-2">
            <button onclick="window.open('{{ route('resident.print', $resident->id) }}', '_blank')" 
                class="btn btn-primary ltr:mr-2 rtl:ml-2">
            <i class="fas fa-print ltr:mr-1 rtl:ml-1"></i>
            Print
            </button>
            <button type="button" class="btn btn-outline-danger" onclick="closeViewModal()">
            <i class="fas fa-times ltr:mr-1 rtl:ml-1"></i>
            Close
            </button>
            <a href="{{ route('resident.files.index', $resident->id) }}" class="btn btn-primary">
            <i class="fas fa-file"></i> Manage Files
            </a>
        </div>
    </div>
