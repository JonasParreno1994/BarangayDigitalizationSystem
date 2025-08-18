@extends('layouts.adminLayout.index')

@section('content')
<div class="animate__animated p-6" :class="[$store.app.animation]">
    <div class="panel">
        <div class="flex items-center justify-between mb-5">
            <h5 class="font-semibold text-lg dark:text-white-light">Issue Death Certificate</h5>
        </div>
        
        <form action="{{ route('certificate-of-death.store') }}" method="POST">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label for="resident_id" class="form-label">Resident <span class="text-red-500">*</span></label>
                    <select name="resident_id" id="resident_id" class="form-select" required>
                        <option value="">Select Resident</option>
                        @foreach($residents as $resident)
                            <option value="{{ $resident->id }}">
                                {{ $resident->last_name }}, {{ $resident->first_name }} {{ $resident->middle_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="certificate_number" class="form-label">Certificate Number <span class="text-red-500">*</span></label>
                    <input type="text" name="certificate_number" id="certificate_number" class="form-input" required>
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label for="date_of_death" class="form-label">Date of Death <span class="text-red-500">*</span></label>
                    <input type="date" name="date_of_death" id="date_of_death" class="form-input" required>
                </div>
                <div>
                    <label for="place_of_death" class="form-label">Place of Death <span class="text-red-500">*</span></label>
                    <input type="text" name="place_of_death" id="place_of_death" class="form-input" required>
                </div>
            </div>
            
            <div class="mb-4">
                <label for="cause_of_death" class="form-label">Cause of Death <span class="text-red-500">*</span></label>
                <input type="text" name="cause_of_death" id="cause_of_death" class="form-input" required>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label for="date_of_issuance" class="form-label">Date of Issuance <span class="text-red-500">*</span></label>
                    <input type="date" name="date_of_issuance" id="date_of_issuance" class="form-input" required value="{{ date('Y-m-d') }}">
                </div>
                <div>
                    <label for="issued_by" class="form-label">Issued By <span class="text-red-500">*</span></label>
                    <input type="text" name="issued_by" id="issued_by" class="form-input" required>
                </div>
            </div>
            
            <div class="mb-4">
                <label for="remarks" class="form-label">Remarks</label>
                <textarea name="remarks" id="remarks" rows="3" class="form-textarea"></textarea>
            </div>
            
            <div class="flex justify-end mt-6">
                <button type="submit" class="btn btn-primary">Issue Certificate</button>
            </div>
        </form>
    </div>
</div>
@endsection