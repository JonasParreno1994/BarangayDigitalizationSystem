@extends('layouts.adminLayout.index')

@section('content')
<div class="animate__animated p-6" :class="[$store.app.animation]">
    <div class="panel">
        <div class="flex items-center justify-between mb-5">
            <h1 class="text-2xl font-bold">Edit Good Moral Certificate</h1>
            <a href="{{ route('barangaygoodmoral.index') }}" class="btn btn-outline-secondary">Back to List</a>
        </div>

        <form action="{{ route('barangaygoodmoral.update', $certificate->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="form-label">Resident <span class="text-red-500">*</span></label>
                        <select class="form-input" name="resident_id" required>
                            @foreach($residents as $resident)
                                <option value="{{ $resident->id }}" {{ $certificate->resident_id == $resident->id ? 'selected' : '' }}>
                                    {{ $resident->last_name }}, {{ $resident->first_name }} {{ $resident->middle_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="form-label">Purpose <span class="text-red-500">*</span></label>
                        <input type="text" class="form-input" name="purpose" required value="{{ $certificate->purpose }}">
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="form-label">Cedula Number</label>
                        <input type="text" class="form-input" name="cedula_number" value="{{ $certificate->cedula_number }}">
                    </div>
                    <div>
                        <label class="form-label">Date of Issuance <span class="text-red-500">*</span></label>
                        <input type="date" class="form-input" name="date_of_issuance" required value="{{ $certificate->date_of_issuance->format('Y-m-d') }}">
                    </div>
                    <div>
                        <label class="form-label">OR Number</label>
                        <input type="text" class="form-input" name="or_number" value="{{ $certificate->or_number }}">
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="form-label">Amount Paid</label>
                        <input type="number" step="0.01" class="form-input" name="amount_paid" value="{{ $certificate->amount_paid }}">
                    </div>
                    <div>
                        <label class="form-label">Status</label>
                        <select class="form-input" name="status">
                            <option value="Issued" {{ $certificate->status == 'Issued' ? 'selected' : '' }}>Issued</option>
                            <option value="Pending" {{ $certificate->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                            <option value="Cancelled" {{ $certificate->status == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                    </div>
                </div>
                
                <div>
                    <label class="form-label">Remarks</label>
                    <textarea class="form-input" name="remarks" rows="3">{{ $certificate->remarks }}</textarea>
                </div>
                
                <div class="pt-4 flex justify-end space-x-3">
                    <a href="{{ route('barangaygoodmoral.index') }}" class="btn btn-outline-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary">Update Certificate</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection