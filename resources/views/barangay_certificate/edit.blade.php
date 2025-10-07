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

    .select2-container--default .select2-selection--single {
        height: 42px;
        border: 1px solid #d1d5db;
        border-radius: 0.375rem;
        background-color: #fff;
    }

    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 42px;
        padding-left: 12px;
    }

    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 40px;
    }
</style>

<div class="animate__animated p-6">
    <div class="panel">
        <div class="flex items-center justify-between mb-5">
            <h1 class="text-2xl font-bold">Edit Barangay Certificate</h1>
            <a href="{{ route('barangay-certificate.index') }}" class="btn btn-primary">
                <i class="fas fa-arrow-left mr-2"></i>Back to List
            </a>
        </div>

        <form action="{{ route('barangay-certificate.update', $certificate->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
                <div>
                    <label class="form-label">Resident <span class="text-red-500">*</span></label>
                    <select class="form-select resident-search" name="resident_id" id="residentSelect" required>
                        <option value="">Select Resident</option>
                        @foreach($residents as $resident)
                            <option value="{{ $resident->id }}" {{ $certificate->resident_id == $resident->id ? 'selected' : '' }}>
                                {{ $resident->last_name }}, {{ $resident->first_name }} {{ $resident->middle_name }}
                            </option>
                        @endforeach
                    </select>
                    @error('resident_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="form-label">Purpose <span class="text-red-500">*</span></label>
                    <input type="text" class="form-input" name="purpose" required 
                           value="{{ old('purpose', $certificate->purpose) }}" 
                           placeholder="Purpose of certificate">
                    @error('purpose')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-4">
                <div>
                    <label class="form-label">Residence Period (Years)</label>
                    <input type="number" class="form-input" name="residence_period_years" min="0" 
                           value="{{ old('residence_period_years', $certificate->residence_period_years) }}" 
                           placeholder="Years">
                    @error('residence_period_years')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="form-label">Residence Period (Months)</label>
                    <input type="number" class="form-input" name="residence_period_months" min="0" max="11" 
                           value="{{ old('residence_period_months', $certificate->residence_period_months) }}" 
                           placeholder="Months">
                    @error('residence_period_months')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="form-label">Cedula Number</label>
                    <input type="text" class="form-input" name="cedula_number" 
                           value="{{ old('cedula_number', $certificate->cedula_number) }}" 
                           placeholder="Cedula Number">
                    @error('cedula_number')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="form-label">Date of Issuance <span class="text-red-500">*</span></label>
                    <input type="date" class="form-input" name="date_of_issuance" required 
                           value="{{ old('date_of_issuance', $certificate->date_of_issuance->format('Y-m-d')) }}">
                    @error('date_of_issuance')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-4">
                <div>
                    <label class="form-label">OR Number</label>
                    <input type="text" class="form-input" name="or_number" 
                           value="{{ old('or_number', $certificate->or_number) }}" 
                           placeholder="OR Number">
                    @error('or_number')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="form-label">Amount Paid (₱)</label>
                    <input type="number" class="form-input" name="amount_paid" step="0.01" min="0" 
                           value="{{ old('amount_paid', $certificate->amount_paid) }}" 
                           placeholder="Amount">
                    @error('amount_paid')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="form-label">Status <span class="text-red-500">*</span></label>
                    <select class="form-select" name="status" required>
                        <option value="Issued" {{ old('status', $certificate->status) == 'Issued' ? 'selected' : '' }}>Issued</option>
                        <option value="Pending" {{ old('status', $certificate->status) == 'Pending' ? 'selected' : '' }}>Pending</option>
                        <option value="Cancelled" {{ old('status', $certificate->status) == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                    @error('status')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            
            <div class="mb-4">
                <label class="form-label">Remarks</label>
                <textarea class="form-textarea" name="remarks" rows="3" 
                          placeholder="Optional remarks">{{ old('remarks', $certificate->remarks) }}</textarea>
                @error('remarks')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="flex items-center justify-end gap-4">
                <a href="{{ route('barangay-certificate.index') }}" class="btn btn-outline-danger">Cancel</a>
                <button type="submit" class="btn btn-primary">Update Certificate</button>
            </div>
        </form>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#residentSelect').select2({
            theme: 'bootstrap4',
            placeholder: 'Select Resident',
            allowClear: true,
            width: '100%'
        });
    });
</script>

@endsection