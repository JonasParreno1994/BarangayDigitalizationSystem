@extends('layouts.adminLayout.index')

@section('content')
<div class="animate__animated p-6" :class="[$store.app.animation]">
    <div class="panel">
        <div class="flex items-center justify-between mb-5">
            <h1 class="text-2xl font-bold">Edit Barangay Clearance</h1>
            <a href="{{ route('barangayclearance.index') }}" class="btn btn-outline-primary">Back to List</a>
        </div>

        <form action="{{ route('barangayclearance.update', $clearance->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
                <div>
                    <label class="form-label">Resident <span class="text-red-500">*</span></label>
                    <select class="form-select" name="resident_id" required>
                        <option value="">Select Resident</option>
                        @foreach($residents as $resident)
                            <option value="{{ $resident->id }}" {{ $clearance->resident_id == $resident->id ? 'selected' : '' }}>
                                {{ $resident->last_name }}, {{ $resident->first_name }} {{ $resident->middle_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="form-label">Purpose <span class="text-red-500">*</span></label>
                    <input type="text" class="form-input" name="purpose" required value="{{ $clearance->purpose }}">
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-4">
                <div>
                    <label class="form-label">Cedula Number</label>
                    <input type="text" class="form-input" name="cedula_number" value="{{ $clearance->cedula_number }}">
                </div>
                <div>
                    <label class="form-label">Date of Issuance <span class="text-red-500">*</span></label>
                    <input type="date" class="form-input" name="date_of_issuance" required value="{{ $clearance->date_of_issuance->format('Y-m-d') }}">
                </div>
                <div>
                    <label class="form-label">OR Number</label>
                    <input type="text" class="form-input" name="or_number" value="{{ $clearance->or_number }}">
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
                <div>
                    <label class="form-label">Amount Paid</label>
                    <input type="number" step="0.01" class="form-input" name="amount_paid" value="{{ $clearance->amount_paid }}">
                </div>
                <div>
                    <label class="form-label">Status</label>
                    <select class="form-select" name="status">
                        <option value="Issued" {{ $clearance->status == 'Issued' ? 'selected' : '' }}>Issued</option>
                        <option value="Pending" {{ $clearance->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                        <option value="Cancelled" {{ $clearance->status == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>
            </div>
            
            <div class="mb-4">
                <label class="form-label">Remarks</label>
                <textarea class="form-textarea" name="remarks" rows="2">{{ $clearance->remarks }}</textarea>
            </div>
            
            <div class="mt-8 flex items-center justify-end">
                <button type="button" class="btn btn-outline-danger" onclick="window.location.href='{{ route('barangayclearance.index') }}'">Cancel</button>
                <button type="submit" class="btn btn-primary ltr:ml-4 rtl:mr-4">Update Clearance</button>
            </div>
        </form>
    </div>
</div>
@endsection