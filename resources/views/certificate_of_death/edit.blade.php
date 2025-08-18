@extends('layouts.adminLayout.index')

@section('content')
<div class="animate__animated p-6" :class="[$store.app.animation]">
    <div class="panel">
        <div class="flex items-center justify-between mb-5">
            <h1 class="text-2xl font-bold">Edit Death Certificate</h1>
            <a href="{{ route('certificate-of-death.index') }}" class="btn btn-outline-primary">Back to List</a>
        </div>

        <form action="{{ route('certificate-of-death.update', $certificate->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
                <div>
                    <label class="form-label">Resident <span class="text-red-500">*</span></label>
                    <select class="form-select" name="resident_id" required>
                        <option value="">Select Resident</option>
                        @foreach($residents as $resident)
                            <option value="{{ $resident->id }}" {{ $certificate->resident_id == $resident->id ? 'selected' : '' }}>
                                {{ $resident->last_name }}, {{ $resident->first_name }} {{ $resident->middle_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="form-label">Certificate Number <span class="text-red-500">*</span></label>
                    <input type="text" class="form-input" name="certificate_number" required value="{{ $certificate->certificate_number }}">
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
                <div>
                    <label class="form-label">Date of Death <span class="text-red-500">*</span></label>
                    <input type="date" class="form-input" name="date_of_death" required value="{{ $certificate->date_of_death instanceof \Carbon\Carbon ? $certificate->date_of_death->format('Y-m-d') : $certificate->date_of_death }}">
                </div>
                <div>
                    <label class="form-label">Place of Death <span class="text-red-500">*</span></label>
                    <input type="text" class="form-input" name="place_of_death" required value="{{ $certificate->place_of_death }}">
                </div>
            </div>
            
            <div class="mb-4">
                <label class="form-label">Cause of Death <span class="text-red-500">*</span></label>
                <input type="text" class="form-input" name="cause_of_death" required value="{{ $certificate->cause_of_death }}">
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
                <div>
                    <label class="form-label">Date of Issuance <span class="text-red-500">*</span></label>
                    <input type="date" class="form-input" name="date_of_issuance" required value="{{ $certificate->date_of_issuance }}">
                </div>
                <div>
                    <label class="form-label">Issued By <span class="text-red-500">*</span></label>
                    <input type="text" class="form-input" name="issued_by" required value="{{ $certificate->issued_by }}">
                </div>
            </div>
            
            <div class="mb-4">
                <label class="form-label">Remarks</label>
                <textarea class="form-textarea" name="remarks" rows="2">{{ $certificate->remarks }}</textarea>
            </div>
            
            <div class="mt-8 flex items-center justify-end">
                <button type="button" class="btn btn-outline-danger" onclick="window.location.href='{{ route('certificate-of-death.index') }}'">Cancel</button>
                <button type="submit" class="btn btn-primary ltr:ml-4 rtl:mr-4">Update Certificate</button>
            </div>
        </form>
    </div>
</div>
@endsection