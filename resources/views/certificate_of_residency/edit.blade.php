@extends('layouts.adminLayout.index')

@section('content')
<div class="animate__animated p-6" :class="[$store.app.animation]">
    <div class="panel">
        <div class="flex items-center justify-between mb-5">
            <h5 class="font-semibold text-lg dark:text-white-light">Edit Certificate of Residency</h5>
        </div>
        <div class="mb-5">
            <form id="editCertificateForm" action="{{ route('certificate-of-residency.update', $certificate->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
                    <div>
                        <label class="form-label">Resident <span class="text-red-500">*</span></label>
                        <select class="form-select" name="resident_id" required>
                            @foreach($residents as $resident)
                                <option value="{{ $resident->id }}" {{ $certificate->resident_id == $resident->id ? 'selected' : '' }}>
                                    {{ $resident->last_name }}, {{ $resident->first_name }} {{ $resident->middle_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="form-label">Purpose <span class="text-red-500">*</span></label>
                        <input type="text" class="form-input" name="purpose" required 
                               value="{{ $certificate->purpose }}" placeholder="Purpose of certificate">
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-4">
                    <div>
                        <label class="form-label">Cedula Number</label>
                        <input type="text" class="form-input" name="cedula_number" 
                               value="{{ $certificate->cedula_number }}" placeholder="Cedula Number">
                    </div>
                    <div>
                        <label class="form-label">Date of Issuance <span class="text-red-500">*</span></label>
                        <input type="date" class="form-input" name="date_of_issuance" required 
                               value="{{ $certificate->date_of_issuance->format('Y-m-d') }}">
                    </div>
                    <div>
                        <label class="form-label">OR Number</label>
                        <input type="text" class="form-input" name="or_number" 
                               value="{{ $certificate->or_number }}" placeholder="OR Number">
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
                    <div>
                        <label class="form-label">Amount Paid</label>
                        <input type="number" step="0.01" class="form-input" name="amount_paid" 
                               value="{{ $certificate->amount_paid }}" placeholder="0.00">
                    </div>
                    <div>
                        <label class="form-label">Status</label>
                        <select class="form-select" name="status">
                            <option value="Issued" {{ $certificate->status == 'Issued' ? 'selected' : '' }}>Issued</option>
                            <option value="Pending" {{ $certificate->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                            <option value="Cancelled" {{ $certificate->status == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                    </div>
                </div>
                
                <div class="mb-4">
                    <label class="form-label">Remarks</label>
                    <textarea class="form-textarea" name="remarks" rows="2" 
                              placeholder="Additional notes">{{ $certificate->remarks }}</textarea>
                </div>
                
                <div class="mt-8 flex items-center justify-end">
                    <a href="{{ route('certificate-of-residency.index') }}" class="btn btn-outline-danger">Cancel</a>
                    <button type="submit" class="btn btn-primary ltr:ml-4 rtl:mr-4">Update Certificate</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('editCertificateForm');
    
    form.addEventListener('submit', function(e) {
        const requiredFields = form.querySelectorAll('[required]');
        let isValid = true;
        
        requiredFields.forEach(field => {
            if (!field.value.trim()) {
                field.style.borderColor = 'red';
                isValid = false;
                
                if (!field.nextElementSibling || !field.nextElementSibling.classList.contains('error-message')) {
                    const errorMsg = document.createElement('div');
                    errorMsg.className = 'error-message text-red-500 text-sm mt-1';
                    errorMsg.textContent = 'This field is required';
                    field.parentNode.insertBefore(errorMsg, field.nextSibling);
                }
            } else {
                field.style.borderColor = '';
                const errorMsg = field.nextElementSibling;
                if (errorMsg && errorMsg.classList.contains('error-message')) {
                    errorMsg.remove();
                }
            }
        });
        
        if (!isValid) {
            e.preventDefault();
            Swal.fire({
                icon: 'error',
                title: 'Validation Error',
                text: 'Please fill in all required fields',
            });
        }
    });
    
    form.querySelectorAll('[required]').forEach(field => {
        field.addEventListener('input', function() {
            if (this.value.trim()) {
                this.style.borderColor = '';
                const errorMsg = this.nextElementSibling;
                if (errorMsg && errorMsg.classList.contains('error-message')) {
                    errorMsg.remove();
                }
            }
        });
    });
});
</script>
@endsection