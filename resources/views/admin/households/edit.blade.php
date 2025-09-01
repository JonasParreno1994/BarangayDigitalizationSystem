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
            <span>Edit</span>
        </li>
    </ul>

    <div class="pt-5">
        <div class="mb-5">
            <h5 class="text-lg font-semibold dark:text-white-light">Edit Household Information</h5>
        </div>

        <div class="panel">
            <form action="{{ route('households.update', $household) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="mb-5 grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div>
                        <label for="household_number" class="form-label">Household Number <span class="text-danger">*</span></label>
                        <input id="household_number" name="household_number" type="text" 
                               class="form-input @error('household_number') border-red-500 @enderror" 
                               value="{{ old('household_number', $household->household_number) }}" required />
                        @error('household_number')<div class="mt-1 text-danger">{{ $message }}</div>@enderror
                    </div>
                    <div>
                        <label for="region" class="form-label">Region</label>
                        <input id="region" name="region" type="text" placeholder="Enter region" 
                               class="form-input @error('region') border-red-500 @enderror" 
                               value="{{ old('region', $household->region) }}" />
                        @error('region')<div class="mt-1 text-danger">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="mb-5 grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div>
                        <label for="province" class="form-label">Province</label>
                        <input id="province" name="province" type="text" placeholder="Enter province" 
                               class="form-input @error('province') border-red-500 @enderror" 
                               value="{{ old('province', $household->province) }}" />
                        @error('province')<div class="mt-1 text-danger">{{ $message }}</div>@enderror
                    </div>
                    <div>
                        <label for="city_municipality" class="form-label">City/Municipality</label>
                        <input id="city_municipality" name="city_municipality" type="text" placeholder="Enter city/municipality" 
                               class="form-input @error('city_municipality') border-red-500 @enderror" 
                               value="{{ old('city_municipality', $household->city_municipality) }}" />
                        @error('city_municipality')<div class="mt-1 text-danger">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="mb-5 grid grid-cols-1 gap-4 sm:grid-cols-3">
                    <div>
                        <label for="barangay" class="form-label">Barangay</label>
                        <input id="barangay" name="barangay" type="text" placeholder="Enter barangay" 
                               class="form-input @error('barangay') border-red-500 @enderror" 
                               value="{{ old('barangay', $household->barangay) }}" />
                        @error('barangay')<div class="mt-1 text-danger">{{ $message }}</div>@enderror
                    </div>
                    <div>
                        <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                        <select id="status" name="status" class="form-select @error('status') border-red-500 @enderror" required>
                            <option value="Active" {{ old('status', $household->status) == 'Active' ? 'selected' : '' }}>Active</option>
                            <option value="Inactive" {{ old('status', $household->status) == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                        @error('status')<div class="mt-1 text-danger">{{ $message }}</div>@enderror
                    </div>
                    <div>
                        <label for="household_address" class="form-label">Household Address</label>
                        <textarea id="household_address" name="household_address" rows="3" placeholder="Enter complete household address" 
                                  class="form-textarea @error('household_address') border-red-500 @enderror">{{ old('household_address', $household->household_address) }}</textarea>
                        @error('household_address')<div class="mt-1 text-danger">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="mt-8 flex items-center justify-end">
                    <a href="{{ route('households.show', $household) }}" class="btn btn-outline-danger">Cancel</a>
                    <button type="submit" class="btn btn-primary ltr:ml-4 rtl:mr-4">Update Household</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('title', 'Edit Household')

@section('content')
<div class="page-content">
    <div class="container-fluid">
        
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Edit Household</h4>
                    
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('households.index') }}">Households</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('households.show', $household) }}">{{ $household->household_number }}</a></li>
                            <li class="breadcrumb-item active">Edit</li>
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
                        <h4 class="card-title">Edit Household Information</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('households.update', $household) }}" method="POST">
                            @csrf
                            @method('PUT')
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="household_number" class="form-label">Household Number <span class="text-danger">*</span></label>
                                        <input type="text" 
                                               class="form-control @error('household_number') is-invalid @enderror" 
                                               id="household_number" 
                                               name="household_number" 
                                               value="{{ old('household_number', $household->household_number) }}" 
                                               required>
                                        @error('household_number')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="region" class="form-label">Region</label>
                                        <input type="text" 
                                               class="form-control @error('region') is-invalid @enderror" 
                                               id="region" 
                                               name="region" 
                                               value="{{ old('region', $household->region) }}">
                                        @error('region')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="province" class="form-label">Province</label>
                                        <input type="text" 
                                               class="form-control @error('province') is-invalid @enderror" 
                                               id="province" 
                                               name="province" 
                                               value="{{ old('province', $household->province) }}">
                                        @error('province')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="city_municipality" class="form-label">City/Municipality</label>
                                        <input type="text" 
                                               class="form-control @error('city_municipality') is-invalid @enderror" 
                                               id="city_municipality" 
                                               name="city_municipality" 
                                               value="{{ old('city_municipality', $household->city_municipality) }}">
                                        @error('city_municipality')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="barangay" class="form-label">Barangay</label>
                                        <input type="text" 
                                               class="form-control @error('barangay') is-invalid @enderror" 
                                               id="barangay" 
                                               name="barangay" 
                                               value="{{ old('barangay', $household->barangay) }}">
                                        @error('barangay')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                        <select class="form-select @error('status') is-invalid @enderror" 
                                                id="status" 
                                                name="status" 
                                                required>
                                            <option value="Active" {{ old('status', $household->status) == 'Active' ? 'selected' : '' }}>Active</option>
                                            <option value="Inactive" {{ old('status', $household->status) == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                                        </select>
                                        @error('status')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="household_address" class="form-label">Household Address</label>
                                        <textarea class="form-control @error('household_address') is-invalid @enderror" 
                                                  id="household_address" 
                                                  name="household_address" 
                                                  rows="3">{{ old('household_address', $household->household_address) }}</textarea>
                                        @error('household_address')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
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
                                            <i class="mdi mdi-content-save"></i> Update Household
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
