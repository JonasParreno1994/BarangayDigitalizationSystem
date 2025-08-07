@extends('layouts.adminLayout.index')

@section('content')
<div class="container py-5">
    <div class="card shadow-lg border-0 rounded-4">
        <div class="card-header bg-gradient-primary text-white rounded-top-4 py-3 text-center">
            <h1 class="mb-0 fw-bold">
                📄 Generate Certificate Reports
            </h1>
            <small class="text-light">Filter and generate customized certificate reports instantly</small>
        </div>
        <div class="card-body bg-light p-4">
            <form action="{{ route('reports.generate') }}" method="POST" target="_blank">
                @csrf
                
                <!-- Certificate Type and Status Row -->
                <div class="row g-3 mb-4 align-items-end">
                    <!-- Certificate Type -->
                    <div class="col-md-6 col-sm-12">
                        <label for="certificate_type" class="form-label fw-semibold">Certificate Type</label>
                        <select class="form-select shadow-sm" id="certificate_type" name="certificate_type" required>
                            <option value="all">📑 All Certificates</option>
                            <option value="clearance">📝 Barangay Clearance</option>
                            <option value="indigency">🤝 Barangay Indigency</option>
                            <option value="moral">✅ Certification of Good Moral</option>
                            <option value="residency">🏠 Certification of Residency</option>
                        </select>
                  
                        <label for="status" class="form-label fw-semibold">Status</label>
                        <select class="form-select shadow-sm" id="status" name="status">
                            <option value="all">📋 All Statuses</option>
                            <option value="issued">✅ Issued</option>
                            <option value="pending">⏳ Pending</option>
                            <option value="rejected">❌ Rejected</option>
                        </select>
                    </div>
                </div>
        
                <!-- Date From and Date To Row -->
                <div class="row g-3 mb-4 align-items-end">
                    <!-- Date From -->
                    <div class="col-md-6 col-sm-12">
                        <label for="date_from" class="form-label fw-semibold">Date From:
                        <input type="date" class="form-control shadow-sm" id="date_from" name="date_from" required>
                     Date To:<input type="date" class="form-control shadow-sm" id="date_to" name="date_to" required>
                    </div>
                </div>
        
                <!-- Submit Button -->
                <div class="d-flex justify-content-end mt-4">
                    <button type="submit" class="btn btn-success px-5 py-2 shadow-sm fw-semibold">
                        <i class="bi bi-file-earmark-text me-2"></i> Generate Report
                    </button>
                </div>
            </form>
        
            {{-- Optional Hidden Form (For JS/Vue Integration) --}}
            <form id="print-form" action="{{ route('reports.print') }}" method="POST" target="_blank" style="display: none;">
                @csrf
                <input type="hidden" name="certificate_type" :value="certificate_type">
                <input type="hidden" name="status" :value="status">
                <input type="hidden" name="date_from" :value="date_from">
                <input type="hidden" name="date_to" :value="date_to">
            </form>
        </div>
        
    </div>
</div>

{{-- Optional Styling for a More Polished Look --}}
<style>
    .bg-gradient-primary {
        background: linear-gradient(135deg, #007bff, #0056b3);
    }
    .card {
        border-radius: 1rem;
    }
    .form-label {
        color: #333;
    }
    select.form-select, input.form-control {
        border-radius: 0.5rem;
    }
    button.btn-success {
        border-radius: 0.5rem;
        font-size: 1.1rem;
    }
</style>
@endsection
