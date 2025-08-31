@extends('layouts.adminLayout.index')

@section('content')
<div class="animate__animated p-6" :class="[$store.app.animation]">
    <!-- Breadcrumb -->
    <ul class="flex space-x-2 rtl:space-x-reverse">
        <li>
            <a href="{{ route('dashboard.residentsgraph') }}" class="text-primary hover:underline">Dashboard</a>
        </li>
        <li class="before:content-['/'] ltr:before:mr-2 rtl:before:ml-2">
            <a href="{{ route('households.index') }}" class="text-primary hover:underline">Household Records</a>
        </li>
        <li class="before:content-['/'] ltr:before:mr-2 rtl:before:ml-2">
            <span>Add New Household</span>
        </li>
    </ul>

    <div class="pt-5">
        <div class="mb-5">
            <h5 class="text-lg font-semibold dark:text-white-light">Add New Household</h5>
        </div>

        <div class="panel">
            <div class="mb-5">
                <h6 class="text-lg font-semibold">Household Information</h6>
            </div>
            
            <form action="{{ route('households.store') }}" method="POST">
                @csrf
                
                <div class="mb-5 grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div>
                        <label for="household_number" class="form-label">Household Number</label>
                        <input 
                            id="household_number" 
                            name="household_number" 
                            type="text" 
                            placeholder="Leave blank for auto-generation" 
                            class="form-input @error('household_number') border-red-500 @enderror" 
                            value="{{ old('household_number') }}"
                        />
                        @error('household_number')
                            <div class="mt-1 text-danger">{{ $message }}</div>
                        @enderror
                        <div class="mt-1 text-xs text-white-dark">Leave blank to auto-generate household number</div>
                    </div>

                    <div>
                        <label for="region" class="form-label">Region</label>
                        <input 
                            id="region" 
                            name="region" 
                            type="text" 
                            placeholder="Enter region" 
                            class="form-input @error('region') border-red-500 @enderror" 
                            value="{{ old('region') }}"
                        />
                        @error('region')
                            <div class="mt-1 text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-5 grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div>
                        <label for="province" class="form-label">Province</label>
                        <input 
                            id="province" 
                            name="province" 
                            type="text" 
                            placeholder="Enter province" 
                            class="form-input @error('province') border-red-500 @enderror" 
                            value="{{ old('province') }}"
                        />
                        @error('province')
                            <div class="mt-1 text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div>
                        <label for="city_municipality" class="form-label">City/Municipality</label>
                        <input 
                            id="city_municipality" 
                            name="city_municipality" 
                            type="text" 
                            placeholder="Enter city/municipality" 
                            class="form-input @error('city_municipality') border-red-500 @enderror" 
                            value="{{ old('city_municipality') }}"
                        />
                        @error('city_municipality')
                            <div class="mt-1 text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-5 grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div>
                        <label for="barangay" class="form-label">Barangay</label>
                        <input 
                            id="barangay" 
                            name="barangay" 
                            type="text" 
                            placeholder="Enter barangay" 
                            class="form-input @error('barangay') border-red-500 @enderror" 
                            value="{{ old('barangay') }}"
                        />
                        @error('barangay')
                            <div class="mt-1 text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div>
                        <label for="household_address" class="form-label">Household Address</label>
                        <textarea 
                            id="household_address" 
                            name="household_address" 
                            rows="3" 
                            placeholder="Enter complete household address" 
                            class="form-textarea @error('household_address') border-red-500 @enderror"
                        >{{ old('household_address') }}</textarea>
                        @error('household_address')
                            <div class="mt-1 text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mt-8 flex items-center justify-end">
                    <a href="{{ route('households.index') }}" class="btn btn-outline-danger">
                        Cancel
                    </a>
                    <button type="submit" class="btn btn-primary ltr:ml-4 rtl:mr-4">
                        Create Household
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
