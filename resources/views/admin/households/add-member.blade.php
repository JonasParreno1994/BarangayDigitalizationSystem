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
            <span>Add Member</span>
        </li>
    </ul>

    <div class="pt-5">
        <div class="mb-5">
            <h5 class="text-lg font-semibold dark:text-white-light">Add Member to Household: <strong>{{ $household->household_number }}</strong></h5>
        </div>

        <div class="panel">
            <form action="{{ route('households.store-member', $household) }}" method="POST">
                @csrf
                
                <!-- Name Fields -->
                <div class="mb-5 grid grid-cols-1 gap-4 sm:grid-cols-12">
                    <div class="sm:col-span-4">
                        <label for="last_name" class="form-label">Last Name <span class="text-danger">*</span></label>
                        <input id="last_name" name="last_name" type="text" placeholder="Enter last name" 
                               class="form-input @error('last_name') border-red-500 @enderror" 
                               value="{{ old('last_name') }}" required />
                        @error('last_name')<div class="mt-1 text-danger">{{ $message }}</div>@enderror
                    </div>
                    <div class="sm:col-span-4">
                        <label for="first_name" class="form-label">First Name <span class="text-danger">*</span></label>
                        <input id="first_name" name="first_name" type="text" placeholder="Enter first name" 
                               class="form-input @error('first_name') border-red-500 @enderror" 
                               value="{{ old('first_name') }}" required />
                        @error('first_name')<div class="mt-1 text-danger">{{ $message }}</div>@enderror
                    </div>
                    <div class="sm:col-span-3">
                        <label for="middle_name" class="form-label">Middle Name</label>
                        <input id="middle_name" name="middle_name" type="text" placeholder="Middle name" 
                               class="form-input @error('middle_name') border-red-500 @enderror" 
                               value="{{ old('middle_name') }}" />
                        @error('middle_name')<div class="mt-1 text-danger">{{ $message }}</div>@enderror
                    </div>
                    <div class="sm:col-span-1">
                        <label for="extension" class="form-label">Ext</label>
                        <input id="extension" name="extension" type="text" placeholder="Jr., Sr." 
                               class="form-input @error('extension') border-red-500 @enderror" 
                               value="{{ old('extension') }}" />
                        @error('extension')<div class="mt-1 text-danger">{{ $message }}</div>@enderror
                    </div>
                </div>

                <!-- Personal Info -->
                <div class="mb-5 grid grid-cols-1 gap-4 sm:grid-cols-4">
                    <div>
                        <label for="place_of_birth" class="form-label">Place of Birth</label>
                        <input id="place_of_birth" name="place_of_birth" type="text" placeholder="Place of birth" 
                               class="form-input @error('place_of_birth') border-red-500 @enderror" 
                               value="{{ old('place_of_birth') }}" />
                        @error('place_of_birth')<div class="mt-1 text-danger">{{ $message }}</div>@enderror
                    </div>
                    <div>
                        <label for="date_of_birth" class="form-label">Date of Birth</label>
                        <input id="date_of_birth" name="date_of_birth" type="date" 
                               class="form-input @error('date_of_birth') border-red-500 @enderror" 
                               value="{{ old('date_of_birth') }}" />
                        @error('date_of_birth')<div class="mt-1 text-danger">{{ $message }}</div>@enderror
                    </div>
                    <div>
                        <label for="sex" class="form-label">Sex <span class="text-danger">*</span></label>
                        <select id="sex" name="sex" class="form-select @error('sex') border-red-500 @enderror" required>
                            <option value="">Select Sex</option>
                            <option value="Male" {{ old('sex') == 'Male' ? 'selected' : '' }}>Male</option>
                            <option value="Female" {{ old('sex') == 'Female' ? 'selected' : '' }}>Female</option>
                        </select>
                        @error('sex')<div class="mt-1 text-danger">{{ $message }}</div>@enderror
                    </div>
                    <div>
                        <label for="civil_status" class="form-label">Civil Status <span class="text-danger">*</span></label>
                        <select id="civil_status" name="civil_status" class="form-select @error('civil_status') border-red-500 @enderror" required>
                            <option value="">Select Status</option>
                            <option value="Single" {{ old('civil_status') == 'Single' ? 'selected' : '' }}>Single</option>
                            <option value="Married" {{ old('civil_status') == 'Married' ? 'selected' : '' }}>Married</option>
                            <option value="Widowed" {{ old('civil_status') == 'Widowed' ? 'selected' : '' }}>Widowed</option>
                            <option value="Divorced" {{ old('civil_status') == 'Divorced' ? 'selected' : '' }}>Divorced</option>
                            <option value="Separated" {{ old('civil_status') == 'Separated' ? 'selected' : '' }}>Separated</option>
                        </select>
                        @error('civil_status')<div class="mt-1 text-danger">{{ $message }}</div>@enderror
                    </div>
                </div>

                <!-- Additional Info -->
                <div class="mb-5 grid grid-cols-1 gap-4 sm:grid-cols-4">
                    <div>
                        <label for="citizenship" class="form-label">Citizenship</label>
                        <input id="citizenship" name="citizenship" type="text" placeholder="e.g. Filipino" 
                               class="form-input @error('citizenship') border-red-500 @enderror" 
                               value="{{ old('citizenship') }}" />
                        @error('citizenship')<div class="mt-1 text-danger">{{ $message }}</div>@enderror
                    </div>
                    <div>
                        <label for="occupation" class="form-label">Occupation</label>
                        <input id="occupation" name="occupation" type="text" placeholder="Occupation" 
                               class="form-input @error('occupation') border-red-500 @enderror" 
                               value="{{ old('occupation') }}" />
                        @error('occupation')<div class="mt-1 text-danger">{{ $message }}</div>@enderror
                    </div>
                    <div>
                        <label for="labor_employment_status" class="form-label">Labor/Employment Status</label>
                        <select id="labor_employment_status" name="labor_employment_status" class="form-select @error('labor_employment_status') border-red-500 @enderror">
                            <option value="">Select Status</option>
                            <option value="Labor/employed" {{ old('labor_employment_status') == 'Labor/employed' ? 'selected' : '' }}>Labor/employed</option>
                            <option value="Unemployed" {{ old('labor_employment_status') == 'Unemployed' ? 'selected' : '' }}>Unemployed</option>
                            <option value="PWD" {{ old('labor_employment_status') == 'PWD' ? 'selected' : '' }}>PWD</option>
                            <option value="Solo Parent" {{ old('labor_employment_status') == 'Solo Parent' ? 'selected' : '' }}>Solo Parent</option>
                            <option value="Out of School Youth (OSY)" {{ old('labor_employment_status') == 'Out of School Youth (OSY)' ? 'selected' : '' }}>Out of School Youth (OSY)</option>
                            <option value="Out of School Children (OSC)" {{ old('labor_employment_status') == 'Out of School Children (OSC)' ? 'selected' : '' }}>Out of School Children (OSC)</option>
                            <option value="IP" {{ old('labor_employment_status') == 'IP' ? 'selected' : '' }}>IP</option>
                        </select>
                        @error('labor_employment_status')<div class="mt-1 text-danger">{{ $message }}</div>@enderror
                    </div>
                    <div>
                        <label for="relationship_to_head" class="form-label">Relationship to Head</label>
                        <input id="relationship_to_head" name="relationship_to_head" type="text" placeholder="e.g. Spouse, Child" 
                               class="form-input @error('relationship_to_head') border-red-500 @enderror" 
                               value="{{ old('relationship_to_head') }}" />
                        @error('relationship_to_head')<div class="mt-1 text-danger">{{ $message }}</div>@enderror
                    </div>
                </div>

                <!-- Household Head Checkbox -->
                <div class="mb-5">
                    <label class="flex items-center">
                        <input type="checkbox" name="is_head" value="1" class="form-checkbox" {{ old('is_head') ? 'checked' : '' }} />
                        <span class="text-white-dark ml-2">This person is the household head</span>
                    </label>
                    <div class="text-xs text-white-dark mt-1">Check this if this person is the head of the household. This will unmark any existing household head.</div>
                </div>

                <div class="mt-8 flex items-center justify-end">
                    <a href="{{ route('households.show', $household) }}" class="btn btn-outline-danger">Cancel</a>
                    <button type="submit" class="btn btn-primary ltr:ml-4 rtl:mr-4">Add Member</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('title', 'Add Household Member')

@section('content')
<div class="page-content">
    <div class="container-fluid">
        
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Add Household Member</h4>
                    
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('households.index') }}">Households</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('households.show', $household) }}">{{ $household->household_number }}</a></li>
                            <li class="breadcrumb-item active">Add Member</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">
                            Add Member to Household: <strong>{{ $household->household_number }}</strong>
                        </h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('households.store-member', $household) }}" method="POST">
                            @csrf
                            
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="last_name" class="form-label">Last Name <span class="text-danger">*</span></label>
                                        <input type="text" 
                                               class="form-control @error('last_name') is-invalid @enderror" 
                                               id="last_name" 
                                               name="last_name" 
                                               value="{{ old('last_name') }}" 
                                               required>
                                        @error('last_name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="first_name" class="form-label">First Name <span class="text-danger">*</span></label>
                                        <input type="text" 
                                               class="form-control @error('first_name') is-invalid @enderror" 
                                               id="first_name" 
                                               name="first_name" 
                                               value="{{ old('first_name') }}" 
                                               required>
                                        @error('first_name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label for="middle_name" class="form-label">Middle Name</label>
                                        <input type="text" 
                                               class="form-control @error('middle_name') is-invalid @enderror" 
                                               id="middle_name" 
                                               name="middle_name" 
                                               value="{{ old('middle_name') }}">
                                        @error('middle_name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-1">
                                    <div class="mb-3">
                                        <label for="extension" class="form-label">Ext</label>
                                        <input type="text" 
                                               class="form-control @error('extension') is-invalid @enderror" 
                                               id="extension" 
                                               name="extension" 
                                               value="{{ old('extension') }}" 
                                               placeholder="Jr., Sr.">
                                        @error('extension')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="place_of_birth" class="form-label">Place of Birth</label>
                                        <input type="text" 
                                               class="form-control @error('place_of_birth') is-invalid @enderror" 
                                               id="place_of_birth" 
                                               name="place_of_birth" 
                                               value="{{ old('place_of_birth') }}">
                                        @error('place_of_birth')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="date_of_birth" class="form-label">Date of Birth</label>
                                        <input type="date" 
                                               class="form-control @error('date_of_birth') is-invalid @enderror" 
                                               id="date_of_birth" 
                                               name="date_of_birth" 
                                               value="{{ old('date_of_birth') }}">
                                        @error('date_of_birth')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="mb-3">
                                        <label for="sex" class="form-label">Sex <span class="text-danger">*</span></label>
                                        <select class="form-select @error('sex') is-invalid @enderror" 
                                                id="sex" 
                                                name="sex" 
                                                required>
                                            <option value="">Select Sex</option>
                                            <option value="Male" {{ old('sex') == 'Male' ? 'selected' : '' }}>Male</option>
                                            <option value="Female" {{ old('sex') == 'Female' ? 'selected' : '' }}>Female</option>
                                        </select>
                                        @error('sex')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="mb-3">
                                        <label for="civil_status" class="form-label">Civil Status <span class="text-danger">*</span></label>
                                        <select class="form-select @error('civil_status') is-invalid @enderror" 
                                                id="civil_status" 
                                                name="civil_status" 
                                                required>
                                            <option value="">Select Status</option>
                                            <option value="Single" {{ old('civil_status') == 'Single' ? 'selected' : '' }}>Single</option>
                                            <option value="Married" {{ old('civil_status') == 'Married' ? 'selected' : '' }}>Married</option>
                                            <option value="Widowed" {{ old('civil_status') == 'Widowed' ? 'selected' : '' }}>Widowed</option>
                                            <option value="Divorced" {{ old('civil_status') == 'Divorced' ? 'selected' : '' }}>Divorced</option>
                                            <option value="Separated" {{ old('civil_status') == 'Separated' ? 'selected' : '' }}>Separated</option>
                                        </select>
                                        @error('civil_status')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label for="citizenship" class="form-label">Citizenship</label>
                                        <input type="text" 
                                               class="form-control @error('citizenship') is-invalid @enderror" 
                                               id="citizenship" 
                                               name="citizenship" 
                                               value="{{ old('citizenship') }}" 
                                               placeholder="e.g. Filipino">
                                        @error('citizenship')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label for="occupation" class="form-label">Occupation</label>
                                        <input type="text" 
                                               class="form-control @error('occupation') is-invalid @enderror" 
                                               id="occupation" 
                                               name="occupation" 
                                               value="{{ old('occupation') }}">
                                        @error('occupation')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label for="labor_employment_status" class="form-label">Labor/Employment Status</label>
                                        <select class="form-select @error('labor_employment_status') is-invalid @enderror" 
                                                id="labor_employment_status" 
                                                name="labor_employment_status">
                                            <option value="">Select Status</option>
                                            <option value="Labor/employed" {{ old('labor_employment_status') == 'Labor/employed' ? 'selected' : '' }}>Labor/employed</option>
                                            <option value="Unemployed" {{ old('labor_employment_status') == 'Unemployed' ? 'selected' : '' }}>Unemployed</option>
                                            <option value="PWD" {{ old('labor_employment_status') == 'PWD' ? 'selected' : '' }}>PWD</option>
                                            <option value="Solo Parent" {{ old('labor_employment_status') == 'Solo Parent' ? 'selected' : '' }}>Solo Parent</option>
                                            <option value="Out of School Youth (OSY)" {{ old('labor_employment_status') == 'Out of School Youth (OSY)' ? 'selected' : '' }}>Out of School Youth (OSY)</option>
                                            <option value="Out of School Children (OSC)" {{ old('labor_employment_status') == 'Out of School Children (OSC)' ? 'selected' : '' }}>Out of School Children (OSC)</option>
                                            <option value="IP" {{ old('labor_employment_status') == 'IP' ? 'selected' : '' }}>IP</option>
                                        </select>
                                        @error('labor_employment_status')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label for="relationship_to_head" class="form-label">Relationship to Head</label>
                                        <input type="text" 
                                               class="form-control @error('relationship_to_head') is-invalid @enderror" 
                                               id="relationship_to_head" 
                                               name="relationship_to_head" 
                                               value="{{ old('relationship_to_head') }}" 
                                               placeholder="e.g. Spouse, Child, Parent">
                                        @error('relationship_to_head')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-check mb-3">
                                        <!-- Hidden input to ensure unchecked checkbox sends false -->
                                        <input type="hidden" name="is_head" value="0">
                                        <input class="form-check-input" 
                                               type="checkbox" 
                                               id="is_head" 
                                               name="is_head" 
                                               value="1" 
                                               {{ old('is_head') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_head">
                                            <strong>This person is the household head</strong>
                                        </label>
                                        <small class="text-muted d-block">Check this if this person is the head of the household. This will unmark any existing household head.</small>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12">
                                    <div class="d-flex justify-content-end gap-2">
                                        <a href="{{ route('households.show', $household) }}" class="btn btn-secondary">
                                            <i class="mdi mdi-arrow-left"></i> Cancel
                                        </a>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="mdi mdi-content-save"></i> Add Member
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
