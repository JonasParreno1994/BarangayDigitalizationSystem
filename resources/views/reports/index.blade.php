@extends('layouts.adminLayout.index')

@section('content')
<div class="container mt-4">
    <div class="card shadow-lg border-0">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">📄 Generate Certificate Reports</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('reports.generate') }}" method="POST" target="_blank">
                @csrf
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="certificate_type" class="form-label">Certificate Type</label>
                        <select class="form-select" id="certificate_type" name="certificate_type" required>
                            <option value="all">All Certificates</option>
                            <option value="clearance">Barangay Clearance</option>
                            <option value="indigency">Barangay Indigency</option>
                            <option value="moral">Certification of Good Moral</option>
                            <option value="residency">Certification of Residency</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="status" name="status">
                            <option value="all">All Statuses</option>
                            <option value="issued">Issued</option>
                            <option value="pending">Pending</option>
                            <option value="rejected">Rejected</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="date_from" class="form-label">Date From</label>
                        <input type="date" class="form-control" id="date_from" name="date_from">
                    </div>
                    <div class="col-md-6">
                        <label for="date_to" class="form-label">Date To</label>
                        <input type="date" class="form-control" id="date_to" name="date_to">
                    </div>
                </div>

                <div class="d-flex justify-content-end mt-4">
                    <button type="submit" class="btn btn-success px-4">
                        <i class="bi bi-file-earmark-text"></i> Generate Report
                    </button>
                </div>
            </form>

            {{-- Hidden print form (if used via Vue or JS binding later) --}}
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
@endsection
