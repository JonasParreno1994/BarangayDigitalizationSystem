@extends('layouts.adminLayout.index')

@section('content')
<div class="animate__animated p-6" :class="[$store.app.animation]">
    <!-- Breadcrumb -->
    <ul class="flex space-x-2 rtl:space-x-reverse">
        <li><a href="{{ route('dashboard.residentsgraph') }}" class="text-primary hover:underline">Dashboard</a></li>
        <li class="before:content-['/'] ltr:before:mr-2 rtl:before:ml-2">
            <a href="{{ route('households.index') }}" class="text-primary hover:underline">Household Records</a>
        </li>
        <li class="before:content-['/'] ltr:before:mr-2 rtl:before:ml-2">
            <a href="{{ route('households.show', $household) }}" class="text-primary hover:underline">{{ $household->household_number }}</a>
        </li>
        <li class="before:content-['/'] ltr:before:mr-2 rtl:before:ml-2">
            <span>Edit Member</span>
        </li>
    </ul>

    <div class="pt-5">
        <div class="mb-5">
            <h5 class="text-lg font-semibold dark:text-white-light">Edit Member: <strong>{{ $member->full_name }}</strong></h5>
        </div>

        <div class="panel">
            <form action="{{ route('households.update-member', [$household, $member]) }}" method="POST">
                @csrf
                @method('PUT')
                
                <!-- Name Fields -->
                <div class="mb-5 grid grid-cols-1 gap-4 sm:grid-cols-12">
                    <div class="sm:col-span-4">
                        <label for="last_name" class="form-label">Last Name <span class="text-danger">*</span></label>
                        <input id="last_name" name="last_name" type="text" placeholder="Enter last name" 
                               class="form-input @error('last_name') border-red-500 @enderror" 
                               value="{{ old('last_name', $member->last_name) }}" required />
                        @error('last_name')<div class="mt-1 text-danger">{{ $message }}</div>@enderror
                    </div>
                    <div class="sm:col-span-4">
                        <label for="first_name" class="form-label">First Name <span class="text-danger">*</span></label>
                        <input id="first_name" name="first_name" type="text" placeholder="Enter first name" 
                               class="form-input @error('first_name') border-red-500 @enderror" 
                               value="{{ old('first_name', $member->first_name) }}" required />
                        @error('first_name')<div class="mt-1 text-danger">{{ $message }}</div>@enderror
                    </div>
                    <div class="sm:col-span-3">
                        <label for="middle_name" class="form-label">Middle Name</label>
                        <input id="middle_name" name="middle_name" type="text" placeholder="Middle name" 
                               class="form-input @error('middle_name') border-red-500 @enderror" 
                               value="{{ old('middle_name', $member->middle_name) }}" />
                        @error('middle_name')<div class="mt-1 text-danger">{{ $message }}</div>@enderror
                    </div>
                    <div class="sm:col-span-1">
                        <label for="extension" class="form-label">Ext</label>
                        <input id="extension" name="extension" type="text" placeholder="Jr." 
                               class="form-input @error('extension') border-red-500 @enderror" 
                               value="{{ old('extension', $member->extension) }}" />
                        @error('extension')<div class="mt-1 text-danger">{{ $message }}</div>@enderror
                    </div>
                </div>

                <!-- Birth and Personal Info -->
                <div class="mb-5 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
                    <div>
                        <label for="place_of_birth" class="form-label">Place of Birth</label>
                        <input id="place_of_birth" name="place_of_birth" type="text" placeholder="Enter place of birth" 
                               class="form-input @error('place_of_birth') border-red-500 @enderror" 
                               value="{{ old('place_of_birth', $member->place_of_birth) }}" />
                        @error('place_of_birth')<div class="mt-1 text-danger">{{ $message }}</div>@enderror
                    </div>
                    <div>
                        <label for="date_of_birth" class="form-label">Date of Birth</label>
                        <input id="date_of_birth" name="date_of_birth" type="date" 
                               class="form-input @error('date_of_birth') border-red-500 @enderror" 
                               value="{{ old('date_of_birth', $member->date_of_birth?->format('Y-m-d')) }}" />
                        @error('date_of_birth')<div class="mt-1 text-danger">{{ $message }}</div>@enderror
                    </div>
                    <div>
                        <label for="sex" class="form-label">Sex <span class="text-danger">*</span></label>
                        <select id="sex" name="sex" class="form-select @error('sex') border-red-500 @enderror" required>
                            <option value="">Select Sex</option>
                            <option value="Male" {{ old('sex', $member->sex) == 'Male' ? 'selected' : '' }}>Male</option>
                            <option value="Female" {{ old('sex', $member->sex) == 'Female' ? 'selected' : '' }}>Female</option>
                        </select>
                        @error('sex')<div class="mt-1 text-danger">{{ $message }}</div>@enderror
                    </div>
                    <div>
                        <label for="civil_status" class="form-label">Civil Status <span class="text-danger">*</span></label>
                        <select id="civil_status" name="civil_status" class="form-select @error('civil_status') border-red-500 @enderror" required>
                            <option value="">Select Status</option>
                            <option value="Single" {{ old('civil_status', $member->civil_status) == 'Single' ? 'selected' : '' }}>Single</option>
                            <option value="Married" {{ old('civil_status', $member->civil_status) == 'Married' ? 'selected' : '' }}>Married</option>
                            <option value="Widowed" {{ old('civil_status', $member->civil_status) == 'Widowed' ? 'selected' : '' }}>Widowed</option>
                            <option value="Divorced" {{ old('civil_status', $member->civil_status) == 'Divorced' ? 'selected' : '' }}>Divorced</option>
                            <option value="Separated" {{ old('civil_status', $member->civil_status) == 'Separated' ? 'selected' : '' }}>Separated</option>
                        </select>
                        @error('civil_status')<div class="mt-1 text-danger">{{ $message }}</div>@enderror
                    </div>
                </div>

                <!-- Additional Information -->
                <div class="mb-5 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
                    <div>
                        <label for="citizenship" class="form-label">Citizenship</label>
                        <input id="citizenship" name="citizenship" type="text" placeholder="e.g. Filipino" 
                               class="form-input @error('citizenship') border-red-500 @enderror" 
                               value="{{ old('citizenship', $member->citizenship) }}" />
                        @error('citizenship')<div class="mt-1 text-danger">{{ $message }}</div>@enderror
                    </div>
                    <div>
                        <label for="occupation" class="form-label">Occupation</label>
                        <input id="occupation" name="occupation" type="text" placeholder="Enter occupation" 
                               class="form-input @error('occupation') border-red-500 @enderror" 
                               value="{{ old('occupation', $member->occupation) }}" />
                        @error('occupation')<div class="mt-1 text-danger">{{ $message }}</div>@enderror
                    </div>
                    <div>
                        <label for="labor_employment_status" class="form-label">Labor/Employment Status</label>
                        <select id="labor_employment_status" name="labor_employment_status" 
                                class="form-select @error('labor_employment_status') border-red-500 @enderror">
                            <option value="">Select Status</option>
                            <option value="Labor/employed" {{ old('labor_employment_status', $member->labor_employment_status) == 'Labor/employed' ? 'selected' : '' }}>Labor/employed</option>
                            <option value="Unemployed" {{ old('labor_employment_status', $member->labor_employment_status) == 'Unemployed' ? 'selected' : '' }}>Unemployed</option>
                            <option value="PWD" {{ old('labor_employment_status', $member->labor_employment_status) == 'PWD' ? 'selected' : '' }}>PWD</option>
                            <option value="Solo Parent" {{ old('labor_employment_status', $member->labor_employment_status) == 'Solo Parent' ? 'selected' : '' }}>Solo Parent</option>
                            <option value="Out of School Youth (OSY)" {{ old('labor_employment_status', $member->labor_employment_status) == 'Out of School Youth (OSY)' ? 'selected' : '' }}>Out of School Youth (OSY)</option>
                            <option value="Out of School Children (OSC)" {{ old('labor_employment_status', $member->labor_employment_status) == 'Out of School Children (OSC)' ? 'selected' : '' }}>Out of School Children (OSC)</option>
                            <option value="IP" {{ old('labor_employment_status', $member->labor_employment_status) == 'IP' ? 'selected' : '' }}>IP</option>
                        </select>
                        @error('labor_employment_status')<div class="mt-1 text-danger">{{ $message }}</div>@enderror
                    </div>
                    <div>
                        <label for="relationship_to_head" class="form-label">Relationship to Head</label>
                        <input id="relationship_to_head" name="relationship_to_head" type="text" 
                               placeholder="e.g. Spouse, Child, Parent" 
                               class="form-input @error('relationship_to_head') border-red-500 @enderror" 
                               value="{{ old('relationship_to_head', $member->relationship_to_head) }}" />
                        @error('relationship_to_head')<div class="mt-1 text-danger">{{ $message }}</div>@enderror
                    </div>
                </div>

                <!-- Household Head Checkbox -->
                <div class="mb-5">
                    <label class="flex items-center cursor-pointer">
                        <!-- Hidden input to ensure unchecked checkbox sends false -->
                        <input type="hidden" name="is_head" value="0">
                        <input type="checkbox" 
                               id="is_head" 
                               name="is_head" 
                               value="1" 
                               class="form-checkbox" 
                               {{ old('is_head', $member->is_head) ? 'checked' : '' }}>
                        <span class="text-white-dark ltr:ml-2 rtl:mr-2">
                            <strong>This person is the household head</strong>
                            <small class="block text-xs text-white-dark">Check this if this person is the head of the household. This will unmark any existing household head.</small>
                        </span>
                    </label>
                </div>

                <div class="mt-8 flex items-center justify-end">
                    <a href="{{ route('households.show', $household) }}" class="btn btn-outline-danger">Cancel</a>
                    <button type="submit" class="btn btn-primary ltr:ml-4 rtl:mr-4">Update Member</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
